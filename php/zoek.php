<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$zoekterm = isset($_GET['zoekbalk']) ? '%' . $_GET['zoekbalk'] . '%' : '%';

$stmt = $conn->prepare("SELECT naam FROM GROEP WHERE naam LIKE ?");
$stmt->bind_param("s", $zoekterm);

$stmt->execute();

$resultaten = $stmt->get_result();

 if ($resultaten->num_rows > 0) {
     while ($row = $resultaten->fetch_assoc()) {
         echo $row['naam'] . '<br>';
     }
 } else {
     echo "No results found";
 }

$stmt->close();

?>
