<?php
include ('../../../database.php');

if (isset($_POST['lening_id']) && !empty($_POST['lening_id'])) {

  $lening_id = mysqli_real_escape_string($conn, $_POST['lening_id']);

  $query = "SELECT lening_id 
            FROM MIJN_LENINGEN 
            WHERE lening_id != '$lening_id' 
            AND terugbrengDatum = DATE_ADD(
                                          (SELECT terugbrengDatum 
                                            FROM MIJN_LENINGEN 
                                            WHERE lening_id = '$lening_id'), 
                                          INTERVAL 7 DAY)";

  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 0) {
    $response = array(
      'allowExtension' => true
    );
  } else {
    $response = array(
      'allowExtension' => false
    );
  }

  mysqli_close($conn);

  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  $response = array(
    'error' => 'lening_id not provided or empty'
  );

  header('Content-Type: application/json');
  echo json_encode($response);
}
?>