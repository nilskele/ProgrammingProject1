$(document).ready(function() {
    $('#zoekForm').submit(function(e) {
        e.preventDefault();

        var zoekterm = $('#zoekbalk').val();
        var categorie = $('#categorie').val();

        $.ajax({
            url: './zoek.php',
            type: 'GET',
            data: {
                zoekbalk: zoekterm,
                categorie: categorie
            },
            success: function(data) {
                $('.resultaten').html(data);
                console.log(data);
            },
            error: function() {
                alert('Er is een fout opgetreden bij het zoeken.');
            }
        });
    });
});
