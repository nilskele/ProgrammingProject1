<?php
include('../database.php');

// Get data from the request
$data = json_decode(file_get_contents("php://input"));

// Sanitize and validate data (you should implement proper validation)

$productId = mysqli_real_escape_string($connection, $data->productId);
$newReturnDate = mysqli_real_escape_string($connection, $data->newReturnDate);

// Update the database
$query = "UPDATE MIJN_LENINGEN SET terugbrengDatum = '$newReturnDate' WHERE product_id_fk = '$productId'";

if (mysqli_query($connection, $query)) {
    http_response_code(200);
    echo json_encode(array("message" => "Database updated successfully."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Failed to update database."));
}
?>
