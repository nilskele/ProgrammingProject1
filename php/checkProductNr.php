<?php 
include "../database.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $productNr = htmlspecialchars($_POST['productNr']);
    
    // check of product_id bestaat
    $query = "SELECT product_id FROM PRODUCT WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $productNr);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    http_response_code(400);
}
?>