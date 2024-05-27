<?php

include("../../../database.php");

$response = [];

if (isset($_POST['cat_id']) && isset($_POST['nieuweNaam'])) { 
    $categoryId = $_POST['cat_id'];
    $nieuweNaam = $_POST['nieuweNaam'];

    // wijzig de naam van de categorie
    $sql = "UPDATE CATEGORY SET naam = ? WHERE cat_id = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nieuweNaam, $categoryId);
    $stmt->execute();

    $response['status'] = 'success';
    $response['message'] = 'Categorie is gewijzigd';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Er is iets fout gegaan';
}

echo json_encode($response);



?>