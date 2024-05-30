<?php

include('../../../database.php');

$defect_id = $_POST['defect_id'];

$query = "UPDATE DEFECT SET isOpgelost = true WHERE defect_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $defect_id);
$stmt->execute();

$response = [];

if($stmt->affected_rows > 0){
    $response = [
        'status' => 'success',
        'message' => 'Defect is opgelost'
    ];
}else{
    $response = [
        'status' => 'error',
        'message' => 'Er is iets fout gegaan'
    ];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);

?>
