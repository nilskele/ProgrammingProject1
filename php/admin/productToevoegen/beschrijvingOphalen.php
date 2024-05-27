<?php
include('../../../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $beschrijving = $_POST["beschrijving"];

    // Check if the description already exists in the database
    $sql = "SELECT COUNT(*) AS count FROM BESCHRIJVING WHERE naam = '$beschrijving'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row["count"];

    if ($count > 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
}

$conn->close();
?>
