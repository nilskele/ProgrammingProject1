<?php
include("../../../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kitNaam = $_POST['kitNaam'];
    $categorie = $_POST['categorie'];
    $merk = $_POST['merk'];
    $producten = json_decode($_POST['producten'], true);

    $imageId = null;

    if (isset($_FILES['kitFoto']) && $_FILES['kitFoto']['error'] == 0) {
        $afbeeldingData = file_get_contents($_FILES['kitFoto']['tmp_name']);
        $gecodeerdeAfbeelding = base64_encode($afbeeldingData);

        $query = "INSERT INTO IMAGE (image_data, naam) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $gecodeerdeAfbeelding, $kitNaam);
        if ($stmt->execute()) {
            $imageId = $conn->insert_id;
        } else {
            echo json_encode(array("error" => "error met insert"));
            exit();
        }
        $stmt->close();
    } else {
        echo json_encode(array("error" => "geen image meegegeven"));
        exit();
    }

    $query = "INSERT INTO KIT (kit_naam, datumBeschikbaar, zichtbaar, isUitgeleend, category_fk, merk_fk, image_id_fk) VALUES (?, SYSDATE(), true, false, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(array("error" => "Failed to prepare the kit insert query"));
        exit();
    }

    $stmt->bind_param("siii", $kitNaam, $categorie, $merk, $imageId);
    if ($stmt->execute()) {
        $kitId = $conn->insert_id;

        if (is_array($producten)) {
            foreach ($producten as $product) {
                $query_Groep_id = "SELECT groep_id FROM GROEP WHERE naam = ?";
                $stmt_Groep_id = $conn->prepare($query_Groep_id);
                if ($stmt_Groep_id === false) {
                    echo json_encode(array("error" => "Failed to prepare the product select query"));
                    exit();
                }
                
                $stmt_Groep_id->bind_param("s", $product);
                $stmt_Groep_id->execute();
                $result = $stmt_Groep_id->get_result();
                $groep_id = $result->fetch_assoc()["groep_id"];
                if ($groep_id === null) {
                    echo json_encode(array("error" => "Failed to get groep_id for product: " . $product));
                    exit();
                }

                $query = "INSERT INTO KIT_PRODUCT (kit_id_fk, groep_id_fk) VALUES (?, ?);";
                $stmt = $conn->prepare($query);
                if ($stmt === false) {
                    echo json_encode(array("error" => "Failed to prepare the kit_product insert query"));
                    exit();
                }

                $stmt->bind_param("ii", $kitId, $groep_id);
                if (!$stmt->execute()) {
                    echo json_encode(array("error" => "Failed to execute the kit_product insert query"));
                    exit();
                }
            }
        }

        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Failed to execute the kit insert query"));
    }
    $stmt->close();
} else {
    echo json_encode(array("error" => "Invalid request"));
}
$conn->close();
?>
