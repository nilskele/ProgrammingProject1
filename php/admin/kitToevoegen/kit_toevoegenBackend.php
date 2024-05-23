<?php
include("../../../database.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kitNaam']) && isset($_POST['producten'])) {
    $kitNaam = $_POST['kitNaam'];
    $producten = $_POST['producten'];
    $categorie = $_POST['categorie'];
    $merk = $_POST['merk'];

    $query = "INSERT INTO KIT (kit_naam, datumBeschikbaar, zichtbaar, isUitgeleend, category_fk, merk_fk, image_id_fk) VALUES (?, SYSDATE(), true, false, ?, ?, 4)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $kitNaam, $categorie, $merk);

    if ($stmt->execute()) {

        foreach ($producten as $product) {
            $kitId = $conn->insert_id;
            $query_Groep_id = "SELECT groep_id FROM GROEP WHERE naam = ?";
            $stmt_Groep_id = $conn->prepare($query_Groep_id);
            $stmt_Groep_id->bind_param("s", $product);
            $stmt_Groep_id->execute();
            $result = $stmt_Groep_id->get_result();
            $groep_id = $result->fetch_assoc()["groep_id"];

            $query = "INSERT INTO KIT_PRODUCT (kit_id_fk, groep_id_fk) VALUES (?, ?);";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $kitId, $groep_id);
            $stmt->execute();
        }

        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Failed to add kit"));
    }
} else {
    echo json_encode(array("error" => "Invalid request"));
}

$conn->close();
?>
