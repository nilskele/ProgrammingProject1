<?php

include('../database.php');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, '2324PROGPRGR02') or die('Error selecting the database');

session_start();

$groep_id = $_GET['groep_id'];
$startDatum = $_GET['startDatum'];
$eindDatum = $_GET['eindDatum'];
$reden = $_GET['reden'];
$aantal = $_GET['aantal'];
$user_id = $_SESSION['user_id'];
$isKit = $_GET['isKit'];


if ($isKit == 1) {
    $select_aantal_prodcten_nodig_query = "SELECT COUNT(*)
    FROM KIT_PRODUCT
    WHERE kit_id_fk = ?;";
    $select_stmt = $conn->prepare($select_aantal_prodcten_nodig_query);
    $select_stmt->bind_param("s", $groep_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $row = $result->fetch_assoc();
    $aantalProducten = $row['COUNT(*)'];

    $select_proucten_query = "SELECT GROEP.groep_id, MIN(PRODUCT.product_id) as product_id
    FROM PRODUCT
         JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
         JOIN KIT_PRODUCT ON GROEP.groep_id = KIT_PRODUCT.groep_id_fk
         JOIN KIT ON KIT_PRODUCT.kit_id_fk = KIT.kit_id
    WHERE PRODUCT.datumBeschikbaar < ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND KIT.kit_id = ?
    GROUP BY GROEP.groep_id";

    $select_stmt = $conn->prepare($select_proucten_query);
    $select_stmt->bind_param("ss", $eindDatum, $groep_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    $product_ids = array();

    while ($row = $result->fetch_assoc()) {
        $product_ids[] = $row['product_id'];
    }

    if (count($product_ids) < $aantalProducten * $aantal) {
        echo json_encode(array("success" => false, "error" => "Niet genoeg beschikbare producten"));
        exit;
    }

    for ($i = 0; $i < $aantalProducten * $aantal; $i++) {
        $product_id = $product_ids[$i];

        $update_query = "UPDATE PRODUCT SET isUitgeleend = true, datumBeschikbaar = ? WHERE product_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ss", $eindDatum, $product_id);
        $update_success = $update_stmt->execute();

        if (!$update_success) {
            echo json_encode(array("success" => false, "error" => "Fout bij het bijwerken van product status: " . $conn->error));
            exit;
        }

        $insert_query = "INSERT INTO MIJN_LENINGEN (Uitleendatum, terugbrengDatum, user_id_fk, product_id_fk, kit_id_fk, reden_id_fk) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ssssss", $startDatum, $eindDatum, $user_id, $product_id, $groep_id, $reden);
        $insert_success = $insert_stmt->execute();

        if (!$insert_success) {
            echo json_encode(array("success" => false, "error" => "Fout bij het maken van de reservering: " . $conn->error));
            exit;
        }

    }

        $select_aantal_kits_query = "SELECT
        (SELECT COUNT(*)
         FROM GROEP
                  JOIN PRODUCT ON GROEP.groep_id = PRODUCT.groep_id
         WHERE PRODUCT.isUitgeleend = false
           AND PRODUCT.zichtbaar = true
           AND PRODUCT.datumBeschikbaar < ?
         GROUP BY GROEP.groep_id
         ORDER BY COUNT(*) asc
         limit 1) AS aantalBeschikbaar
    FROM KIT
             JOIN MERK ON KIT.merk_fk = MERK.merk_id
             LEFT JOIN KIT_PRODUCT ON KIT.kit_id = KIT_PRODUCT.kit_id_fk
             LEFT JOIN GROEP ON KIT_PRODUCT.groep_id_fk = GROEP.groep_id
             JOIN IMAGE ON KIT.image_id_fk = IMAGE.image_id
    WHERE KIT.datumBeschikbaar < ?
      AND KIT.zichtbaar = true
      AND KIT.kit_id = ?
      AND EXISTS (
        SELECT 1 FROM PRODUCT
        WHERE PRODUCT.groep_id = GROEP.groep_id
          AND PRODUCT.zichtbaar = true
          AND PRODUCT.isUitgeleend = false
          AND PRODUCT.datumBeschikbaar < ?
    )
    GROUP BY KIT.kit_id, KIT.kit_naam, MERK.naam, KIT.opmerkingen, IMAGE.image_data
    HAVING COUNT(DISTINCT KIT_PRODUCT.groep_id_fk) >= (
        SELECT COUNT(*)
        FROM KIT_PRODUCT
        WHERE KIT_PRODUCT.kit_id_fk = KIT.kit_id
    );";

        $select_stmt = $conn->prepare($select_aantal_kits_query);
        $select_stmt->bind_param("ssss",$eindDatum, $eindDatum ,$groep_id, $eindDatum);
        $select_stmt->execute();
        $result = $select_stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $aantalKits = $row['aantalBeschikbaar'];

        } else {
            $update_query = "UPDATE KIT SET isUitgeleend = true, datumBeschikbaar = ? WHERE kit_id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ss", $eindDatum, $groep_id);
                $update_success = $update_stmt->execute();
        
                if (!$update_success) {
                    echo json_encode(array("success" => false, "error" => "Fout bij het bijwerken van kit status: " . $conn->error));
                    exit;
                }
        }

        

    echo json_encode(array("success" => true));
} else {
    $select_query = "SELECT PRODUCT.product_id
FROM PRODUCT
         JOIN GROEP ON PRODUCT.groep_id = GROEP.groep_id
WHERE datumBeschikbaar < ? AND PRODUCT.zichtbaar = true AND PRODUCT.isUitgeleend = false AND GROEP.groep_id = ?";


    $select_stmt = $conn->prepare($select_query);
    $select_stmt->bind_param("ss", $eindDatum, $groep_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();


    $product_ids = array();


    while ($row = $result->fetch_assoc()) {
        $product_ids[] = $row['product_id'];
    }


    if (count($product_ids) < $aantal) {
        echo json_encode(array("success" => false, "error" => "Niet genoeg beschikbare producten"));
        exit;
    }


    for ($i = 0; $i < $aantal; $i++) {
        $product_id = $product_ids[$i];


        $update_query = "UPDATE PRODUCT SET isUitgeleend = true, datumBeschikbaar = ? WHERE product_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ss", $eindDatum, $product_id);
        $update_success = $update_stmt->execute();

        if (!$update_success) {
            echo json_encode(array("success" => false, "error" => "Fout bij het bijwerken van product status: " . $conn->error));
            exit;
        }

        $insert_query = "INSERT INTO MIJN_LENINGEN (Uitleendatum, terugbrengDatum, user_id_fk, product_id_fk, kit_id_fk, reden_id_fk) VALUES (?, ?, ?, ?, null, ?)";


        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sssss", $startDatum, $eindDatum, $user_id, $product_id, $reden);
        $insert_success = $insert_stmt->execute();

        if (!$insert_success) {
            echo json_encode(array("success" => false, "error" => "Fout bij het maken van de reservering: " . $conn->error));
            exit;
        }
    }


    echo json_encode(array("success" => true));
}
