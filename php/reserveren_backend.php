<?php

include('../database.php');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

session_start();

$groep_id = $_GET['groep_id'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];
$reden = $_GET['reden'];
$aantal = $_GET['aantal'];
$user_id = $_SESSION['user_id'];


$select_query = "SELECT PRODUCT.product_id
FROM PRODUCT
         JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
WHERE datumBeschikbaar BETWEEN ? AND ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND GROEP.groep_id = ?";


$select_stmt = $conn->prepare($select_query);
$select_stmt->bind_param("sss", $startDatum, $eindDatum, $groep_id);
$select_stmt->execute();
$result = $select_stmt->get_result();


$product_ids = array();


while ($row = $result->fetch_assoc()) {
    $product_ids[] = $row['product_id'];
}


if (count($product_ids) < $aantal) {
    echo json_encode(array("success" => false, "error" => "Niet genoeg beschikbare producten"));
    exit;
}


for ($i = 0; $i < $aantal; $i++) {
    $product_id = $product_ids[$i];


    $update_query = "UPDATE PRODUCT SET isUitgeleend = true, datumBeschikbaar = ? WHERE product_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ss", $eindDatum, $product_id);    
    $update_success = $update_stmt->execute();

    if (!$update_success) {
        echo json_encode(array("success" => false, "error" => "Fout bij het bijwerken van product status: " . $conn->error));
        exit;
    }

    $insert_query = "INSERT INTO MIJN_LENINGEN (Uitleendatum, terugbrengDatum, user_id_fk, product_id_fk, kit_id_fk, reden_id_fk) VALUES (?, ?, ?, ?, null, ?)";


    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sssss", $startDatum, $eindDatum, $user_id, $product_id, $reden);
    $insert_success = $insert_stmt->execute();

    if (!$insert_success) {
        echo json_encode(array("success" => false, "error" => "Fout bij het maken van de reservering: " . $conn->error));
        exit;
    }
}


echo json_encode(array("success" => true));

?>
