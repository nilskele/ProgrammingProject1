<?php
include("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['productNr'])) {
        $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

        $updateProductQuery = "UPDATE PRODUCT SET zichtbaar = false WHERE product_id = '$productNr'";
        if ($conn->query($updateProductQuery) === TRUE) {
            echo "Product is uit de catalogus gehaald.";
        } else {
            echo "Error: " . $updateProductQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Productnummer is niet ontvangen.";
    }
}
?>