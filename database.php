<?php
$servername = "dt5.ehb.be";
$username = "2324PROGPRGR02";
$password = "kEtUhDU5";
$dbname = "2324PROGPRGR02";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "<script>console.log('Connected successfully');</script>";
}
?>
