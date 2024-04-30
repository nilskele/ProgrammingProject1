<?php
// Include the database connection file
include('../database.php');

// Check if the product name is sent via POST request
if(isset($_POST['naam'])) {
    // Get the product name from the POST data
    $naam = $_POST['naam'];

    // SQL query to check if the product name already exists in the GROEP table
    $sql = "SELECT naam FROM GROEP WHERE naam = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param('s', $naam);

    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the row
    $row = $result->fetch_assoc();

    // Check if the product name exists
    if(!empty($row)) {
        // If the product name exists, return 'exists' as the response
        echo 'exists';
    } else {
        // If the product name doesn't exist, return 'not exists' as the response
        echo 'not exists';
    }
} else {
    // If product name is not sent via POST request, return an error message
    echo 'Error: Product name not received.';
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
