<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="css/kit_toevoegen.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php include("../admin.header.php") ?>

<h1>Add kit</h1>
<div class="terug">
  <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
</div>
<form id="form">
  <div class="container">
    <h1>Kit Toevoegen</h1>
    <div class="gegevens_kit">
      <div class="labelcontainers">
        <div>
          <label for="kitNaam">Kit naam:</label>
          <input type="text" id="kitNaam" name="kitNaam"> <span id="correctSpan"></span>
        </div>
        <div>
          <div class="selectDiv">
          <label for="categrie">Categorie: </label>
            <Select class="form-control" id="categrieSelect">
              <option value="all">Selecteer een categorie</option>
            </Select>
          </div>
          <div class="selectDiv">
            <label for="merkSelect">Selecteer een merk:</label>
            <Select class="form-control" id="merkSelect">
              <option value="all">Selecteer een merk</option>
            </Select>
            </div>
        </div>       
      </div>
    </div>

    <div class="product_toevoegen">
      <div class="labelcontainers2">
        <label id="labelProduct" for="GroepNaam">Naam product: </label>
        <div style="display:flex; flex-direction:row;">
          <select class="form-control" id="groepinput" name="GroepNaam">
            <option value="all">Selecteer een naam</option>  
          </select>
          <br>
          <button class="submit2" type="button" id="toevoegenProductBtn">Product toevoegen aan kit</button>
        </div> 
      </div>
    </div>

    <div class="overview_producten">
      <h2>Kit producten</h2>
      <div class="selected_products" id="productenList">
      </div>
    </div>
    <button type="submit" class="btn btn-primary button">Kit toevoegen</button>
  </div>
</form>
<script src="js/kit_toevoegen.js"></script>
