<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$zoekterm = isset($_GET['zoekbalk']) ? '%' . $_GET['zoekbalk'] . '%' : '%';

$response = [];

if ($zoekterm !== '%') {
    $stmt = $conn->prepare("SELECT GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, PRODUCT.datumBeschikbaar
    FROM GROEP
             INNER JOIN MERK ON GROEP.groep_id = MERK.merk_id
             INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
             INNER JOIN BESCHRIJVING ON PRODUCT.product_id = BESCHRIJVING.besch_id
    WHERE GROEP.naam LIKE ?");
    $stmt->bind_param("s", $zoekterm);

    $stmt->execute();

    $resultaten = $stmt->get_result();

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['error'] = "Geen resultaten gevonden";
    }

    $stmt->close();
    echo json_encode($response);
} else {
    $stmt = $conn->prepare("SELECT GROEP.naam AS groep_naam, MERK.naam AS merk_naam, PRODUCT.opmerkingen, BESCHRIJVING.naam AS beschrijving_naam, PRODUCT.datumBeschikbaar
    FROM GROEP
             INNER JOIN MERK ON GROEP.groep_id = MERK.merk_id
             INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
             INNER JOIN BESCHRIJVING ON PRODUCT.product_id = BESCHRIJVING.besch_id");

    $stmt->execute();

    $resultaten = $stmt->get_result();

    if ($resultaten->num_rows > 0) {
        while ($row = $resultaten->fetch_assoc()) {
            $response[] = $row;
        }
    } else {
        $response['error'] = "Geen resultaten gevonden";
    }

    $stmt->close();
}



?>
