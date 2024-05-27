$(document).ready(function () {
    let kitNaamInput = document.getElementById('kitNaam');
    let correctSpan = document.getElementById('correctSpan');

    // functie om te controleren of de kitnaam al bestaat
    kitNaamInput.addEventListener('keyup', function () {
        let kitNaam = kitNaamInput.value;
        $.ajax({
            url: 'checkKitNaam.php',
            type: 'GET',
            dataType: 'json',
            data: { kitNaam: kitNaam },
            success: function (data) {
                if (data.exists) {
                    correctSpan.innerHTML = 'Deze kitnaam bestaat al';
                } else {
                    correctSpan.innerHTML = '';
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                console.error('Response text:', xhr.responseText);
            }
        });
    });

    let groepinput = document.getElementById('groepinput');

    // AJAX-oproep om alle groepen op te halen
    $.ajax({
        url: 'getGroepen.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.groepen) {
                data.groepen.forEach(function(groep) {
                    let option = document.createElement('option');
                    option.value = groep;
                    option.innerHTML = groep;
                    groepinput.appendChild(option);
                });
            } else if (data.error) {
                console.error('Error fetching groups:', data.error);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            console.error('Response text:', xhr.responseText);
        }
    });

    let productenList = document.getElementById('productenList');
    let toevoegenProductBtn = document.getElementById('toevoegenProductBtn');

    // Event listener voor het toevoegen van een product aan de lijst
    toevoegenProductBtn.addEventListener('click', function () {
        let selectedOption = groepinput.options[groepinput.selectedIndex];
        let product = selectedOption.value;
        if (product == 'all') {
            return;
        }
        let productLi = document.createElement('li');
        productLi.innerHTML = product;
        productenList.appendChild(productLi);
    });

    let categrieSelect = document.getElementById('categrieSelect');

    // AJAX-oproep om alle categorieën op te halen
    if (categrieSelect) {
        $.ajax({
            url: 'getCategoryKit.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data && data.length > 0) {
                    data.forEach(function (categorie) {
                        let option = document.createElement('option');
                        option.value = categorie.cat_id;
                        option.innerHTML = categorie.naam;
                        categrieSelect.appendChild(option);
                    });
                } else {
                    console.error('No categories found');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                console.error('Response text:', xhr.responseText);
            }
            });
    } else {
        console.error('categrieSelect element not found');
    }

    let merkSelect = document.getElementById('merkSelect');

    // AJAX-oproep om alle merken op te halen
    if (merkSelect) {
        $.ajax({
            url: 'getMerkKit.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data && data.length > 0) {
                    data.forEach(function (merk) {
                        let option = document.createElement('option');
                        option.value = merk.merk_id;
                        option.innerHTML = merk.naam;
                        merkSelect.appendChild(option);
                    });
                } else {
                    console.error('No brands found');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                console.error('Response text:', xhr.responseText);
            }
        });
    } else {
        console.error('merkSelect element not found');
    }

    // Event listener voor het toevoegen van een kit
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let kitNaam = kitNaamInput.value;
        let categorie = categrieSelect.options[categrieSelect.selectedIndex].value;
        if (categorie == 'all') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Selecteer een categorie'
            });
            return;
        }

        let merk = merkSelect.options[merkSelect.selectedIndex].value;

        if (merk == 'all') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Selecteer een merk'
            });
            return;
        }

        let producten = [];

        let productLis = productenList.getElementsByTagName('li');
        for (let i = 0; i < productLis.length; i++) {
            producten.push(productLis[i].innerHTML);
        }

        let formFile = document.getElementById('formFile');

        if (formFile.files.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Selecteer een afbeelding'
            });
            return;
        }
        
        Swal.fire({
            icon: 'warning',
            title: 'Weet u zeker dat u deze kit wilt toevoegen?',
            showCancelButton: true,
            confirmButtonText: 'Ja',
            cancelButtonText: 'Nee'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData(this);

                // Voeg extra gegevens toe aan FormData
                formData.append('kitNaam', $('#kitNaam').val());
                formData.append('categorie', $('#categrieSelect').val());
                formData.append('merk', $('#merkSelect').val());

                // Voeg geselecteerde producten toe
                var producten = [];
                $('#groepinput option:selected').each(function() {
                    producten.push($(this).val());
                });
                formData.append('producten', JSON.stringify(producten));

                $.ajax({
                    url: 'kit_toevoegenBackend.php',
                    type: 'POST',
                    data: formData,
                    processData: false, // Belangrijk: Zet dit op false om de data correct te verzenden
                    contentType: false, // Belangrijk: Zet dit op false om de data correct te verzenden
                    success: function (data) {
                        if (data.error) {
                            console.error('Error adding kit:', data.error);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succes',
                                text: 'Kit toegevoegd'
                            });
                            $('#form')[0].reset();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error:', error);
                        console.error('Response text:', xhr.responseText);
                    }
                });
            }
        });
    });
});
