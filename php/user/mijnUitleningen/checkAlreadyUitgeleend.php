<?php
include ('../../../database.php');

// Check if lening_id is set and not empty
if (isset($_POST['lening_id']) && !empty($_POST['lening_id'])) {
  // Sanitize input to prevent SQL injection
  $lening_id = mysqli_real_escape_string($conn, $_POST['lening_id']);

  // Construct the SQL query to check for overlapping reservations
  $query = "SELECT lening_id 
              FROM MIJN_LENINGEN 
              WHERE lening_id != '$lening_id' 
              AND terugbrengDatum = DATE_ADD(
                                            (SELECT Uitleendatum 
                                              FROM MIJN_LENINGEN 
                                              WHERE lening_id = '$lening_id'), 
                                            INTERVAL 7 DAY)";

  // Execute the query
  $result = mysqli_query($conn, $query);

  // Check if there are overlapping reservations
  if (mysqli_num_rows($result) == 0) {
    // No overlapping reservations, allow extension
    $response = array(
      'allowExtension' => true
    );
  } else {
    // Overlapping reservations, disallow extension
    $response = array(
      'allowExtension' => false
    );
  }

  // Close database connection
  mysqli_close($conn);

  // Send JSON response
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  // lening_id not provided or empty
  $response = array(
    'error' => 'lening_id not provided or empty'
  );

  // Send JSON response
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>