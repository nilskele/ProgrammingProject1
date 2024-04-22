<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');


if (true) {
  $stmt = $conn->prepare("SELECT DISTINCT MIJN_LENINGEN.in_bezit, PRODUCT.datumBeschikbaar, GROEP.naam AS groep_naam
  FROM MIJN_LENINGEN
  INNER JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
  INNER JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
  WHERE user_id_fk = 1");

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