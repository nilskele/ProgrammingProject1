<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel = "stylesheet" href = "../mijnUitleningen/mijnUitleningen.css" />
  <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
  <?php include('../php/header.php')?>
  
  <div class='uitleningenTitle'>
    <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
    <h1>Mijn uitleningen</h1>
  </div>
  <div class="table">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Uitleendatum</th>
          <th>Terugbrengdatum</th>
          <th>Defect</th>
          <th>Reservering</th>
        </tr>
      <thead>
      <tbody></tbody>
    </table>
  </div>

  <script src="mandjeOphalen.js"></script>
</body>
</html>