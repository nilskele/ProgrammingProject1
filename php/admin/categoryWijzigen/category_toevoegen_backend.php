<?php

include("../../../database.php");

$response = [];

if (isset($_POST['categoryNameInput'])) {
    $categoryNameInput = $_POST['categoryNameInput'];

    // voeg een nieuwe categorie toe
    $sql = "INSERT INTO CATEGORY (naam) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoryNameInput);
    $stmt->execute();

    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
}

echo json_encode($response);

?>