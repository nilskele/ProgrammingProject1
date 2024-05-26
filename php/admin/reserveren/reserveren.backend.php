<?php

include('../../../database.php');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');



$productNr = $_GET['productNr'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];
$reden = $_GET['reden'];
$aantal = $_GET['aantal'];
$email = $_GET['email'];

$query1 = "SELECT user_id FROM USER WHERE email = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $email);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $userId = $row1['user_id'];

    // ftech van producten die beschikbaar zijn
    $query2 = "SELECT product_id FROM PRODUCT WHERE product_id = ? AND zichtbaar = true AND isUitgeleend = false AND datumBeschikbaar < ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("ss", $productNr, $eindDatum);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows == 0) {
        echo json_encode(array("success" => false, "error" => "Product niet gevonden"));
        die();
    }

    // update van producten die nog beschikbaar zijn
    $query3 = "UPDATE PRODUCT SET isUitgeleend = true, datumBeschikbaar = ? WHERE product_id = ?";
    $stmt3 = $conn->prepare($query3);
    $stmt3->bind_param("ss", $eindDatum, $productNr);
    $stmt3->execute();
    $result3 = $stmt3->get_result();

    // insert van de lening
    $query4 = "INSERT INTO MIJN_LENINGEN (Uitleendatum, terugbrengDatum, user_id_fk, product_id_fk, kit_id_fk, reden_id_fk) VALUES (?, ?, ?, ?, null, ?)";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("sssss", $startDatum, $eindDatum, $userId, $productNr, $reden);
    $stmt4->execute();
    $result4 = $stmt4->get_result();

    echo json_encode(array("success" => true));
    die();
} else {
    echo json_encode(array("success" => false, "error" => "Gebruiker niet gevonden"));
    die();
}

?>
