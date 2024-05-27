<?php
include("../../../database.php");

$imageId = null;

if (isset($_FILES['kitFoto'])) {
    $afbeeldingData = file_get_contents($_FILES['kitFoto']['tmp_name']);
    $gecodeerdeAfbeelding = base64_encode($afbeeldingData);

    $query = "INSERT INTO IMAGE (image_data) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $gecodeerdeAfbeelding);

    if ($stmt->execute()) {
        $imageId = $conn->insert_id;
    } else {
        echo json_encode(array("error" => "Failed to upload image"));
        exit();
    }
    $stmt->close();
}

return $imageId;
?>
