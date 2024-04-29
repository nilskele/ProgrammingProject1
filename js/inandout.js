$(function() {
    // Function to fetch and display data
    function fetchData(selectedDate) {
        // Clear existing data
        $('#smallInOut1').empty();
        $('#smallInOut2').empty();

        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '../php/admin.inAndOutBackend.php',
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
                    
                    card.setAttribute('data-lening-id', item.lening_id); // Set data-lening-id attribute

                    // Create the product info div
                    var productInfo = document.createElement('div');
                    productInfo.className = 'productInfo';

                    // Populate the product info based on Uitleendatum or terugbrengDatum
                    if (item.terugbrengDatum === selectedDate) {
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
                    } else if (item.Uitleendatum === selectedDate) {
                        productInfo.innerHTML = `
                            <div class="intButtons2">
                                <a class="outBtn" href="">Out</a>
                            </div>
                            <div class="info">
                                <h3>${item.voornaam} ${item.achternaam}</h3>
                                <p>${item.naam}, ${item.product_id}</p>
                            </div>
                            <div class="moreinfo">
                                <img class="dots" src="../images/9025404_dots_three_icon.png" alt="More info image">
                            </div>
                        `;
                    }

                    // Append product info to card
                    card.appendChild(productInfo);

                    // Append the card to the appropriate container
                    if (item.terugbrengDatum === selectedDate) {
                        document.getElementById('smallInOut1').appendChild(card);
                    } else if (item.Uitleendatum === selectedDate) {
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

    // Event listener for accepting an item
    $(document).on('click', '.accepterenBtn', function(e) {
        e.preventDefault();

        // Store the context of 'this' in a variable
        var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
        var leningId = $this.closest('.inOutProduct').data('lening-id');

        // Send AJAX request to delete the row from the database
        $.ajax({
            url: '../php/delete_row.php',
            method: 'POST',
            data: { leningId: leningId },
            success: function(response) {
                // Upon successful deletion, remove the corresponding row from the HTML
                if (response === 'success') {
                    // Remove the closest '.inOutProduct' element
                    $this.closest('.inOutProduct').remove();
                } else {
                    console.error('Failed to delete row');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
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
            url: '../php/update_uitleendatum.php',
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

    // Fetch data for today on window load
    window.onload = function() {
        var today = moment().format('YYYY-MM-DD');
        fetchData(today);
        console.log("checkcheck");
    };
});
