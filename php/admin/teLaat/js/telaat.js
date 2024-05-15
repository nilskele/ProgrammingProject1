$(function() {
    // IN AND OUT
    function teLaatTerugGebracht() {
        // Clear existing data
        
        $('#InOut3').empty();
    
        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '../teLaat/teLaatIngebracht.backend.php', 
            method: 'POST',
            
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
    
                // Loop through the data and create HTML elements
                data.forEach(function(item) {
                    // Check if the date matches the selected date
                    
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
                                <a class="defectBtn defectButton" id="defectBtn90" href="">Defect</a>
                            </div>
                            <div class="info">
                                <h5 class="Naam">${item.voornaam} ${item.achternaam}</h5>
                                <p>User ID: ${item.user_id}</p>
                                <p id="accepterenProductID" style="display: none;" value="${item.product_id}"></p>
                                <p id="emailDefect" style="display: none;" value="${item.email}"></p>
                                <p>Product ID: ${item.product_id}</p>
                            </div>
                            <div class="moreinfo">
                                <img class="dots" src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                            </div>
                        `;
    
                        // Append product info to card
                        card.appendChild(productInfo);
    
                        document.getElementById('InOut3').appendChild(card);
                        
                    
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }


    //ON WINDOW LOAD 
     
    

    // Event listener for accepting an item
    $(document).on('click', '.accepterenBtn', function(e) {
        e.preventDefault();

        // Store the context of 'this' in a variable
        var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
        var leningId = $this.closest('.inOutProduct').data('lening-id');

        // Send AJAX request to delete the row from the database
        $.ajax({
            url: '../../productAccepteren.php',
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

    $(document).off('click', '#defectBtn90').on('click', '#defectBtn90', function(event) {
        event.preventDefault();
        let productnr = $(this).closest('.inOutProduct').find('#accepterenProductID').attr('value');
        let email = $(this).closest('.inOutProduct').find('#emailDefect').attr('value');

        if (productnr) {
            localStorage.setItem("productNr", productnr);
            localStorage.setItem("email", email);
        } else {
            console.log("No numerical value found.");
        }
        window.location.href = "/ProgrammingProject1/php/admin/inAndOut/defectProduct.php";
    });

    $('.inputZoekbalk5').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#InOut3 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    teLaatTerugGebracht();
});