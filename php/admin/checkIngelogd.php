<?php
session_start();

// check of de gebruiker is ingelogd
if (!isset($_SESSION['isIngelogd']) || $_SESSION['isIngelogd'] !== true) {
    header("Location: ../index.php");
    exit();
}

// check of de gebruiker een admin is
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 1) {
    header("Location: ../index.php");
    exit();
}
?>
