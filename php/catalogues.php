<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="../css/catalogues.css" />

  <!--Font Awesome for Icons  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <?php include ('header.php')  ?>
  <div class="zoekBalk">
    <?php include('zoekbalk.php')?>
  </div>

  <!-- ----Product1----- -->
  <div class="container">
    <div class="card">
      <div class="row">
        <div class="col-md-4 img-container">
          <img src="../images/img1.jpg" class="img-fluid">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <p>Canon></p>
            <div class="card-title">
              <h2>Canon M50</h2>
              <p> Beschikbaar vanaf: 11/03/2024</p>
            </div>
            <p class="card-text">
              Beschrijving: Canon M50 fototoestel
              <br>
              Opmerkong: toestel met XLR aansluiting
            </p>
          </div>
          <br>
          <div class="icon">
            <h6 class="aantal">Aantal aanwezig: 5</h6>
            <select class="available">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <button class="btn btn-secondary">+<i class="fas fa-shopping-cart"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <!-- ----Product2----- -->
  <div class="container mt-5">
    <div class="card">
      <div class="row">
        <div class="col-md-4 img-container">
          <img src="../images/img2.jpg" class="img-fluid">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <p>Canon></p>
            <div class="card-title">
              <h2>Canon EOS D700</h2>
              <p> Beschikbaar vanaf: 11/03/2024</p>
            </div>
            <p class="card-text">Beschrijving: Canon EOS fototoestel
              <br>

              Opmerkong: toestel met USB-aansluiting
            </p>
          </div>
          <br>
          <div class="icon">
            <h6 class="aantal">Aantal aanwezig: 5</h6>
            <select class="available">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <button class="btn btn-secondary">+<i class="fas fa-shopping-cart"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <!-- ----Product3----- -->
  <div class="container mt-5">
    <div class="card">
      <div class="row">
        <div class="col-md-4 img-container">
          <img src="../images/img3.jpg" class="img-fluid">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <p>Canon></p>
            <div class="card-title">
              <h2>Canon XA35</h2>
              <p> Beschikbaar vanaf: 11/03/2024</p>
            </div>
            <p class="card-text">Beschrijving: Canon XA35 videocamera
              <br>

              Opmerkong: toestel met USB-aansluiting
            </p>
          </div>
          <br>
          <div class="icon">
            <h6 class="aantal">Aantal aanwezig: 5</h6>
            <select class="available">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <button class="btn btn-secondary">+<i class="fas fa-shopping-cart"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <!-----Pagination----->
  <footer>
    <div class="pagination">
      <a href="#">&laquo;</a>
      <a href="#">1</a>
      <a href="#" class="active">2</a>
      <a href="#">3</a>
      <a href="#">... 9</a>
      <a href="#">&raquo;</a>
    </div>
  </footer>
</body>

</html>