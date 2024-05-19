<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$zoekterm = isset($_GET['zoekbalk']) ? '%' . $_GET['zoekbalk'] . '%' : '%';

$response = [];

if ($zoekterm !== '%') {
    $stmt = $conn->prepare("SELECT GROEP.groep_id AS groep_id, GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar,
    COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten, IMAGE.image_data, null AS isKit
FROM GROEP
      INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
      INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
      INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
      INNER JOIN IMAGE ON GROEP.image_id_fk =  IMAGE.image_id
WHERE GROEP.naam LIKE ? AND PRODUCT.zichtbaar = true
GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data

UNION

SELECT KIT.kit_id, KIT.kit_naam, MERK.naam AS merk_naam, KIT.opmerkingen, GROUP_CONCAT(GROEP.naam) AS beschrijving_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar ,
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantal_beschikbare_producten,
    IMAGE.image_data, true AS isKit
FROM KIT
      JOIN CATEGORY ON KIT.category_fk = CATEGORY.cat_id
      JOIN MERK ON KIT.merk_fk = MERK.merk_id
      LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
      LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
      LEFT JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
WHERE kit_naam LIKE ? 
AND KIT.isUitgeleend = false
AND KIT.zichtbaar = true
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
);");
    $stmt->bind_param("ss", $zoekterm, $zoekterm);

    $stmt->execute();

    $resultaten = $stmt->get_result();

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
        echo json_encode($response);
    } else {
        unset($response);
    }

    $stmt->close();
    
} else {
    $stmt = $conn->prepare("SELECT GROEP.groep_id AS groep_id, GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar,
    COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten, IMAGE.image_data, null AS isKit
FROM GROEP
      INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
      INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
      INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
      INNER JOIN IMAGE ON GROEP.image_id_fk =  IMAGE.image_id
WHERE PRODUCT.zichtbaar = true
GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data

UNION

SELECT KIT.kit_id, KIT.kit_naam, MERK.naam AS merk_naam, KIT.opmerkingen, GROUP_CONCAT(GROEP.naam) AS beschrijving_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar ,
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantal_beschikbare_producten,
    IMAGE.image_data, true AS isKit
FROM KIT
      JOIN CATEGORY ON KIT.category_fk = CATEGORY.cat_id
      JOIN MERK ON KIT.merk_fk = MERK.merk_id
      LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
      LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
      LEFT JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
WHERE KIT.isUitgeleend = false
AND KIT.zichtbaar = true
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
);");

    $stmt->execute();

    $resultaten = $stmt->get_result();

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['error'] = "Geen resultaten gevonden2";
    }

    $stmt->close();
}



?>