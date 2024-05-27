$(function() {
    // Clear existing data
    $('#InOut3').empty();
    
    // Send the request to the PHP script using AJAX
    $.ajax({
        url: 'defect_backend.php',
        method: 'POST',
        dataType: 'json', // Expect a JSON response
        data: {},
        success: function(response) {
            // The response is already parsed as JSON, no need to call JSON.parse
            try {
                // Check if the response contains an error
                if (response.error) {
                    console.error('Error from server:', response.error);
                    return;
                }
                
                // Loop through the data and create HTML elements
                response.forEach(function(item) {
                    // Create a new card element
                    var card = document.createElement('div');
                    card.className = 'inOutProduct';
                    
                    // Create the product info div
                    var productInfo = document.createElement('div');
                    productInfo.className = 'productInfo';
    
                    // Populate the product info
                    productInfo.innerHTML = `
                        <div id="vandaagInButtons">
                             <h6>${item.naam}</h6>
                            <img class="statusImage1" src="data:image/jpeg;base64,${item.image_data}">
                        </div>
                        <div class="info">
                        <p>${item.voornaam} ${item.achternaam}</p>
                        <p class="accepterenProductID"  value="${item.email}">${item.email}</p>
                        <p class="productNr"  value="${item.product_id}"> Product Nr:${item.product_id}</p>
                        </div>
                        <div class="info">
                            <p class="Naam" value="">wat is er kapot: ${item.watDefect}</p>
                            <p class="accepterenProductID" value="">hoe is het kapot: ${item.redenDefect}</p>
                        </div>
                    `;
    
                    // Append product info to card
                    card.appendChild(productInfo);
    
                    // Append the card to the appropriate container
                    document.getElementById('InOut3').appendChild(card);
                });
            } catch (e) {
                console.error('Error handling the response:', e);
                console.log('Raw response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
    
    // Implement the search functionality
    $('.inputZoekbalk6').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();
    
        $('#InOut3 .inOutProduct').each(function() {
            let productNr = $(this).find('.productNr').text().toLowerCase();
    
            if (productNr.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

