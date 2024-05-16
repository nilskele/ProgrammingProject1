<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="css/product_toevoegen.css">

<?php include("../admin.header.php")?>
<?php include("product_toevoegen.category.php")?>
<?php include("product_toevoegen.product_naam.php")?>
<?php include("product_toevoegen.merk.php")?>
<?php include("product_toevoegen.beschrijving.php")?>

<br>
<br>
<div class="terug">
  <a href="javascript:history.back()" class="terugLink">&#8592 Terug</a>
</div>
<form action="../../add_product">
  <div class="container">
    <h1>Product Toevoegen</h1>
    
    <div class="product_toevoegen">
      <div class="labelcontainers">
          <div>
            <label for="productNaam">Product naam:</label>
            <input type="text" id="productName" name="productName">
          </div>
      
        <div>
          <label for="merk">Merk:</label>
          <input type="text" id="merk" name="merk">
        </div>
      
      </div>
      
      <div class="labelcontainers">
        <div>
          <label for="categorie">Categorie:</label>
          <select name="categorie" id="categorie" class="categorieZoekbalk">
            <option value="All" id="categoryOptions">Categorie</option>
            <?php echo $options; ?>
          </select>
        </div>
      
        <div>
          <label for="quantity">Quantity:</label>
          <input class="categorieZoekbalk2" type="number" id="quantity" name="quantity" min="1" value="1">
        </div>
      
      </div>
      
      <div class="labelcontainers">
        <div>
          <label for="beschrijving">Beschrijving:</label>
          <input type="text" id="beschrijving" name="beschrijving">
        </div>

        <div>
          <label for="opmerkingen">Opmerkingen:</label>
          <input type="text" id="opmerkingen" name="opmerkingen">
        </div>
      
      </div>

      <!-- <label for="fotos">Upload foto's:</label>
      <input type="file" id="fotos" name="fotos" accept="image/*" multiple>
      <button type="submit">Submit</button>  -->
    </div>

    <button class="submit" type="submit">Product toevoegen</button>
  </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/ProgrammingProject1/php/admin/productToevoegen/js/product_toevoegen.category.js"></script>
<script src="/ProgrammingProject1/php/admin/productToevoegen/js/product_toevoegen.merk.js"></script>
<script src="/ProgrammingProject1/php/admin/productToevoegen/js/product_toevoegen.checkProductNaam.js"></script>
<script src="/ProgrammingProject1/php/admin/productToevoegen/js/product_toevoegen.checkBeschrijving.js"></script>