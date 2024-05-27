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
    let aantalProducten = 0;

    // functoe om alle producten van een kit te tonen in de frontend
    function toonProducten(data) {
        if (data.error) {
            productenLijstDiv.innerHTML = data.error;
            return;
        }

        let productenHtml = "";

        aantalProducten = data[0].aantalProducten;
        naamKit.innerHTML = data[0].kit_naam;
        idKit.innerHTML = data[0].kit_id_fk;
        naamPersoon.innerHTML = data[0].voornaam + ' ' + data[0].achternaam;
        emailPersoon.innerHTML = data[0].email;
        aantalProductenBinnen.innerHTML = aantalGeaccepteerdeProducten + "/" + aantalProducten + " producten zijn geaccepteerd";

        $.each(data, function (index, item) {
            productenHtml += `
            <div class="product">
                <div class="product-content">
                    <img src="data:image/jpeg;base64,${item.image_data}" class="img-fluid">
                    <h1 class="product-titel">${item.naam}</h1>
                    <h6 class="product-id">Product ID: ${item.product_id_fk}</h6>
                </div>
                <div class="productBtns">
                    <button class="btn btn-primary accepteerProduct" data-id="${item.product_id_fk}" data-lening-id="${item.lening_id}" id="accepterenBtn-${item.product_id_fk}">Accepteer</button>
                    <button class="btn defectBtnKit" data-id="${item.product_id_fk}">Defect</button>
                </div>
            </div>
            `;
        });

        productenLijstDiv.innerHTML = productenHtml;
    }

    // AJAX-oproep om alle producten van een kit te tonen
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

    let kitAccepterenBtn = document.getElementById('kitAccepterenBtn');
    kitAccepterenBtn.disabled = true;

    // Event listener voor het accepteren van een product
    productenLijstDiv.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('accepteerProduct')) {
            let productId = e.target.getAttribute('data-id');
            let leningId = e.target.getAttribute('data-lening-id');
            let accepterenBtn = document.getElementById('accepterenBtn-' + productId);
            accepterenBtn.innerHTML = 'Geaccepteerd';
            accepterenBtn.disabled = true;

            // AJAX-oproep om een product te accepteren
            $.ajax({
                url: '/ProgrammingProject1/php/productAccepteren.php',
                type: 'POST',
                data: {
                    productNr: productId,
                    leningId: leningId
                },
                success: function (data) {
                    // button accepteren veranderen naar geaccepteerd
                    console.log('Product geaccepteerd:', data);
                    aantalGeaccepteerdeProducten++;
                    aantalProductenBinnen.innerHTML = aantalGeaccepteerdeProducten + "/" + aantalProducten + " producten zijn geaccepteerd";
                    if (aantalGeaccepteerdeProducten === aantalProducten) {
                        kitAccepterenBtn.disabled = false;
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error occurred:', error);
                    console.error('Response text:', xhr.responseText);
                    accepterenBtn.innerHTML = 'Accepteer';
                    accepterenBtn.disabled = false; 
                }
            });
        }

        // Event listener voor het defect maken van een product naar de defectProduct.php pagina
        if (e.target.classList.contains('defectBtnKit')) {
            let productNr = e.target.getAttribute('data-id');
            let email = emailPersoon.innerHTML;

            localStorage.setItem('productNr', productNr);
            localStorage.setItem('email', email);

            window.location.href = '/ProgrammingProject1/php/admin/inAndOut/defectProduct.php';
        }
    });

    // Functie om voor het specifieke product naar de defectProduct pagina te gaan
    kitAccepterenBtn.addEventListener('click', function () {
        $.ajax({
            url: 'kitAccepterenBackend.php',
            type: 'GET',
            data: {
                kit_id_fk: idKit.innerHTML,
            },
            success: function (data) {
                console.log('Kit geaccepteerd:', data);
                window.location.href = '/ProgrammingProject1/php/admin/admin.index.php';
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
                console.error('Response text:', xhr.responseText);
            }
        });
    });
});
