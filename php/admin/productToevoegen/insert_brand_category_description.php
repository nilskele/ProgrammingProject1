<?php
// Assuming you have a database connection established
include('../../../database.php');

// Function to insert a new product into the database
function insertProduct($productName, $merk, $category, $beschrijving) {
    global $conn; // Assuming $conn is your database connection variable
    
    // Get the foreign key IDs for merk, category, and beschrijving
    $merkId = getMerkId($merk);
    $categoryId = getCategoryId($category);
    $beschrijvingId = getDescriptionId($beschrijving);

    // Insert the product into the database
    $sql = "INSERT INTO PRODUCT (product_id, opmerkingen, datumBeschikbaar, zichtbaar, isUitgeleend, groep_id, merk_id_fk, category_id_fk, beschrijving_id_fk, image_id_fk)
            VALUES (NULL, NULL, CURRENT_DATE, true, false, 1, $merkId, $categoryId, $beschrijvingId, NULL)";
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        return true; // Product inserted successfully
    } else {
        return false; // Error inserting product
    }
}

// Function to get the merk_id for a given merk name
function getMerkId($merk) {
    global $conn; // Assuming $conn is your database connection variable
    
    // Query to retrieve the merk_id for the given merk name
    $sql = "SELECT merk_id FROM MERK WHERE naam = '$merk'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if a row is returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the merk_id
        $row = mysqli_fetch_assoc($result);
        return $row['merk_id'];
    } else {
        // Merk does not exist, insert it and return the generated ID
        $sql = "INSERT INTO MERK (merk_id, naam) VALUES (NULL, '$merk')";
        mysqli_query($conn, $sql);
        return mysqli_insert_id($conn); // Return the generated merk_id
    }
}

// Function to get the category_id for a given category name
function getCategoryId($category) {
    global $conn; // Assuming $conn is your database connection variable
    
    // Query to retrieve the category_id for the given category name
    $sql = "SELECT cat_id FROM CATEGORY WHERE naam = '$category'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if a row is returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the category_id
        $row = mysqli_fetch_assoc($result);
        return $row['cat_id'];
    } else {
        // Category does not exist, insert it and return the generated ID
        $sql = "INSERT INTO CATEGORY (cat_id, naam) VALUES (NULL, '$category')";
        mysqli_query($conn, $sql);
        return mysqli_insert_id($conn); // Return the generated cat_id
    }
}

// Function to get the beschrijving_id for a given beschrijving name
function getDescriptionId($beschrijving) {
    global $conn; // Assuming $conn is your database connection variable
    
    // Query to retrieve the beschrijving_id for the given beschrijving name
    $sql = "SELECT besch_id FROM BESCHRIJVING WHERE naam = '$beschrijving'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if a row is returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the beschrijving_id
        $row = mysqli_fetch_assoc($result);
        return $row['besch_id'];
    } else {
        // Beschrijving does not exist, insert it and return the generated ID
        $sql = "INSERT INTO BESCHRIJVING (besch_id, naam) VALUES (NULL, '$beschrijving')";
        mysqli_query($conn, $sql);
        return mysqli_insert_id($conn); // Return the generated beschrijving_id
    }
}

// Main code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent from JavaScript
    $productName = $_POST["productName"];
    $merk = $_POST["merk"];
    $category = $_POST["category"];
    $beschrijving = $_POST["beschrijving"];

    // Insert the product into the database
    if (!insertProduct($productName, $merk, $category, $beschrijving)) {
        echo "Error inserting product.";
    }
}
$conn->close();
?>
