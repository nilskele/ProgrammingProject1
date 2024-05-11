$(function() {
  // ON WINDOW LOAD 
  window.onload = function() {
      var today = moment().format('YYYY-MM-DD');
      fetchDataUitleendatum(today);
      fetchDataTerugbrengDatum(today);
  };

  // IN AND OUT 
  function fetchDataUitleendatum(selectedDate) {
      // Clear existing data
      $('#smallInOut1').empty();
      $('#InOut1').empty();

      // Send the selected date to a PHP script using AJAX
      $.ajax({
          url: '/ProgrammingProject1/php/admin/inAndOut/inAndOutBackend.php',
          method: 'POST',
          data: { selectedDate: selectedDate, type: 'uitleendatum' },
          dataType: 'json', // Expect JSON response
          success: function(response) {
              // Loop through the data and create HTML elements
              response.forEach(function(item) {
                  // Check if the date matches the selected date
                  if (item.Uitleendatum === selectedDate) {
                      // Create a new card element
                      var card = document.createElement('div');
                      card.className = 'inOutProduct';
                      card.setAttribute('data-lening-id', item.lening_id); // Set data-lening-id attribute

                      // Create the product info div
                      var productInfo = document.createElement('div');
                      productInfo.className = 'productInfo';

                      // Populate the product info
                      productInfo.innerHTML = `
                          <div id="intButtons2">
                              <a class="outBtn" href="">Out</a>
                          </div>
                          <div class="info">
                              <h3 class="Naam">${item.voornaam} ${item.achternaam}</h3>
                              <p>${item.naam}, ${item.product_id}</p>
                          </div>
                          <div class="moreinfo">
                              <img class="dots" src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                          </div>
                      `;

                      // Append product info to card
                      card.appendChild(productInfo);

                      // Append the card to the appropriate container
                      try {
                          document.getElementById('smallInOut1').appendChild(card);
                      } catch (error) {
                          document.getElementById('InOut1').appendChild(card);
                          console.error("An error occurred:", error);
                      } 
                  }
              });
          },
          error: function(xhr, status, error) {
              console.error(error);
          }
      });
  }

  // Function to fetch and display data for terugbrengDatum
  function fetchDataTerugbrengDatum(selectedDate) {
      // Clear existing data
      $('#smallInOut2').empty();
      $('#InOut2').empty();

      // Send the selected date to a PHP script using AJAX
      $.ajax({
          url: '/ProgrammingProject1/php/admin/inAndOut/inAndOutBackend.php',
          method: 'POST',
          data: { selectedDate: selectedDate, type: 'terugbrengDatum' },
          dataType: 'json', // Expect JSON response
          success: function(response) {
              // Loop through the data and create HTML elements
              response.forEach(function(item) {
                  // Check if the date matches the selected date
                  if (item.terugbrengDatum === selectedDate) {
                      // Create a new card element
                      var card = document.createElement('div');
                      card.className = 'inOutProduct';
                      card.setAttribute('data-lening-id', item.lening_id); // Set data-lening-id attribute

                      // Create the product info div
                      var productInfo = document.createElement('div');
                      productInfo.className = 'productInfo';

                      // Populate the product info
                      productInfo.innerHTML = `
                          <div id="vandaagInButtons">
                              <a class="accepterenBtn" href="">Accepteren</a>
                              <a class="defectBtn defectButton" id="defectBtn90">Defect</a>
                          </div>
                          <div class="info">
                              <h5 class="Naam">${item.voornaam} ${item.achternaam}</h5>
                              <p>User ID: ${item.user_id}</p>
                              <p id="accepterenProductID" value="${item.product_id}">Product ID: ${item.product_id}</p>
                          </div>
                          <div class="moreinfo">
                              <img class="dots" src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                          </div>
                      `;

                      // Append product info to card
                      card.appendChild(productInfo);

                      // Append the card to the appropriate container
                      try {
                          document.getElementById('smallInOut2').appendChild(card);
                      } catch (error) {
                          document.getElementById('InOut2').appendChild(card);
                          console.error("An error occurred:", error);
                      }
                  }
              });
          },
          error: function(xhr, status, error) {
              console.error(error);
          }
      });
  }

  // Initialize date picker
  $('input[name="selectedDate"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: moment().year(), // Set minimum year to the current year
      maxYear: moment().year(), // Set maximum year to the current year
      minDate: moment(), // Set minimum date to today
      isInvalidDate: function(date) {
          // Disable Saturdays (day 6) and Sundays (day 0)
          return date.day() === 6 || date.day() === 0 || date.isBefore(moment(), 'day');
      }
  }, function(start, end, label) {
      var selectedDate = start.format('YYYY-MM-DD');

      // Call fetchDataUitleendatum function with the selected date
      fetchDataUitleendatum(selectedDate);

      // Call fetchDataTerugbrengDatum function with the selected date
      fetchDataTerugbrengDatum(selectedDate);
  });

  // Event listener for marking an item as returned
  $(document).on('click', '.outBtn', function(e) {
      e.preventDefault();

      // Store the context of 'this' in a variable
      var $this = $(this);

      // Retrieve the lening_id associated with the clicked row
      var leningId = $this.closest('.inOutProduct').data('lening-id');

      // Send AJAX request to update the terugbrengDatum to NULL in the database
      $.ajax({
          url: '/ProgrammingProject1/php/update_uitleendatum.php',
          method: 'POST',
          data: { leningId: leningId },
          success: function(response) {
              // Upon successful update, hide the row from the page
              if (response === 'success') {
                  $this.closest('.inOutProduct').hide();
              } else {
                  console.error('Failed to update terugbrengDatum');
              }
          },
          error: function(xhr, status, error) {
              console.error(error);
          }
      });
  });
});
