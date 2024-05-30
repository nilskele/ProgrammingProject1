<?php 
include("../../../database.php");

header('Content-Type: application/json');

$response = array();

// Wijzigt het product in de database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $merk = isset($_POST["merk"]) ? $_POST["merk"] : null;
  $productNaam = isset($_POST["productName"]) ? $_POST["productName"] : null;
  $category = isset($_POST["category"]) ? $_POST["category"] : null;
  $beschrijving = isset($_POST["beschrijving"]) ? $_POST["beschrijving"] : null;

  if (is_null($merk) || is_null($productNaam) || is_null($category) || is_null($beschrijving)) {
    $response['status'] = 'error';
    $response['message'] = 'Missing required fields.';
    echo json_encode($response);
    exit();
  }

  if (isset($_FILES['kitFoto']) && $_FILES['kitFoto']['error'] == 0) {
    $afbeeldingData = file_get_contents($_FILES['kitFoto']['tmp_name']);
    $gecodeerdeAfbeelding = base64_encode($afbeeldingData);

    $query = "INSERT INTO IMAGE (image_data, naam) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $gecodeerdeAfbeelding, $productNaam);
    if ($stmt->execute()) {
      $imageId = $conn->insert_id;
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Error inserting image.';
      echo json_encode($response);
      exit();
    }
    $stmt->close();
  } else {
    $response['status'] = 'error';
    $response['message'] = 'No image provided.';
    echo json_encode($response);
    exit();
  }

  $conn->begin_transaction();

  try {
    $sql = "SELECT merk_id FROM MERK WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $merk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      $insertMerkQuery = "INSERT INTO MERK (naam) VALUES (?)";
      $stmt = $conn->prepare($insertMerkQuery);
      $stmt->bind_param("s", $merk);
      $stmt->execute();
    }

    $sql = "SELECT cat_id FROM CATEGORY WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      $insertCategoryQuery = "INSERT INTO CATEGORY (naam) VALUES (?)";
      $stmt = $conn->prepare($insertCategoryQuery);
      $stmt->bind_param("s", $category);
      $stmt->execute();
    }

    $sql = "SELECT besch_id FROM BESCHRIJVING WHERE naam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $beschrijving);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      $insertBeschrijvingQuery = "INSERT INTO BESCHRIJVING (naam) VALUES (?)";
      $stmt = $conn->prepare($insertBeschrijvingQuery);
      $stmt->bind_param("s", $beschrijving);
      $stmt->execute();
    }

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
      $row = $result->fetch_assoc();
      $groepId = $row['groep_id'];
    } else {
      $sqlInsertGroep = "INSERT INTO GROEP (naam, merk_id_fk, category_id_fk, beschrijving_id_fk, image_id_fk)
                         VALUES (?, 
                                (SELECT merk_id FROM MERK WHERE naam = ?), 
                                (SELECT cat_id FROM CATEGORY WHERE naam = ?), 
                                (SELECT besch_id FROM BESCHRIJVING WHERE naam = ?),
                                ?)";
      $stmt = $conn->prepare($sqlInsertGroep);
      $stmt->bind_param("ssssi", $productNaam, $merk, $category, $beschrijving, $imageId);
      $stmt->execute();

      $groepId = $conn->insert_id;
    }

    $sqlInsertProduct = "INSERT INTO PRODUCT (groep_id, datumBeschikbaar) VALUES (?, CURRENT_DATE)";
    $stmt = $conn->prepare($sqlInsertProduct);
    $stmt->bind_param("i", $groepId);
    $stmt->execute();

    $conn->commit();

    $response['status'] = 'success';
  } catch (Exception $e) {
    $conn->rollback();
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
  }
  echo json_encode($response);
}
$conn->close();
?>
