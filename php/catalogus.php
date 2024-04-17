<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalogus</title>
  <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
  <link rel = "stylesheet" href = "../css/catalogus.css" />
</head>
<body>
  <?php include('header.php')?>
  
  <br>
  <br>
  <br>

  <div class="zoekBalk">
    <?php include('../zoekbalk/zoekbalk.php')?>
  </div>
  
  <br>
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
      <div class="aantal_beschikbaar">
        <p>Aantal aanwezig: 
          <span id="aantal_beschikbare_items">3</span>
        </p>
      </div>
    </div>
  </div>

  <div class="product">
    <div class="foto">
      <img src="../images/canon_eos.png" alt="canon-eos" />
    </div>
    <div class="top-info-aantal">
      <div class="top-info">
        <div class="top">
          <div class="merk-naam_product">
            <p id="merk"><span>Canon ></span></p>
            <p id="product_naam"><span>Canon EOS</span></p>
          </div>
          <div class="beschikbaarheid">
            Beschikbaar vanaf: 16/05/2024
          </div>
        </div>
        <div class="info">
          <div class="beschrijving">
            Beschrijving: Canon EOS fototoestel
          </div>
          <div class="opmerkingen">
            Opmerkingen: toestel met XLR aansluiting
          </div>
        </div>
      </div>
      <div class="aantal_beschikbaar">
        <p>Aantal aanwezig: 
          <span id="aantal_beschikbare_items">3</span>
        </p>
      </div>
    </div>
  </div>

  <br>
</body>
</html>