<?php
    include('../database.php'); 

    if (!isset($_GET['groep_id']) || !isset($_GET['isKit'])) {
        die('Error: groep_id and isKit are required');
    }
    
    $groep_id = $_GET['groep_id'];
    $isKit = $_GET['isKit'];
    
    if ($isKit == 1) {
        // fetch van alle producten die beschikbaar zijn in de kit
        $stmt = $conn->prepare("SELECT KIT.kit_id AS groep_id, KIT.kit_naam AS groep_naam, MERK.naam AS merk_naam, MIN(KIT.datumBeschikbaar) AS datumBeschikbaar,
        (SELECT COUNT(*)
        FROM GROEP
              JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
        WHERE PRODUCT.isUitgeleend = false and PRODUCT.zichtbaar = true
        GROUP BY GROEP.groep_id
        ORDER BY COUNT(*) asc
        limit 1) AS aantal_beschikbare_producten,
        IMAGE.image_data
        FROM KIT
        INNER JOIN MERK ON KIT.merk_fk = MERK.merk_id
        INNER JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
        WHERE KIT.zichtbaar = true AND KIT.kit_id = ?
        GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, IMAGE.image_data");
    } else {
        // fetch van alle producten
        $stmt = $conn->prepare("SELECT GROEP.groep_id AS groep_id, GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar,
        COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten, IMAGE.image_data
        FROM GROEP
        INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
        INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
        INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
        INNER JOIN IMAGE ON GROEP.image_id_fk = IMAGE.image_id
        WHERE PRODUCT.zichtbaar = true AND GROEP.groep_id = ?
        GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data");
    }
    
    $stmt->bind_param("i", $groep_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die('Error: Geen product gevonden met het opgegeven ID');
    }
    
    $product = $result->fetch_assoc();
    $stmt->close();
    
    ?>
