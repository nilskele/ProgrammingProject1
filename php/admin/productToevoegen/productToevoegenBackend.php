<?php 
include("../../../database.php");

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $merk = $_POST["merk"];
  $productNaam = $_POST["productNaam"];
  $category = $_POST["category"];
  $beschrijving = $_POST["beschrijving"];

  $conn->begin_transaction();

  try {
    // Check if the brand exists in the database
    $sql = "SELECT merk_id FROM MERK WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $merk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      // If the brand doesn't exist, insert it into the MERK table
      $insertMerkQuery = "INSERT INTO MERK (naam) VALUES (?)";
      $stmt = $conn->prepare($insertMerkQuery);
      $stmt->bind_param("s", $merk);
      $stmt->execute();
    }

    // Check if the category exists in the database
    $sql = "SELECT cat_id FROM CATEGORY WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      // If the category doesn't exist, insert it into the CATEGORY table
      $insertCategoryQuery = "INSERT INTO CATEGORY (naam) VALUES (?)";
      $stmt = $conn->prepare($insertCategoryQuery);
      $stmt->bind_param("s", $category);
      $stmt->execute();
    }

    // Check if the description exists in the database
    $sql = "SELECT besch_id FROM BESCHRIJVING WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $beschrijving);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      // If the description doesn't exist, insert it into the BESCHRIJVING table
      $insertBeschrijvingQuery = "INSERT INTO BESCHRIJVING (naam) VALUES (?)";
      $stmt = $conn->prepare($insertBeschrijvingQuery);
      $stmt->bind_param("s", $beschrijving);
      $stmt->execute();
    }

    // Check if the groep already exists
    $sqlCheckGroep = "SELECT groep_id FROM GROEP 
                      WHERE naam = ? 
                      AND merk_id_fk = (SELECT merk_id FROM MERK WHERE naam = ?) 
                      AND category_id_fk = (SELECT cat_id FROM CATEGORY WHERE naam = ?) 
                      AND beschrijving_id_fk = (SELECT besch_id FROM BESCHRIJVING WHERE naam = ?)";
    $stmt = $conn->prepare($sqlCheckGroep);
    $stmt->bind_param("ssss", $productNaam, $merk, $category, $beschrijving);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // If the groep already exists, use the existing groep_id
      $row = $result->fetch_assoc();
      $groepId = $row['groep_id'];
    } else {
      // If the groep doesn't exist, insert a new row into the GROEP table
      $sqlInsertGroep = "INSERT INTO GROEP (naam, merk_id_fk, category_id_fk, beschrijving_id_fk, image_id_fk)
                         VALUES (?, 
                                (SELECT merk_id FROM MERK WHERE naam = ?), 
                                (SELECT cat_id FROM CATEGORY WHERE naam = ?), 
                                (SELECT besch_id FROM BESCHRIJVING WHERE naam = ?),
                                1)";
      $stmt = $conn->prepare($sqlInsertGroep);
      $stmt->bind_param("ssss", $productNaam, $merk, $category, $beschrijving);
      $stmt->execute();

      // Get the last inserted ID (groep_id)
      $groepId = $conn->insert_id;
    }

    // Insert into PRODUCT table with groep_id
    $sqlInsertProduct = "INSERT INTO PRODUCT (groep_id, datumBeschikbaar) VALUES (?, CURRENT_DATE)";
    $stmt = $conn->prepare($sqlInsertProduct);
    $stmt->bind_param("i", $groepId);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    $response['status'] = 'success';
  } catch (Exception $e) {
    // Rollback the transaction in case of error
    $conn->rollback();
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
  }

  echo json_encode($response);
}

$conn->close();
?>