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
        <a href="/kit_toevoegen"><button>Kit toevoegen</button></a>
        <a href="/product_toevoegen"><button>Product toevoegen</button></a>
      </div>
    </div>

  <div class="calender">
  <div class="header_kalender">
  <button class="arrow_prev"><img src="../images/black_arrow_l.png" alt="Previous"></button>
    <h2>WEEK DATUM HIER</h2>
    <button class="arrow_next"><img src="../images/black_arrow_r.png" alt="Next"></button>
  </div>
  <div class="container_kalender">
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


