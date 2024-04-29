<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
  <link rel = "stylesheet" href = "../css/catalogus.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</head>
<body>
  <?php include('header.php')?>
  
  <div class="zoekBalk">
    <?php include('zoekbalk.php')?>
  </div>
  
  <div class="resultaten"></div>

  <!-----Pagination----->
  <!-- <footer>
    <div class="pagination">
      <a href="#">&laquo;</a>
      <a href="#">&lsaquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">...</a>
      <a href="#">9</a>
      <a href="#">&rsaquo;</a>
      <a href="#">&raquo;</a>
    </div>
  </footer> -->

  <br>
  <script src="../js/catalogus.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>