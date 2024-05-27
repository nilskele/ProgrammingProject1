$(document).ready(function() {

    // functie om een nieuwe kaart te maken voor de blacklist
    function addToBlacklist(naam, datum, user_id) {
        let item = '<div class="Item">' +
            '<h4 class="Naam">' + naam + '</h4>' +
            '<p class="Datum">Tot: <span class="datumTekst">' + datum + '</span></p>' +
            '<button class="btn btn-primary Verwijderen" value="' + user_id +'">Uit blacklist halen</button>' +
            '</div>';
        $('.blacklistLijst').append(item);
    }

    // functie om een nieuwe kaart te maken voor de waarschuwingen
    function addToWaarschuwingen(naam, datum, user_id) {
        let item = '<div class="Item">' +
            '<h4 class="Naam">' + naam + '</h4>' +
            '<p class="Datum">Gekregen op: <span class="datumTekst">' + datum + '</span></p>' +
            '<button class="btn btn-primary Verwijderen" value="' + user_id +'">Uit waarschuwingen halen</button>' +
            '</div>';
        $('.waarschuwingLijst').append(item);
    }

    // AJAX-oproep om de blacklist en waarschuwingen op te halen
    $.ajax({
        url: '../blacklist/blacklist.backend.php',
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

    // functie om een gebruiker te verwijderen uit de blacklist
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
                    url: '../blacklist/blacklist.verwijderenBlacklist.php',
                    type: 'POST',
                    data: { user_id: user_id },
                    success: function(response) {
                        console.log(response);
                        if (response === 'success') {
                            $this.closest('.Item').remove();
                            location.reload();
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

    // functie om te zoeken naar studenten in de blacklist
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

    // functie om te zoeken naar studenten in de waarschuwingen
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

// functie om de pop-up te openen voor het toevoegen van een persoon aan de blacklist
function OpenPersoonWaarschuwen() {
    document.getElementById("waarschuwenPersoonPopUPDiv").style.display = "block";
}
  // functie om de pop-up te sluiten voor het toevoegen van een persoon aan de blacklist
  function ClosePersoonWaarschuwen() {
    document.getElementById("waarschuwenPersoonPopUPDiv").style.display = "none";
}

// functie om een persoon toe te voegen aan de blacklist
document.getElementById("waarschuwenBtnForm").addEventListener("click", function(e) {
    e.preventDefault();

    let email = document.getElementById("inputEmail3").value.trim();
    if (!email) {
        Swal.fire({
            icon: "error",
            title: "Vul een geldig e-mailadres in!"
        });
        return;
    }

    // AJAX-oproep om een persoon toe te voegen aan de blacklist
    $.ajax({
        url: '../blacklist/toevoegenPersoonBlacklist.php',
        type: 'POST',
        data: { email: email },
        success: function(response) {
            console.log(response);
            if (response === 'geupdate') {
                Swal.fire({
                    icon: "success",
                    title: "Deze persoon is succesvol gewaarschuwd!"
                }).then((result) => {
                    location.reload();
                });
                document.getElementById("inputEmail3").value = "";
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Er is een probleem opgetreden. Deze persoon kon niet worden gewaarschuwd."
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Fout bij het ophalen van gegevens: ' + error);
            Swal.fire({
                icon: "error",
                title: "Er is een serverfout opgetreden. Probeer het later opnieuw."
            });
        }
    });
});

