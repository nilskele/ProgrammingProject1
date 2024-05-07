<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/styles.css" />
<link rel="stylesheet" href="../css/product_toevoegen.css">


<?php include("admin.header.php")?>
<?php include("admin.product_toevoegen.category.php")?>
<?php include("admin.product_toevoegen.product_naam.php")?>
<?php include("admin.product_toevoegen.merk.php")?>

<br>
<br>
<form action="../add_product">
  <div class="container">
    <h1>Product Toevoegen</h1>
    <div class="product_toevoegen">
      <label for="productNaam">Product naam:</label>
      <input type="text" id="productName" name="productName">
      <br>
      <br>
      <label for="merk">Merk:</label>
      <input type="text" id="merk" name="merk">
      <br>
      <br>
      <label for="categorie">Categorie:</label>
      <select name="categorie" id="categorie" class="categorieZoekbalk">
        <option value="All" id="categoryOptions">Categorie</option>
        <?php echo $options; ?>
      </select>
      <br>
      <br>
      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" min="1" value="1">
      <br>
      <br>
      <label for="beschrijving">Beschrijving:</label>
      <input type="text" id="beschrijving" name="beschrijving">
      <br>
      <br>
      <label for="opmerkingen">Opmerkingen:</label>
      <input type="text" id="opmerkingen" name="opmerkingen">
      <br>
      <br>
      
      <!-- <label for="fotos">Upload foto's:</label>
      <input type="file" id="fotos" name="fotos" accept="image/*" multiple>
      <button type="submit">Submit</button>  -->
    </div>

    <button type="submit">Product toevoegen</button>
  </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../js/admin.product_toevoegen.category.js"></script>
<script src="../js/admin.product_toevoegen.merk.js"></script>

<script>
$(document).ready(function() {
  var hasSubmitted = false; // Declare the variable here

  // Function to check if the product name already exists
  function checkProductName(productName) {
    $.ajax({
      url: 'admin.product_toevoegen.product_naam.php',
      method: 'POST',
      data: {
        productName: productName
      },
      success: function(response) {
        console.log(response); // Log the response to see what it contains
        if (!hasSubmitted) { // Check if the form has not already been submitted
          if (response === 'exists') {
            // Log a message to the console
            console.log('The product name already exists.');
            // Show popup asking user if they want to use the existing name
            var confirmUseExisting = confirm('The product name already exists. Do you want to use it again?');
            if (confirmUseExisting) {
              // If user wants to use existing name, submit the form
              $('form').submit();
              hasSubmitted = true; // Set the flag to true
            } else {
              // If user doesn't want to use existing name, do nothing
            }
          } else {
            // Log a message to the console
            console.log('The product name does not exist.');
            // If the product name doesn't exist, submit the form
            $('form').submit();
            hasSubmitted = true; // Set the flag to true
          }
        }
      },
      error: function(xhr, status, error) {
        // Log error message to the console
        console.error('Error:', error);
      }
    });
  }

  // Event listener for form submission
  $('form').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Get the product name from the form input
    var productName = $('#productName').val();

    // Check if the product name is empty
    if (productName === undefined && productName.trim() ==='') {
      alert('Please enter a product name.');
      return;
    }

    // Call the function to check if the product name already exists
    checkProductName(productName);
  });

  // Event listener for keydown event on input field
  $('#productName').on('keydown', function(e) {
    if (e.keyCode === 13) { // Check if the key pressed is Enter
      e.preventDefault(); // Prevent default behavior of Enter key
      $('form').submit(); // Submit the form
    }
  });
});
</script>
