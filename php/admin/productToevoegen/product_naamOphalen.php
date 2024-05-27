<?php
// Assuming you have a database connection established
include('../../../database.php');

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the product name from the POST data
    $productName = $_POST["productName"];

    // Query the database to check if the product name already exists
    $sql = "SELECT * FROM GROEP WHERE naam = '$productName'";
    $result = mysqli_query($conn, $sql);

    // Check if a row is returned (indicating that the product name exists)
    if (mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "not exists";
    }
}
?>
