<?php
// updateDatabase.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file (optional)
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
// Include the database connection file
include('../database.php');

// Fetch the current date
$currentDate = date("Y-m-d");

// Return the current date as JSON
echo json_encode(array("currentDate" => $currentDate));
?>
