<?php 
include "../database.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $kitNr = htmlspecialchars($_POST['KitNrInput']);
    
    $query = "SELECT KIT.kit_id
    FROM KIT
    WHERE kit_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kitNr);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    http_response_code(400);
}
?>
