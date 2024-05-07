<?php

if (!function_exists('valideren')) {
  function valideren($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
}

?>