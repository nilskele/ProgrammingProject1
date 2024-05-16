<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

session_start();

$userID = $_SESSION['user_id'];


if (true) {
  $stmt = $conn->prepare("SELECT DISTINCT MIJN_LENINGEN.in_bezit, MIJN_LENINGEN.isVerlenged, MIJN_LENINGEN.Uitleendatum, MIJN_LENINGEN.terugbrengDatum, GROEP.naam AS groep_naam, PRODUCT.product_id, lening_id
  FROM MIJN_LENINGEN
  INNER JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
  INNER JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
  WHERE user_id_fk = $userID
  ORDER BY MIJN_LENINGEN.terugbrengDatum ASC");

  $stmt->execute();

  $resultaten = $stmt->get_result();

  $response = [];

  if ($resultaten->num_rows > 0) {
      while ($row = $resultaten->fetch_assoc()) {
          $response[] = $row;
      }
  } else {
      $response['error'] = "Geen resultaten gevonden";
  }

  $stmt->close();

  $json = json_encode($response);
  echo $json;
}
?>