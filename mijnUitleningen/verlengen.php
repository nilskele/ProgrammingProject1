<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../database.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request
    $productId = $_POST['productId'];
    $newReturnDate = $_POST['newReturnDate'];

    // Prepare and execute the SQL query to update the database
    $sql = "UPDATE MIJN_LENINGEN SET terugbrengDatum = ? WHERE product_id_fk = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newReturnDate, $productId]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        // Return a success message
        http_response_code(200);
        echo json_encode(["message" => "The return date has been extended successfully."]);
    } else {
        // Return an error message if the query failed
        http_response_code(500);
        echo json_encode(["error" => "Failed to update the return date."]);
    }
} else {
    // Return an error if the request method is not POST
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
?>
