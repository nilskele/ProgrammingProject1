<?php
// Include the database connection file and other necessary includes
include('../database.php');
include('validation_functions.php');

// Check if the merk is received via POST request
if(isset($_POST['merk'])) {
    // Sanitize the merk input using valideren function
    $merk = valideren($_POST['merk']);

    // Query to select distinct brand names from the database
    $sql = "SELECT DISTINCT naam FROM MERK WHERE naam = ?";

    // Prepare the query
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param('s', $merk);

    // Execute the query
    $stmt->execute();
    
    // Bind the result variable
    $stmt->bind_result($brand);

    // Initialize an array to store brand names
    $brands = array();

    // Fetch results and store them in the array
    while ($stmt->fetch()) {
        $brands[] = $brand;
    }

    // Return the array as JSON
    echo json_encode($brands);
} else {
    echo 'Error: Brand not received.';
}

// Close database connection
$conn->close();
?>
