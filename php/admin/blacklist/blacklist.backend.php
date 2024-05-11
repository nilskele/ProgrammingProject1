<?php
include('../../../database.php');


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $query1 = "SELECT USER.voornaam, USER.achternaam, USER.blacklist_fk, USER.blacklistDatum, USER.user_id
                FROM USER
                WHERE USER.blacklist_fk = 3
                ORDER BY USER.blacklistDatum DESC;";

    $query2 = "SELECT USER.voornaam, USER.achternaam, USER.blacklist_fk, USER.blacklistDatum, USER.user_id
                FROM USER
                WHERE USER.blacklist_fk = 2
                ORDER BY USER.blacklistDatum DESC;";

    $stmt1 = $conn->prepare($query1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    $rows1 = array();

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $rows1[] = $row;
        }
    }

    $stmt2 = $conn->prepare($query2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $rows2 = array();

    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $rows2[] = $row;
        }
    }

    $combinedRows = array_merge($rows1, $rows2);

    echo json_encode($combinedRows);

    $stmt1->close();
    $stmt2->close();
} else {
    echo "error5";
}
?>