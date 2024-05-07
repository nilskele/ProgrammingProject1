<?php
include('../database.php');

// Check if database connection is successful

if(isset($_POST['merk'])) {
    // Sanitize input to prevent SQL injection
    $merk = valideren($_POST['merk']);

    // Query to select distinct brand names from the database
    $sql = "SELECT DISTINCT merk FROM MERK";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
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
