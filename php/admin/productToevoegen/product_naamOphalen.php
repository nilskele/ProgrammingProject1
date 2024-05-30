<?php
include('../../../database.php');

// Haalt de naam van het product op
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];

    $sql = "SELECT * FROM GROEP WHERE naam = '$productName'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "not exists";
    }
}
?>
