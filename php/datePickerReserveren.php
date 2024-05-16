<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$groep_id = $_GET['groep_id'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];


$sql = "SELECT COUNT(*) AS aantalBeschikbaar
FROM PRODUCT
    JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
WHERE datumBeschikbaar BETWEEN ? AND ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND GROEP.groep_id = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $startDatum, $eindDatum, $groep_id);
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
