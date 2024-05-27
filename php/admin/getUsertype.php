<?php

include("../../database.php");

session_start();

// fetch van user_type
$usertype = $_SESSION['user_type'];

if ($usertype == "1") {
    echo "Admin";
} else {
    echo "Geen admin";
}

?>