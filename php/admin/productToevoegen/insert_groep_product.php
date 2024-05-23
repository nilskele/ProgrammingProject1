<?php
include('../../../database.php');

// Function to insert a new product into the database
function insertProduct($conn, $productName, $merkId, $categoryId, $descriptionId) {
    $date = date("Y-m-d");
    $sql = "INSERT INTO GROEP (naam, merk_id_fk, category_id_fk, beschrijving_id_fk) 
            VALUES ('$productName', $merkId, $categoryId, $descriptionId)";
    if (mysqli_query($conn, $sql)) {
        $productId = mysqli_insert_id($conn);
        // Insert the product details into the PRODUCT table
        $sql = "INSERT INTO PRODUCT (opmerkingen, datumBeschikbaar, zichtbaar, isUitgeleend, groep_id) 
                VALUES (NULL, '$date', true, false, $productId)";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Function to retrieve the ID of the brand based on its name
function getMerkId($conn, $merk) {
  $sql = "SELECT merk_id FROM MERK WHERE naam = '$merk'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      return $row['merk_id'];
  } else {
      return false;
  }
}

// Function to retrieve the ID of the category based on its name
function getCategoryId($conn, $category) {
  $sql = "SELECT cat_id FROM CATEGORY WHERE naam = '$category'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      return $row['cat_id'];
  } else {
      return false;
  }
}

// Function to retrieve the ID of the description based on its name
function getDescriptionId($conn, $beschrijving) {
  $sql = "SELECT besch_id FROM BESCHRIJVING WHERE naam = '$beschrijving'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      return $row['besch_id'];
  } else {
      return false;
  }
}

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $merk = $_POST["merk"];
    $category = $_POST["category"];
    $beschrijving = $_POST["beschrijving"];

    // Assuming you have functions to retrieve the IDs based on the names
    // You should modify these functions according to your database structure
    $merkId = getMerkId($conn, $merk);
    $categoryId = getCategoryId($conn, $category);
    $descriptionId = getDescriptionId($conn, $beschrijving);

    if ($merkId && $categoryId && $descriptionId) {
        if (insertProduct($conn, $productName, $merkId, $categoryId, $descriptionId)) {
            echo "Product inserted successfully.";
        } else {
            echo "Error inserting product details.";
        }
    } else {
        echo "Error retrieving brand, category, or description IDs.";
    }
}

$conn->close();
?>
