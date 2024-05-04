<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/inandout.css">
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

<?php include("admin.header.php")?>



<div class="inAndOut">
<div id="title-kalender-In-Out">
    <h1>In and Out</h1>
    <input type="text" name="selectedDate" id="selectedDate" readonly />
  </div>
  <h1>vandaag In</h1>
  <div class="searchbar">
    <input type="text" class="form-control input1" id="inputName3" placeholder="product nr" />
    <a id="sub" href=""><img class="submitIcon" src="../images/search-26241.png" alt="search logo"></a>
  </div>



  <div id="InOut1" class="inOutCatalagus overflow-auto">
  </div>



</div>

<div class="inAndOut">
  <h1>vandaag Out</h1>
  <div class="searchbar">
    <input type="text" class="form-control input1" id="inputName3" placeholder="product nr" />
    <a id="sub" href=""><img class="submitIcon" src="../images/search-26241.png" alt="search logo"></a>
  </div>



    <div id="InOut2" class="inOutCatalagus overflow-auto">    
    </div>


    
</div>
<script src="../js/inandout.js"></script>