<?php
include('../database.php');

if (isset($_POST['productNr'])) {
    $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

    $query = "UPDATE MIJN_LENINGEN 
    JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
    SET MIJN_LENINGEN.isTerugGebracht = True, in_bezit = False
    WHERE PRODUCT.product_id = '$productNr'";

    $query2 = "UPDATE PRODUCT
    SET PRODUCT.isUitgeleend = False
    WHERE PRODUCT.product_id = '$productNr'";



if ($conn->query($query) == TRUE && $conn->query($query2) == TRUE) {
    echo "success";
} else {
    echo "error";
}} else {
    echo "Lening ID not provided";
}

$conn->close();
?>