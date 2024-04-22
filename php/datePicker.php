<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];

$sql = "SELECT GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, PRODUCT.datumBeschikbaar
    FROM GROEP
    INNER JOIN MERK ON GROEP.groep_id = MERK.merk_id
    INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
    INNER JOIN BESCHRIJVING ON PRODUCT.product_id = BESCHRIJVING.besch_id
    WHERE PRODUCT.datumBeschikbaar BETWEEN ? AND ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDatum, $eindDatum);
$stmt->execute();

$result = $stmt->get_result();

$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>
