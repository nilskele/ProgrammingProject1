<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

if ($categorie === 'All') {
    $stmt = $conn->prepare("SELECT GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar, COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten
    FROM GROEP
             INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
             INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
             INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
    WHERE PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false
    GROUP BY GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam");

    $stmt->execute();

    $resultaten = $stmt->get_result();

    $response = [];
    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        
    }

    $stmt->close();

    $json = json_encode($response);
    echo $json;
}
?>