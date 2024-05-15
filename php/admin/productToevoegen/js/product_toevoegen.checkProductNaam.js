$(document).ready(function() {
  var hasSubmitted = false; // Declare the variable here

  // Function to check if the product name already exists
  function checkProductName(productName) {
    $.ajax({
      url: '/ProgrammingProject1/php/admin/productToevoegen/product_toevoegen.product_naam.php',
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
            // Show SweetAlert confirmation dialog
            Swal.fire({
              title: "Product Name Exists",
              text: "Do you want to use the existing name?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              dangerMode: true,
            }).then((result) => {
              if (result.isConfirmed) {
                // If user wants to use existing name, submit the form
                $('form').submit();
                hasSubmitted = true; // Set the flag to true
              } else {
                // If user doesn't want to use existing name, do nothing
              }
            });
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
    if (productName === undefined && productName.trim() === '') {
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