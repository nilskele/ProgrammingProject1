<?php
include "../database.php";

$response = [];

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $productNr = htmlspecialchars($_POST['productNr']);
    

    $stmt = $conn->prepare("SELECT COUNT(PRODUCT.product_id) AS aantal_beschikbare_producten
        FROM GROEP
        INNER JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
        WHERE PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND PRODUCT.product_id = ?");

    $stmt->bind_param("s", $productNr); 
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

echo json_encode($response);
?>
