<?php
session_start();

if (!isset($_SESSION['isIngelogd']) || $_SESSION['isIngelogd'] !== true) {
    header("Location: index.php");
    exit();
}
?>
