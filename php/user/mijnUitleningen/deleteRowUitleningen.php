<?php
// Include the database connection file
include('../../../database.php');

// Check if a POST request was made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the loan ID is provided and not empty
    if (isset($_POST["lening_id"]) && !empty($_POST["lening_id"])) {
        // Sanitize the loan ID to prevent SQL injection
        $lening_id = $conn->real_escape_string($_POST["lening_id"]);

        // Start a transaction
        $conn->begin_transaction();

        // Prepare the update query for the product table
        $update_product_query = "UPDATE PRODUCT SET isUitgeleend = false, datumBeschikbaar = CURDATE() WHERE product_id IN (SELECT product_id_fk FROM MIJN_LENINGEN WHERE lening_id = '$lening_id')";

        // Execute the update query for product table
        $update_product_result = $conn->query($update_product_query);

        // Check if the update query was successful
        if ($update_product_result) {
            // Prepare the delete query for MIJN_LENINGEN table
            $delete_query = "DELETE FROM MIJN_LENINGEN WHERE lening_id = '$lening_id'";

            // Execute the delete query for MIJN_LENINGEN table
            $delete_result = $conn->query($delete_query);

            // Check if the delete query was successful
            if ($delete_result) {
                // Commit the transaction if both queries were successful
                $conn->commit();
                echo json_encode(array("success" => true, "message" => "Row deleted and product updated successfully."));
            } else {
                // Rollback the transaction if there was an issue with the delete query
                $conn->rollback();
                echo json_encode(array("success" => false, "message" => "Error deleting row: " . $conn->error));
            }
        } else {
            // Rollback the transaction if there was an issue with the update query
            $conn->rollback();
            echo json_encode(array("success" => false, "message" => "Error updating product: " . $conn->error));
        }
    } else {
        // Return an error message if the loan ID was not provided
        echo json_encode(array("success" => false, "message" => "Loan ID not provided."));
    }
} else {
    // Return an error message if the request method is not POST
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}

// Close the database connection
$conn->close();

?>
