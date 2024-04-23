<link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
  <link rel = "stylesheet" href = "../css/kit_toevoegen.css"> 


<?php include("header2.php")?>

    <h1>Add kit</h1>
    <form action="../add_kit">
    <div class="container">
        <h1>Kit Toevoegen</h1>
        <div class="gegevens_kit">
        <label for="kitNaam">Kit naam:</label>
        <input type="text" id="kitNaam" name="kitNaam"><br>
        <label for="kitNr">Kit nummer:</label>
        <input type="text" id="kitNr" name="kitNr"><br>
        </div>

        <div class="product_toevoegen">
        <label for="groepNr">Groep nummer product:</label>
        <input type="text" id="groepNr" name="groepNr"><br>
        <button type="button" onclick="searchItem()">Product toevoegen</button>
        </div>

        <div class="overview_producten">
        <h2>Kit producten</h2>
        <div class="selected_products">
            <!-- geselecteerd producten hier -->
            <p>Geen producten geselecteerd</p>
        </div>
        </div>
        <button type="submit">Kit toevoegen</button>
    </div>

    </form>
