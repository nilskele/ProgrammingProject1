$(function() {
    $('#InOut3').empty();
    
    $.ajax({
        url: 'defect_backend.php',
        method: 'POST',
        dataType: 'json', 
        data: {},
        success: function(response) {
            console.log("1")
            try {
                if (response.error) {
                    console.error('Error from server:', response.error);
                    return;
                }
        
                
                response.forEach(function(item) {
                    var card = document.createElement('div');
                    card.className = 'inOutProduct';
                    
                    var productInfo = document.createElement('div');
                    productInfo.className = 'productInfo';
    
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
    
                    card.appendChild(productInfo);
    
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

