$(function () {
    let aantalResultaten = 0;
    $('input[name="daterange"]').daterangepicker({
        opens: 'center',
        minDate: moment().toDate(),
        maxDate: moment().add(3, 'weeks').toDate(),
        startDate: moment().toDate(),
        isInvalidDate: function(date) {
            return (date.day() == 6 || date.day() == 0);
        }
    }, function (start, end, label) {
        let startDatum = start.format('YYYY-MM-DD');
        let eindDatum = end.format('YYYY-MM-DD');
        
        $.ajax({
            url: 'datePicker.php',
            type: 'GET',
            dataType: 'json',
            data: {
                startDatum: startDatum,
                eindDatum: eindDatum
            },
            success: function(data) {
                console.log("Ontvangen data:", data);
                
                let resultHtml = "";
                
                if (data.error) {
                    $(".resultaten").html(data.error);
                } else {
                    $.each(data, function(index, product) {
                        resultHtml +=
                            "<strong>Groep naam:</strong> " + product.groep_naam + "<br>";
                        resultHtml +=
                            "<strong>Merk naam:</strong> " + product.merk_naam + "<br>";
                        resultHtml +=
                            "<strong>Opmerkingen:</strong> " + (product.opmerkingen || "Geen opmerkingen") + "<br>";
                        resultHtml +=
                            "<strong>Beschrijving:</strong> " + product.beschrijving_naam + "<br>";
                        resultHtml +=
                            "<strong>Datum beschikbaar:</strong> " + product.datumBeschikbaar + "<br>";
                        resultHtml +=
                            "<strong>Zichtbaar:</strong> " + product.zichtbaar + "<br>";
                        resultHtml += "-------------------------<br>";
                        aantalResultaten++;
                    });
                    
                    $(".resultaten").html(resultHtml);
                    $(".aantalResultaten").text(aantalResultaten);
                }
            },                    
            
            error: function (error) {
                console.log("Fout bij het ophalen van de data:", error);
            }
        });
    });
});
