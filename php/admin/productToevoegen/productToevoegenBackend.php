<?php
// Assuming you have a database connection established
include('../../../database.php');

// Function to insert a new product into the database
function insertProduct($conn, $productName, $merk, $category, $beschrijving) {
    // Insert the product into the database
    // You'll need to modify this query according to your database structure
    // You may also want to use prepared statements for security
    $sql = "INSERT INTO products (product_name, merk, category, beschrijving) VALUES ('$productName', '$merk', '$category', '$beschrijving')";
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        return true; // Product inserted successfully
    } else {
        return false; // Error inserting product
    }
}

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent from JavaScript
    $productName = $_POST["productName"];
    $merk = $_POST["merk"];
    $category = $_POST["category"];
    $beschrijving = $_POST["beschrijving"];

    // Insert the product into the database
    if (!insertProduct($conn, $productName, $merk, $category, $beschrijving)) {
        echo "Error inserting product.";
    }
}

// Close the database connection
$conn->close();
?>
