<?php

include "database.php";

// afbeelding inlezen en omzetten naar base64
$afbeeldingData = file_get_contents("./images/jpg");
$gecodeerdeAfbeelding = base64_encode($afbeeldingData);

$query = "INSERT INTO IMAGE (image_data) VALUES (?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $gecodeerdeAfbeelding);
$stmt->execute();
$stmt->close();
?>
