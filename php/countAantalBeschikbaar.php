<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$response = [];

$stmt = $conn->prepare("SELECT GROEP.naam AS groep_naam, COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten
FROM GROEP
         JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
WHERE GROEP.groep_id = '1' AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false
GROUP BY GROEP.naam");

$stmt->execute();

$resultaten = $stmt->get_result();

if ($resultaten->num_rows > 0) {
    while ($row = $resultaten->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response['error'] = "Geen resultaten gevonden";
}

$stmt->close();

echo json_encode($response)

?>

