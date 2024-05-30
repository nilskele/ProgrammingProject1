<?php
include ('../../../database.php');

$currentDate = date("Y-m-d");

$query1 = "SELECT l.*,i.image_data ,d.watDefect, i.image_data,d.redenDefect, ABS(DATEDIFF(l.terugbrengDatum, CURDATE())) AS daysDifference, 'Uitleendatum' AS queryType, u.voornaam, u.achternaam, p.product_id, g.naam, u.email
          FROM MIJN_LENINGEN l 
              INNER JOIN USER u ON l.user_id_fk = u.user_id
              INNER JOIN PRODUCT p ON l.product_id_fk = p.product_id
              INNER JOIN GROEP g ON p.groep_id = g.groep_id
              LEFT JOIN DEFECT d ON l.lening_id = d.lening_id_fk
              INNER JOIN IMAGE i ON g.image_id_fk =  i.image_id
          WHERE l.terugbrengDatum < '$currentDate' AND l.isTerugGebracht = False ";

$result1 = $conn->query($query1);
$rows3 = array();

if ($result1->num_rows > 0) {
  while ($row = $result1->fetch_assoc()) {

    $rows3[] = $row;
  }
}
echo json_encode($rows3);

$conn->close();
?>