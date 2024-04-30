<?php
include('../database.php');

function valideren($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['naam'])) {
    $naam = valideren($_POST['naam']);

    $sql = "SELECT naam FROM GROEP WHERE naam = $naam";
    
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $naam);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if(!empty($row)) {
        echo 'exists';
    } else {
        echo 'not exists';
    }
} else {
    echo 'Error: Product name not received.';
}

$stmt->close();
$conn->close();
?>