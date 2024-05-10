<?php
include ('../../database.php');
include ('../validation_functions.php');

if (isset($_POST['merk'])) {
  $merk = valideren($_POST['merk']);

  $sql = "SELECT merk_id FROM MERK WHERE naam = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $merk);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(array('merk_id' => $row['merk_id'])); // Brand exists, return ID
  } else {
    echo json_encode(array('exists' => false)); // Brand does not exist
  }
}

$conn->close();
?>