<?php
// Include database connection file
include('../database.php');

// Check if leningId is provided
if (isset($_POST['productNr'])) {
    // Sanitize the input to prevent SQL injection
    $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

    $query = "UPDATE MIJN_LENINGEN 
    JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
    SET MIJN_LENINGEN.isTerugGebracht = True
    WHERE PRODUCT.product_id = '$productNr'";

    $query2 = "UPDATE PRODUCT
    SET PRODUCT.isUitgeleend = False
    WHERE PRODUCT.product_id = '$productNr'";

<<<<<<< Updated upstream
    if ($conn->query($query) === TRUE) {
        // If deletion is successful, return success message
        echo "success";
    } else {
        // If deletion fails, return error message
        echo "error";
    }
    if ($conn->query($query2) === TRUE) {
        // If deletion is successful, return success message
        echo "success";
        

    } else {
        // If deletion fails, return error message
        echo "error";
    }
=======
    




    
    



if ($conn->query($query) == TRUE && $conn->query($query2) == TRUE) {
    // If both queries are successful, return success message
    echo "success";
} else {
    // If either query fails, return error message
    echo "error";
}
>>>>>>> Stashed changes
} else {
    // If leningId is not provided, return error message
    echo "Lening ID not provided";
}

// Close the database connection
$conn->close();
?>