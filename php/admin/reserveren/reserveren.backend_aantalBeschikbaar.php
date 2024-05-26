<?php
include "../../../database.php";


$response = [];


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $productNr = $_GET['product_id'];
    $startDatum = $_GET['startDatum'];
    $eindDatum = $_GET['eindDatum'];

    if (empty($productNr) || empty($startDatum) || empty($eindDatum)) {
        $response['error'] = "Missing parameters.";
        echo json_encode($response);
        exit;
    }

    // fetch van het aantal beschikbare producten
    $stmt = $conn->prepare("SELECT COUNT(PRODUCT.product_id) AS aantalBeschikbaar
        FROM GROEP
        INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
        WHERE PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND PRODUCT.product_id = ? AND PRODUCT.datumBeschikbaar < ?");
    
    if ($stmt === false) {
        $response['error'] = "Failed to prepare the SQL statement.";
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("ss", $productNr, $eindDatum); 
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
