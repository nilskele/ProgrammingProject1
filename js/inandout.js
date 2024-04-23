$(function() {
    var today = moment().format('YYYY-MM-DD');
    
    window.onload = function() {
        fetchData(today);
        console.log("checkcheck")
    };
    // Function to fetch and display data
    function fetchData(selectedDate) {
        // Clear existing data
        $('#smallInOut1').empty();
        $('#smallInOut2').empty();

        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '../php/inAndOutBackend.php',
            method: 'POST',
            data: { selectedDate: selectedDate },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
    
                // Loop through the data and create HTML elements
                data.forEach(function(item) {
                    // Create a new card element
                    var card = document.createElement('div');
                    card.className = 'inOutProduct';
                    // Create the product info div
                    var productInfo = document.createElement('div');
                    productInfo.className = 'productInfo';
    
                    // Populate the product info
                    productInfo.innerHTML = `
                        <div id="vandaagInButtons">
                            <a class="accepterenBtn" href="">Accepteren</a>
                            <a class="defectBtn defectButton" href="">Defect</a>
                        </div>
                        <div class="info">
                            <h5>${item.voornaam} ${item.achternaam}</h5>
                            <p>User ID: ${item.user_id}</p>
                            <p>Product ID: ${item.product_id}</p>
                        </div>
                        <div class="moreinfo">
                            <img class="dots" src="../images/9025404_dots_three_icon.png" alt="More info image">
                        </div>
                    `;
    
                    // Append product info to card
                    card.appendChild(productInfo);
    
                    // Append the card to the appropriate container
                    if (item.Uitleendatum === selectedDate) {
                        document.getElementById('smallInOut1').appendChild(card);
                    } else if (item.terugbrengDatum === selectedDate) {
                        document.getElementById('smallInOut2').appendChild(card);
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
        
        // Call fetchData function with the selected date
        fetchData(selectedDate);
    });
    

});