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
                        addToBlacklist(item.voornaam + ' ' + item.achternaam, item.blacklistDatum, item.user_id);
                    } else if (item.blacklist_fk === 2) {
                        addToWaarschuwingen(item.voornaam + ' ' + item.achternaam, item.blacklistDatum, item.user_id);
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
    });
});
