<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

if ($categorie !== '') {
    $stmt = $conn->prepare("SELECT GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, MIN(PRODUCT.datumBeschikbaar) AS datumBeschikbaar
    FROM GROEP
             INNER JOIN MERK ON GROEP.merk_id_fk = MERK.merk_id
             INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
             INNER JOIN BESCHRIJVING ON GROEP.beschrijving_id_fk = BESCHRIJVING.besch_id
             INNER JOIN CATEGORY on GROEP.category_id_fk = CATEGORY.cat_id
    WHERE CATEGORY.naam = ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false

    GROUP BY GROEP.naam, MERK.naam, PRODUCT.opmerkingen, BESCHRIJVING.naam");
    $stmt->bind_param("s", $categorie);

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