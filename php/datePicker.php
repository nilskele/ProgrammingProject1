<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum']; 

$sql = "SELECT GROEP.groep_id AS groep_id, GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar, COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten, IMAGE.image_data
FROM GROEP
         INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
         INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
         INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
         INNER JOIN IMAGE ON GROEP.image_id_fk =  IMAGE.image_id
WHERE PRODUCT.datumBeschikbaar BETWEEN ? AND ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false
GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data

UNION

SELECT KIT.kit_id, KIT.kit_naam AS groep_naam, MERK.naam AS merk_naam, KIT.opmerkingen, GROUP_CONCAT(GROEP.naam) AS beschrijving_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar ,
       (SELECT COUNT(*)
        FROM GROEP
                 JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
        WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
        GROUP BY GROEP.groep_id
        ORDER BY COUNT(*) asc
        limit 1) AS aantal_beschikbare_producten,
       IMAGE.image_data
FROM KIT
         JOIN MERK ON KIT.merk_fk = MERK.merk_id
         LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
         LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
         JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
WHERE KIT.datumBeschikbaar BETWEEN ? AND ? AND KIT.isUitgeleend = false AND KIT.zichtbaar = true
  AND EXISTS (
    SELECT 1 FROM PRODUCT
    WHERE PRODUCT.groep_id = GROEP.groep_id
      AND PRODUCT.isUitgeleend = false
      AND PRODUCT.zichtbaar = true
)
GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, KIT.opmerkingen, IMAGE.image_data
HAVING COUNT(DISTINCT KIT_PRODUCT.groep_id_fk) >= (
    SELECT COUNT(*)
    FROM KIT_PRODUCT
    WHERE KIT_PRODUCT.kit_id_fk = KIT.kit_id
);";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $startDatum, $eindDatum, $startDatum, $eindDatum);
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