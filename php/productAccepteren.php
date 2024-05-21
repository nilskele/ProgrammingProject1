<?php
// Include database connection file
include('../database.php');

// Check if leningId is provided
if (isset($_POST['leningId']) && isset($_POST['productNr'])) {
    // Sanitize the input to prevent SQL injection
    $leningId = mysqli_real_escape_string($conn, $_POST['leningId']);
    $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

    // Query to delete the row from MIJN_LENINGEN table
    $query = "UPDATE MIJN_LENINGEN SET in_bezit = false, isTerugGebracht = True WHERE lening_id = '$leningId'";


    $query2 = "UPDATE PRODUCT
    SET PRODUCT.isUitgeleend = False
    WHERE PRODUCT.product_id = '$productNr'";

if ($conn->query($query) === TRUE && $conn->query($query2) === TRUE) {
    // If both queries are successful, return success message
    echo "success";
} else {
    // If either query fails, return error message
    echo "error";
}
} else {
    // If leningId is not provided, return error message
    echo "Lening ID not provided";
}

// Close the database connection
$conn->close();
?>