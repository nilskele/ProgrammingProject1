<?php
    include('../database.php'); 
    if (!isset($_GET['groep_id'])) {
        die('Error: groep_id is required');

    }

    $groep_id = $_GET['groep_id']; // Correct variable to use in the SQL query

    // SQL statement to prevent SQL injection
    $stmt = $conn->prepare("
        SELECT 
            GROEP.groep_id AS groep_id, 
            GROEP.naam AS groep_naam, 
            MERK.naam AS merk_naam, 
            PRODUCT.opmerkingen, 
            BESCHRIJVING.naam AS beschrijving_naam, 
            MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar, 
            COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten,
            IMAGE.image_data
        FROM GROEP 
        INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id 
        INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id 
        INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id 
        INNER JOIN IMAGE ON GROEP.image_id_fk =  IMAGE.image_id
        WHERE GROEP.groep_id = ?
        GROUP BY GROEP.groep_id, GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam, IMAGE.image_data
    ");

    $stmt->bind_param("i", $groep_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die('Error: Geen product gevonden met het opgegeven ID');
    }

    $product = $result->fetch_assoc();
    $stmt->close();
    ?>
