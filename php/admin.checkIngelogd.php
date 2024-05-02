<?php
session_start();

if (!isset($_SESSION['isIngelogd']) || $_SESSION['isIngelogd'] !== true) {
    header("Location: index.php");
    exit();
}


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 1) {
    header("Location: index.php");
    exit();
}
?>
