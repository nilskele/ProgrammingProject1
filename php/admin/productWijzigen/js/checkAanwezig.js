// Met deze javascript file kan de admin de gegevens van een product wijzigen.
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get('product_id');
  let originalData = {};

  if (productId) {
      $.ajax({
          url: `productOphalen.php?product_id=${productId}`,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
              if (data.error) {
                  console.error('Error:', data.error);
                  alert(data.error);
              } else {
                  originalData = {
                      product_naam: data.product_naam,
                      product_merk: data.product_merk,
                      product_categorie: data.product_categorie,
                      product_beschrijving: data.product_beschrijving,
                      opmerkingen: data.opmerkingen || ''
                  };

                  document.getElementById('productName').value = data.product_naam;
                  document.getElementById('merk').value = data.product_merk;
                  document.getElementById('categorie').value = data.product_categorie;
                  document.getElementById('beschrijving').value = data.product_beschrijving;
                  document.getElementById('opmerkingen').value = data.opmerkingen || '';
              }
          },
          error: function(xhr, status, error) {
              console.error('Error fetching product details:', error);
              alert('An error occurred while fetching product details.');
          }
      });
  } else {
      alert('Product ID not provided in the URL.');
  }

  $('#productForm').on('submit', function (event) {
      event.preventDefault();
      const formData = new FormData($("#productForm")[0]);

      if (JSON.stringify(Object.fromEntries(formData)) === JSON.stringify(originalData)) {
          alert('No changes detected.');
          return;
      }

      formData.append('product_id', productId);

      $.ajax({
          url: 'productWijzigenBackend.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(result) {
              if (result.status === 'error') {
                  console.log(result.message);
              } else {
                  console.log(result.message);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error updating product:', xhr.responseText);
              alert('An error occurred while updating the product.');
          }
      });
  });
});
