<?php
$servername = "dt5.ehb.be";
$username = "2324PROGPRGR02";
$password = "kEtUhDU5";


$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>