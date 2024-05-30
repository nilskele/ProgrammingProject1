<?php
include('../database.php');

if (isset($_POST['leningId']) && isset($_POST['productNr'])) {
    $leningId = mysqli_real_escape_string($conn, $_POST['leningId']);
    $productNr = mysqli_real_escape_string($conn, $_POST['productNr']);

    $query = "UPDATE MIJN_LENINGEN SET in_bezit = false, isTerugGebracht = True WHERE lening_id = '$leningId'";

    $query2 = "UPDATE PRODUCT
    SET PRODUCT.isUitgeleend = False
    WHERE PRODUCT.product_id = '$productNr'";

if ($conn->query($query) === TRUE && $conn->query($query2) === TRUE) {
    echo "success";
} else {
    echo "error";
}
} else {
    echo "Lening ID not provided";
}

$conn->close();
?>