$(document).ready(function() {
    function addToBlacklist(naam, datum, user_id) {
        let item = '<div class="Item">' +
            '<h4 class="Naam">' + naam + '</h4>' +
            '<p class="Datum">Tot: <span class="datumTekst">' + datum + '</span></p>' +
            '<button class="btn btn-primary Verwijderen" value="' + user_id +'">Uit blacklist halen</button>' +
            '</div>';
        $('.blacklistLijst').append(item);
    }

    function addToWaarschuwingen(naam, datum, user_id) {
        let item = '<div class="Item">' +
            '<h4 class="Naam">' + naam + '</h4>' +
            '<p class="Datum">Tot: <span class="datumTekst">' + datum + '</span></p>' +
            '<button class="btn btn-primary Verwijderen" value="' + user_id +'">Uit waarschuwingen halen</button>' +
            '</div>';
        $('.waarschuwingLijst').append(item);
    }

    $.ajax({
        url: '../php/admin.blacklist.backend.php',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                $.each(data, function(index, item) {
                    if (item.blacklist_fk === 3) {
                        addToBlacklist(item.voornaam + ' ' + item.achternaam, item.blacklistDatum || "Geen datum opgeslagen", item.user_id);
                    } else if (item.blacklist_fk === 2) {
                        addToWaarschuwingen(item.voornaam + ' ' + item.achternaam, item.blacklistDatum || "Geen datum opgeslagen", item.user_id);
                    }
                });
            } else {
                console.log('Geen resultaten gevonden');
            }
        },
        error: function(xhr, status, error) {
            console.log('Fout bij het ophalen van gegevens: ' + error);
        }
    });

    $(document).on('click', '.Verwijderen', function(e) {
        Swal.fire({
            title: "Weet je zeker of je deze gebruiker wilt verwijderen uit deze lijst?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, verwijderen!",
        }).then ((result) => {
            if (result.isConfirmed) {
                location.reload();
        
                let user_id = $(this).val(); 

                let $this = $(this); 

                $.ajax({
                    url: '../php/admin.blacklist.verwijderenBlacklist.php',
                    type: 'POST',
                    data: { user_id: user_id },
                    success: function(response) {
                        console.log(response);
                        if (response === 'success') {
                            $this.closest('.Item').remove();

                        } else {
                            console.error('Fout bij het verwijderen van de blacklist');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Fout bij het ophalen van gegevens: ' + error);
                    }
                });
            }
        });
    });


    $('.inputZoekbalk1').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('.blacklistLijst .Item').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('.inputZoekbalk2').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('.waarschuwingLijst .Item').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});


function OpenPersoonWaarschuwen() {
    document.getElementById("waarschuwenPersoonPopUPDiv").style.display = "block";
  }
  
  function ClosePersoonWaarschuwen() {
    document.getElementById("waarschuwenPersoonPopUPDiv").style.display = "none";
  }