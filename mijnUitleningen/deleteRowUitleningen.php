<?php
// Include the database connection file
include('../database.php');

// Check if a POST request was made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the loan ID is provided and not empty
    if (isset($_POST["lening_id"]) && !empty($_POST["lening_id"])) {
        // Sanitize the loan ID to prevent SQL injection
        $lening_id = mysqli_real_escape_string($connection, $_POST["lening_id"]);

        // Prepare the delete query
        $delete_query = "DELETE FROM MIJN_LENINGEN WHERE lening_id = '$lening_id'";

        // Execute the delete query
        if (mysqli_query($connection, $delete_query)) {
            // Return a success message if the row was deleted successfully
            echo json_encode(array("success" => true, "message" => "Row deleted successfully."));
        } else {
            // Return an error message if there was an issue deleting the row
            echo json_encode(array("success" => false, "message" => "Error deleting row: " . mysqli_error($connection)));
        }
    } else {
        // Return an error message if the loan ID was not provided
        echo json_encode(array("success" => false, "message" => "Loan ID not provided."));
    }
} else {
    // Return an error message if the request method is not POST
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}
?>
