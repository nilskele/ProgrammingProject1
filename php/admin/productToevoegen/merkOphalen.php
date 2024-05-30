<?php
include('../../../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $merk = $_POST["merk"];

    $sql = "SELECT COUNT(*) AS count FROM MERK WHERE naam = '$merk'";
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