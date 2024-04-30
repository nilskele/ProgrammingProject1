<?php
include('../database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

$watDefect = isset($_POST['watDefect']) ? $_POST['watDefect'] : '';
$redenDefect = isset($_POST['redenDefect']) ? $_POST['redenDefect'] : '';
$lening_id = isset($_POST['lening_id']) ? $_POST['lening_id'] : '';

if ($watDefect !== '' && $redenDefect !== '') {
    $stmt = $conn->prepare("INSERT INTO DEFECT (watDefect, redenDefect, lening_id_fk) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $watDefect, $redenDefect, $lening_id);

    $stmt->execute();

    $stmt->close();
}

?>
