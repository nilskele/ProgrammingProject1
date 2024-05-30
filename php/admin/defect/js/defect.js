$(function() {
    $('#InOut3').empty();
    
    $.ajax({
        url: 'defect_backend.php',
        method: 'POST',
        dataType: 'json', 
        data: {},
        success: function(response) {
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
                            <p class="accepterenProductID">${item.email}</p>
                        </div>
                        <div class="info">
                            <p class="Naam">Wat is er kapot: ${item.watDefect}</p>
                            <p class="accepterenProductID">Hoe is het kapot: ${item.redenDefect}</p>
                        </div>
                        <p class="productNr">Product Nr: ${item.product_id}</p>
                        <button class="oplossenButton btn btn-dark" value="${item.defect_id}">Oplossen</button>
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

    $('#InOut3').on('click', '.oplossenButton', function() {
        let defect_id = $(this).val();

        Swal.fire({
            title: 'Weet u zeker dat u dit defect wilt oplossen?',
            text: 'Dit kan niet ongedaan worden!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ja, oplossen!',
            cancelButtonText: 'Annuleren'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'oplossen_defect.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        defect_id: defect_id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Defect opgelost!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'Fout!',
                                text: response.message,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });
    });
});
