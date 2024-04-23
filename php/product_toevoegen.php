<link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
  <link rel = "stylesheet" href = "../css/styles.css" />
  <link rel = "stylesheet" href = "../css/product_toevoegen.css"> 


<?php include("header2.php")?>

    <h1>Add kit</h1>
    <form action="../add_product">
    <div class="container">
        <h1>Product Toevoegen</h1>
        <div class="gegevens_product">
        <label for="productNr">Product nummer:</label>
        <input type="text" id="productNr" name="productNr"><br>
        <label for="groepNr">Groep nummer:</label>
        <input type="text" id="groepNr" name="groepNr"><br>
        </div>

        <div class="product_toevoegen">
        <label for="productNaam">Product naam:</label>
        <input type="text" id="productNaam" name="productNaam"><br>
        <label for="aantalAanwezig">Aantal aanwezig:</label>
        <select id="aantalAanwezig" name="aantalAanwezigs">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        </select><br>
        <label for="beschrijving">Beschrijving:</label>
        <input type="text" id="beschrijving" name="beschrijving"><br>
        <label for="opmerkingen">Opmerkingen:</label>
        <input type="text" id="opmerkingen" name="opmerkingen"><br>
        
        <label for="fotos">Upload foto's:</label>
        <input type="file" id="fotos" name="fotos" accept="image/*" multiple>
        <button type="submit">Submit</button>
        </div>

        <button type="submit">Product toevoegen</button>
    </div>

    </form>
