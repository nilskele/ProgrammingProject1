<?php
session_start();

// check of de gebruiker is ingelogd
if (!isset($_SESSION['isIngelogd']) || $_SESSION['isIngelogd'] !== true) {
    header("Location: index.php");
    exit();
}
?>
