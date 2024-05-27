<?php
include('../../../database.php');
include('../../../ChromePhp.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$KitNr = $_GET['KitNr'];

$response = [];

// fetch van alle producten die in de kit zitten
$query = "SELECT product_id_fk, MIJN_LENINGEN.kit_id_fk, kit_naam, GROEP.naam, image_data, email, voornaam, achternaam, lening_id,  (SELECT COUNT(*) FROM KIT_PRODUCT WHERE KIT_PRODUCT.kit_id_fk = ?) AS aantalProducten
FROM MIJN_LENINGEN
    JOIN PRODUCT ON MIJN_LENINGEN.product_id_fk = PRODUCT.product_id
    JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
    JOIN IMAGE ON GROEP.image_id_fk = IMAGE.image_id
    JOIN USER ON MIJN_LENINGEN.user_id_fk = USER.user_id
    JOIN KIT_PRODUCT ON GROEP.groep_id = KIT_PRODUCT.groep_id_fk
    JOIN KIT ON KIT_PRODUCT.kit_id_fk = KIT.kit_id
WHERE MIJN_LENINGEN.kit_id_fk = ? AND isTerugGebracht = false
ORDER BY lening_id asc";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $KitNr, $KitNr);
$stmt->execute();
$resultaten = $stmt->get_result();

if ($resultaten->num_rows > 0) {
    while ($row = $resultaten->fetch_assoc()) {
        $response[] = $row;
    }
    echo json_encode($response);
} else {
    unset($response);
}

$stmt->close();


?>