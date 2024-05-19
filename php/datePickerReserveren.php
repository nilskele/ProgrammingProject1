<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$isKit = $_GET['isKit'];
$groep_id = $_GET['groep_id'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];

if ($isKit == 1) {
    $sql = "SELECT
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantalBeschikbaar
FROM KIT
      JOIN MERK ON KIT.merk_fk = MERK.merk_id
      LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
      LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
      JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
WHERE KIT.datumBeschikbaar <= ? AND KIT.isUitgeleend = false AND KIT.zichtbaar = true AND KIT.kit_id = ?
AND EXISTS (
 SELECT 1 FROM PRODUCT
 WHERE PRODUCT.groep_id = GROEP.groep_id
   AND PRODUCT.zichtbaar = true
)
GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, KIT.opmerkingen, IMAGE.image_data
HAVING COUNT(DISTINCT KIT_PRODUCT.groep_id_fk) >= (
 SELECT COUNT(*)
 FROM KIT_PRODUCT
 WHERE KIT_PRODUCT.kit_id_fk = KIT.kit_id
);";
} else {
    $sql = "SELECT COUNT(*) AS aantalBeschikbaar
            FROM PRODUCT
            JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
            WHERE PRODUCT.datumBeschikbaar < ? AND PRODUCT.zichtbaar = true AND GROEP.groep_id = ?";
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ss", $eindDatum, $groep_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Get result failed: " . $stmt->error);
}

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>
