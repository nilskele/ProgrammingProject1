<?php

include("../../../database.php");

$response = [];

if (isset($_POST['cat_id'])) {
    $categoryId = $_POST['cat_id'];

    // verwijder de categorie
    $sql = "DELETE FROM CATEGORY WHERE cat_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();

    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
}

echo json_encode($response);


?>