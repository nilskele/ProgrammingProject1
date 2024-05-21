$(document).ready(function () {
    let productenLijstDiv = document.getElementById('productenLijstDiv');
    let KitNr = localStorage.getItem('KitNr');
    console.log('KitNr:', KitNr);
    let naamKit = document.getElementById('naamKit');
    let idKit = document.getElementById('idKit');
    let naamPersoon = document.getElementById('naamPersoon');
    let emailPersoon = document.getElementById('emailPersoon');
    let aantalProductenBinnen = document.getElementById('aantalProductenBinnen');
    let aantalGeaccepteerdeProducten = 0;  


    function toonProducten(data) {
        if (data.error) {
            productenLijstDiv.innerHTML = data.error;
            return;
        }

        let productenHtml = "";

        naamKit.innerHTML = data[0].kit_naam;
        idKit.innerHTML = data[0].kit_id_fk;
        naamPersoon.innerHTML = data[0].voornaam + ' ' + data[0].achternaam;  
        emailPersoon.innerHTML = data[0].email;
        aantalProductenBinnen.innerHTML = aantalGeaccepteerdeProducten +  "/" + data.length + " producten zijn geaccepteerd";

        $.each(data, function (index, item) {
            productenHtml += `
            <div class="product">
                <div class="product-content">
                    <img src="data:image/jpeg;base64,${item.image_data}" class="img-fluid">
                    <h1 class="product-titel">${item.naam}</h1>
                    <h6 class="product-id">Product ID: ${item.product_id_fk}</h6>
                </div>
                <div class="productBtns">
                    <button class="btn btn-primary accepteerProduct" data-id="${item.product_id_fk}">Accepteer</button>
                    <button class="btn defectBtnKit" data-id="${item.product_id_fk}">Defect</button>
                </div>
            </div>
            `;
        });

        productenLijstDiv.innerHTML = productenHtml;
    }

    $.ajax({
        url: 'accepterenKitsProductenLaden.php',
        type: 'GET',
        dataType: 'json',
        data: { KitNr: KitNr },
        success: function (data) {
            toonProducten(data);
        },
        error: function (xhr, status, error) {
            console.error('Error occurred:', error);
            console.error('Response text:', xhr.responseText);
            if (productenLijstDiv) {
                productenLijstDiv.innerHTML = 'Er zijn geen producten gevonden. Fout: ' + error;
            }
        }
    });
});
