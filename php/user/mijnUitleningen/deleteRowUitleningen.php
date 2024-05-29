<?php
include ('../../../database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["lening_id"]) && !empty($_POST["lening_id"])) {
    $lening_id = $conn->real_escape_string($_POST["lening_id"]);

    $conn->begin_transaction();
    $update_product_query = "UPDATE PRODUCT SET isUitgeleend = false, datumBeschikbaar = CURDATE() WHERE product_id IN (SELECT product_id_fk FROM MIJN_LENINGEN WHERE lening_id = '$lening_id')";
    $update_product_result = $conn->query($update_product_query);

    if ($update_product_result) {
      $delete_query = "DELETE FROM MIJN_LENINGEN WHERE lening_id = '$lening_id'";

      $delete_result = $conn->query($delete_query);

      if ($delete_result) {
        $conn->commit();
        echo json_encode(array("success" => true, "message" => "Row deleted and product updated successfully."));
      } else {
        $conn->rollback();
        echo json_encode(array("success" => false, "message" => "Error deleting row: " . $conn->error));
      }
    } else {
      $conn->rollback();
      echo json_encode(array("success" => false, "message" => "Error updating product: " . $conn->error));
    }
  } else {
    echo json_encode(array("success" => false, "message" => "Loan ID not provided."));
  }
} else {
  echo json_encode(array("success" => false, "message" => "Invalid request method."));
}

$conn->close();
?>