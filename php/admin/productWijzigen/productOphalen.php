<?php
include('../../../database.php');

// Check if product_id is set in the request
if(isset($_GET['product_id'])) {
    // Sanitize the input
    $product_id = $_GET['product_id'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("
        SELECT
            p.product_id,
            p.opmerkingen,
            g.naam AS product_naam,
            beschrijving.naam AS product_beschrijving,
            merk.naam AS product_merk,
            categorie.naam AS product_categorie
        FROM PRODUCT p
            JOIN GROEP g ON p.groep_id = g.groep_id
            JOIN BESCHRIJVING beschrijving ON g.beschrijving_id_fk = beschrijving.besch_id
            JOIN MERK merk ON g.merk_id_fk = merk.merk_id
            JOIN CATEGORY categorie ON g.category_id_fk = categorie.cat_id
        WHERE p.product_id = ?
    ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the product details
    $productDetails = $result->fetch_assoc();

    // Check if product details are found
    if($productDetails) {
        // Return the product details as JSON
        echo json_encode($productDetails);
    } else {
        // Product not found
        echo json_encode(array('error' => 'Product not found'));
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // product_id not provided in the request
    echo json_encode(array('error' => 'Product ID not provided'));
}
?>