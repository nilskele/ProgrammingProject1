var hasSubmitted = false; // Declare hasSubmitted globally

$(document).ready(function() {
  // Event listener for form submission
  $('form').submit(function(e) {
    e.preventDefault();
    var beschrijving = $('#beschrijving').val();
    checkMerk(beschrijving);
  });

  // Event listener for keydown event on input fields
  $('#productName, #merk').on('keydown', function(e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      $('#productForm').submit();
    }
  });
});

// JavaScript Functionality for Merk Check
function checkMerk(merk) {
  $.ajax({
    url: 'admin.product_toevoegen.beschrijving.php',
    method: 'POST',
    data: {
      merk: merk
    },
    success: function(response) {
      console.log(response);
      if (!hasSubmitted) {
        if (response === 'exists') {
          console.log('The brand already exists.');
          $('#brandMessage').text('This brand already exists.').addClass('error-message');
        } else {
          console.log('The brand does not exist.');
          $('#brandMessage').text('');
          $('#productForm').submit();
          hasSubmitted = true;
        }
      }
    },
    error: function(xhr, status, error) {
      console.error('Error:', error);
    }
  });
}
