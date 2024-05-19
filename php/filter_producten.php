<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

if ($categorie !== 'All') {
    $stmt = $conn->prepare("SELECT GROEP.groep_id AS groep_id, GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar,
    COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten, IMAGE.image_data
FROM GROEP
      JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
      JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
      JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
      JOIN CATEGORY on GROEP.category_id_fk = CATEGORY.cat_id
      JOIN IMAGE ON GROEP.image_id_fk =  IMAGE.image_id
WHERE CATEGORY.naam = ? AND PRODUCT.zichtbaar = true
GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data

UNION

SELECT KIT.kit_id, KIT.kit_naam, MERK.naam AS merk_naam, KIT.opmerkingen, GROUP_CONCAT(GROEP.naam) AS beschrijving_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar ,
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.zichtbaar = true
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantal_beschikbare_producten,
    IMAGE.image_data
FROM KIT
      JOIN CATEGORY AS CAT1 ON KIT.category_fk = CAT1.cat_id
      JOIN MERK ON KIT.merk_fk = MERK.merk_id
      LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
      LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
      JOIN CATEGORY AS CAT2 ON KIT.category_fk = CAT2.cat_id
      LEFT JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
WHERE CAT2.naam = ?
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
    $stmt->bind_param("ss", $categorie, $categorie);

    $stmt->execute();

    $resultaten = $stmt->get_result();

    $response = [];
    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['error'] = "Geen resultaten gevonden voor deze categorie: " . $categorie;
    }

    $stmt->close();

    $json = json_encode($response);
    echo $json;
}
?>