<?php
include "../../../database.php";


$response = [];


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $KitNr = $_GET['KitNr'];
    $startDatum = $_GET['startDatum'];
    $eindDatum = $_GET['eindDatum'];

    // Ensure all parameters are received
    if (empty($KitNr) || empty($startDatum) || empty($eindDatum)) {
        $response['error'] = "Missing parameters.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT
    (SELECT COUNT(*)
     FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
     WHERE PRODUCT.isUitgeleend = false
       AND PRODUCT.zichtbaar = true
       AND PRODUCT.datumBeschikbaar < ?
     GROUP BY GROEP.groep_id
     ORDER BY COUNT(*) asc
     limit 1) AS aantalBeschikbaar
    FROM KIT
            JOIN MERK ON KIT.merk_fk = MERK.merk_id
            LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
            LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
            JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
    WHERE KIT.datumBeschikbaar < ?
    AND KIT.zichtbaar = true
    AND KIT.kit_id = ?
    AND EXISTS (
        SELECT 1 FROM PRODUCT
        WHERE PRODUCT.groep_id = GROEP.groep_id
        AND PRODUCT.zichtbaar = true
        AND PRODUCT.isUitgeleend = false
        AND PRODUCT.datumBeschikbaar < ?
    )
    GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, KIT.opmerkingen, IMAGE.image_data
    HAVING COUNT(DISTINCT KIT_PRODUCT.groep_id_fk) >= (
        SELECT COUNT(*)
        FROM KIT_PRODUCT
        WHERE KIT_PRODUCT.kit_id_fk = KIT.kit_id
    );");
    
    if ($stmt === false) {
        $response['error'] = "Failed to prepare the SQL statement.";
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("ssss", $eindDatum, $eindDatum, $KitNr, $eindDatum); 
    $stmt->execute();

    $resultaten = $stmt->get_result();

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['error'] = "Geen resultaten gevonden.";
    }

    $stmt->close();
}

echo json_encode($response);
?>
