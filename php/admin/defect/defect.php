<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="/ProgrammingProject1/php/admin/inAndOut/css/inandout.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
    .statusImage{
    width: 7em!important;
    margin-bottom:1em;
    
    
  }
</style>

<?php 
include("../admin.header.php");
include('../../../database.php');
?>

<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>

<div class="terug">
        <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
        
</div>


<div class="inAndOut">

    <h1>Defectenlijst. </h1>
    <div class="searchbar">
        <input type="text" id="zoekbalk" name="zoekbalk" placeholder="Zoek naar product nr" class="inputZoekbalk6">
    </div>
    <div id="InOut3" class="inOutCatalagus overflow-auto">
    </div>
</div>
<script>
   


</script>
<script src="js/defect.js"></script>