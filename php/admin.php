<link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
  <link rel = "stylesheet" href = "../css/admin.css"> 


<?php include("header2.php")?>

<div id = "adminDashboard">
    <div id = "container1">
        <div class = "adminAccepteren">
            <div class = "productNr">
                <h1>Product Nr.</h1>
                <input type="text" class="form-control grey-input" id="inputName3" placeholder="product nr" />
            </div>
            <div class = "knoppen">
                <a href = "accepteren.php" class = "accepterenBtn">
                  accepteren
                </a>
                <a href = "defect.php" class = "defectBtn">
                  defect
                </a>
                <a href = "reserveren.php" class = "reserverenBtn">
                  reserveren
                </a>
                
            </div>
        </div>
        <div class = "adminAccepteren">
            <div class = "productNr">
                <h1>Kit Nr.</h1>
                <input type="text" class="form-control" id="inputName3" placeholder="product nr" />
            </div>
            <div class = "knoppen">
                <a href = "accepteren.php" class = "accepterenBtn">
                  accepteren
                </a>
                <a href = "defect.php" class = "defectBtn">
                  defect
                </a>
                <a href = "reserveren.php" class = "reserverenBtn">
                  reserveren
                </a>
                
            </div>
          </div>
    </div>
</div>
<div id="smallInOutDiv">
  <div id="title-kalender-In-Out">
    <h1>In and Out</h1>
    <img src="#" alt="kalender icon">
  </div>
  <div class="inoutdiv">
    <div id="smallInOut1">
      <h1>Vandaag In</h1>
      <div class="inOutProduct">
        <div id="vandaagInButtons">
          <a class="accepterenBtn" href="">Accepteren</a>
          <a class=" defectBtn defectButton" href="">Defect</a>
        </div>
        <div class="productInfo">
          <div class="info">
            <h3>Nils kelecom</h3>
            <p>Canon,45X8G</p>
          </div>
          <div class="moreinfo">
            <img class="dots" src="../images/9025404_dots_three_icon.png" alt="More info image">
          </div>
        </div>
      </div>
    </div>
    <div id="smallInOut2">
      <h1>Vandaag Out</h1>
      <div class="inOutProduct">
        <div id="vandaagInButtons2">
        
        <a class="OutBtn" href="">Out</a>
        </div>
        <div class="productInfo">
          <div class="info">
            <h3>Nils kelecom</h3>
            <p>Canon,45X8G</p>
          </div>
          <div class="moreinfo">
            <img class="dots" src="../images/9025404_dots_three_icon.png" alt="More info image">
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>


  <!-- container voor kalender -->
<div class="container3"> 
  <div class="hoofd_kalender">
    <div class="titel_kalender">
      <h1>Catalogus</h1>
      
    </div>
  </div>
    <div class="buttons_kalender">
      <form action="/zoeken" method="GET">
        <input type="text" name="Zoeken" placeholder="Zoeken...">
      </form>
      <div class="buttons-container">
        <a href="../php/kit_toevoegen"><button>Kit toevoegen</button></a>
        <a href="../php/product_toevoegen"><button>Product toevoegen</button></a>
      </div>
    </div>

    <div class="calender">
  <div class="header_kalender">
    <button class="arrow_prev"><img src="../images/black_arrow_l.png" alt="Previous"></button>
    <h2>WEEK DATUM HIER</h2>
    <button class="arrow_next"><img src="../images/black_arrow_r.png" alt="Next"></button>
  </div>
  <div class="container_kalender">
    <!-- Kolom voor data -->
    <div class="data_column">
      <?php
      $data = [
        'WEEK 26',
        'CANON M50 1',
        'CANON M50 1'
      ];

      // Toon data in de kolom
      foreach ($data as $item) {
        echo '<div class="item">
                <div class="item_content">' . $item . '</div>
                <div class="item_buttons">
                  <button class="eye_button">👁️</button>
                  <button class="edit_button">✏️</button>
                  <button class="delete_button">❌</button>
                </div>
                <button class="reserven_button">Reserveren</button>
              </div>';
      }
      ?>
    </div>
    <!-- Kolommen voor dagen -->
    <div class="days_row">
      <div class="dag">Maandag</div>
      <div class="dag">Dinsdag</div>
      <div class="dag">Woensdag</div>
      <div class="dag">Donderdag</div>
      <div class="dag">Vrijdag</div>
      <div class="dag">Zaterdag</div>
      <div class="dag">Zondag</div>
    </div>
  </div>
</div>



