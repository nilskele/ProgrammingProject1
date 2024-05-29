<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="css/product_wijzigen.css">

<?php
  include ("../admin.header.php");
  include ('categorienOphalen.php');
?>

<br><br>
<div class="terug">
  <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
</div>
<form id="productForm" enctype="multipart/form-data" method="post">
  <div class="container">
    <h1>Product wijzigen</h1>
    <div class="product_wijzigen">
      <div class="labelcontainers">
        <div>
          <label for="productName">Product naam:</label>
          <input type="text" id="productName" name="productName" required>
        </div>
        <div>
          <label for="merk">Merk:</label>
          <input type="text" id="merk" name="merk" required>
        </div>
      </div>
      <div class="labelcontainers">
        <div>
          <label for="categorie">Categorie:</label>
          <select name="category" id="categorie" class="categorieZoekbalk" required>
            <option value="All" id="categoryOptions">Categorie</option>
            <?php echo $options; ?>
          </select>
        </div>
        <div>
          <label for="quantity">Quantity:</label>
          <input class="categorieZoekbalk2" type="number" id="quantity" name="quantity" min="1" value="1" required>
        </div>
      </div>
      <div class="labelcontainers">
        <div>
          <label for="beschrijving">Beschrijving:</label>
          <input type="text" id="beschrijving" name="beschrijving" required>
        </div>
        <div>
          <label for="opmerkingen">Opmerkingen:</label>
          <input type="text" id="opmerkingen" name="opmerkingen">
        </div>
      </div>
    </div>
    <button class="submit" type="submit">Product wijzigen</button>
  </div>
</form>

<div id="brandMessage" style="display: none;"></div>
<div id="nameMessage" style="display: none;"></div>
<div id="categoryMessage" style="display: none;"></div>
<div id="descriptionMessage" style="display: none;"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/checkAanwezig.js"></script>