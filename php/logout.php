<?php
session_start();

// verwijder de sessie variabelen
session_unset();
session_destroy();
header("Location: index.php");
exit;

?>