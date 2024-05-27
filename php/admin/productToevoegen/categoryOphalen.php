<?php
include('../../../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];

    // Check if the category already exists in the database
    $sql = "SELECT COUNT(*) AS count FROM CATEGORY WHERE naam = '$category'";
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
