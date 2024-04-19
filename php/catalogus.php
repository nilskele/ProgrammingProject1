<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="../css/catalogus.css" />

  <!--Font Awesome for Icons  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <?php include('header.php')?>
  
  <br>
  <div class="product">
    <div class="foto">
      <img src="../images/canon-m50.jpg" alt="canon-m50" />
    </div>
    <div class="top-info-aantal">
      <div class="top-info">
        <div class="top">
          <div class="merk-naam_product">
            <p id="merk"><span>Canon ></span></p>
            <p id="product_naam"><span>Canon M50</span></p>
          </div>
          <div class="beschikbaarheid">
            Beschikbaar vanaf: 16/05/2024
          </div>
        </div>
        <div class="info">
          <div class="beschrijving">
            Beschrijving: Canon M50 fototoestel
          </div>
          <div class="opmerkingen">
            Opmerkingen: toestel met XLR aansluiting
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

  <br>
</body>

</html>