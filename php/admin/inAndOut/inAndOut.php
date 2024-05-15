<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="css/inandout.css">
<li<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style>
.submitIcon {
  transition: 0.5s;
  padding: 0.5em;
  background-color: lightgrey;
  border-radius: 1em;
  margin-left: 1em;
  width: 3em;
}

.submitIcon:hover {
  width: 2.8em;
}

.searchbar {
  display: flex;
  flex-direction: row;
  width: 55%;
  justify-content: space-between;
}

.input1 {
  width: 90%;
}


</style>

<?php include("../admin.header.php")?>
<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>


<div class="terug">
  <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
</div>
<div id="title-kalender-In-Out">
  <h1>In and Out</h1>
  <input type="text" name="selectedDate" id="selectedDate" readonly />
</div>
<div class="inAndOut">
  <h1>vandaag Out </h1>
  <div class="searchbar">
    <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk1">
  </div>
  <div id="InOut1" class="inOutCatalagus overflow-auto">
  </div>
</div>

<div class="inAndOut">
  <h1>vandaag In</h1>
  <div class="searchbar">
    <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk2">
  </div>
  <div id="InOut2" class="inOutCatalagus overflow-auto">
  </div>
</div>
<script src="/ProgrammingProject1/php/admin/inAndOut/js/inandout.js"></script>
<script>

  
    
function openPopup() {
    var overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    var popup = document.getElementById("popup");
    var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
    var leningId = $this.closest('.inOutProduct').data('lening-id');
    var naam = $this.closest('.inOutProduct').find('.Naam').attr('value');
    var productNr = $this.closest('.inOutProduct').find('.accepterenProductID').attr('value');
    var terugbrengdatum = $this.closest('.inOutProduct').data('terugbrengdatum');
    var uitleendatum = $this.closest('.inOutProduct').data('uitleendatum');
    var watdefect = $this.closest('.inOutProduct').data('watdefect');
    var redenDefect = $this.closest('.inOutProduct').data('redenDefect');




    

  
    // Construct the popup content with the retrieved data
    popup.innerHTML = `
      <div class="popup-content">
        <span class="closePopup" onclick="closePopup()">&times;</span>
        <div class="popup_info">
            <div class="contents">
                <h5 class="Naam">${naam}</h5>
                <p class="accepterenProductID">Product: ${productNr}</p>
                <p>Lening ID: ${leningId}</p>
            </div>
          <div>
            <div class="dates">
                <h6 class="aantalDagenTelaat">Uitleendatum: ${uitleendatum}</h6>
                
                <h6 class="aantalDagenTelaat">Terugbrengdatum: ${terugbrengdatum}</h6>
            
            </div>
            <div class="dates">
                <h6>Wat is er defect?</h6>
                <p>${watdefect}</p>
                <h6>Hoe is het defect ontstaan?</h6>
                <p>${redenDefect}</p>
            </div>
          </div>
            
          
        </div>
        
      </div>
    `;
  
    
    popup.style.display = "block";
  }
  $(document).on('click', '.moreinfo', openPopup);

  
  function closePopup() {
    var overlay = document.getElementById("overlay");
    overlay.style.display = "none";
    
    var popup = document.getElementById("popup");
    popup.style.display = "none";
    popup.innerHTML = ""; // Clear popup content
  }
  $(document).on('click', '.closePopup', closePopup);

</script>
