<?php 

include '../database.php';

$responnse = [];

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $query = "SELECT KIT.kit_id, KIT.kit_naam, MERK.naam AS merk_naam, KIT.opmerkingen, GROUP_CONCAT(GROEP.naam) AS beschrijving_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar ,
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantal_beschikbare_producten,
    IMAGE.image_data
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
   AND PRODUCT.isUitgeleend = false
   AND PRODUCT.zichtbaar = true
)
GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, KIT.opmerkingen, IMAGE.image_data
HAVING COUNT(DISTINCT KIT_PRODUCT.groep_id_fk) >= (
 SELECT COUNT(*)
 FROM KIT_PRODUCT
 WHERE KIT_PRODUCT.kit_id_fk = KIT.kit_id
);";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    echo json_encode($rows);

    $stmt->close();
} else {
    echo "error5";
}