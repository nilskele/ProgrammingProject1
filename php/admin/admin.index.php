<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.css">
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.kalender.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!-- Include your custom JavaScript file -->
<style>
  .statusImage{
    width: 7em!important;
    margin-bottom:1em;
    
    
  }
</style>
<?php 
include("admin.header.php");
include('../../database.php');
?>




<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>



<div id="adminDashboard">
  <div id="container1">
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Product Nr.</h1>
        <input type="text" class="form-control grey-input" id="productNrInput" placeholder="product nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtn" class="accepterenBtn">
          accepteren
        </a>
        <a class="defectBtn" id="defectBtn">
          defect
        </a>
        <a>
          <button class="reserverenBtn" id="reserverenButtonProduct">
            reserveren
          </button>
        </a>
      </div>
    </div>
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Kit Nr.</h1>
        <input type="text" class="form-control" id="KitNrInput" placeholder="kit nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtnKit" class="accepterenBtnKit">
          accepteren
        </a>
        <a class="defectBtnAccepteren" id="defectBtnKit">
          defect
        </a>
        <a class="reserverenBtn" id="reserverenBtnKit">
          reserveren
        </a>
      </div>
    </div>
  </div>
</div>
<div id="smallInOutDiv">
  <div id="title-kalender-In-Out">
    <h1>In and Out</h1>
    <input type="text" name="selectedDate" id="selectedDate" readonly />
  </div>
  <div class="inOutTitels">
    <h1>Vandaag Geleend</h1>
    <h1>Vandaag Terug</h1>
  </div>
  <div class="inOutTitels">
  <input type="text" id="zoekbalka" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk3">

  <input type="text" id="zoekbalkb" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk4">

  </div>

  <div class="inoutdiv">
    <div id="smallInOut1" class="productContainer overflow-auto">

    </div>
    <div id="smallInOut2" class="productContainer overflow-auto "></div>
  </div>
</div>

<script src="../admin/inAndOut/js/inandout.js"></script>



</div>
<div class="toTopAnker">
  <button onclick="topFunction()" id="topBtn">Top &#8593;</button>
</div>

<script src="/ProgrammingProject1/js/admin.index.js"></script>


  
  <script src="catalogus/getData.php"></script> 
    <script src="catalogus/kalender.backend.js"></script> 

<div class="buttons_kalender">
    <form action="" method="GET">
        <input type="text" name="Zoeken" placeholder="Zoeken...">
        <button class="button_zoeken" type="submit">Zoek</button>
    </form>
    <div class="buttons-container">
      <a href="/ProgrammingProject1/php/admin/kitToevoegen/kit_toevoegen.php"><button>Kit toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/productToevoegen/product_toevoegen.php"><button>Product toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/categoryWijzigen/category_wijzigen.php"><button>Categorie wijzigen</button></a>
    </div>
  </div>
  <h1 class="titel">Calendar</h1>
</div>
  <div class="calendar">
    <header>
      <h3>Catalogus</h3>
      <nav>
        <button id="prev"></button>
        <button id="next"></button>
      </nav>
    </header>
    <section>
      <ul class="days">
        <li>Items <span class="date"></span></li>
        <li>Zo <span class="date"></span></li>
        <li>Ma <span class="date"></span></li>
        <li>Di <span class="date"></span></li>
        <li>Wo <span class="date"></span></li>
        <li>Do <span class="date"></span></li>
        <li>Vr <span class="date"></span></li>
        <li class="new-row"><span class="date"></span></li> 
      </ul>
      <ul class="dates"></ul>
    </section>
  </div>
  <div> 

<script src="../../js/admin.agenda.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../js/admin.agenda.js"></script>