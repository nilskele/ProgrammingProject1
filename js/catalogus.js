$(document).ready(function () {
  $("#zoekForm").submit(function (e) {
    e.preventDefault();

    var zoekterm = $("#zoekbalk").val();
    if (zoekterm !== "") {
      $.ajax({
        url: "../php/zoek.php",
        type: "GET",
        data: {
          zoekbalk: zoekterm,
        },
        dataType: "json",
        success: function (data) {
          if (data.error) {
            $(".resultaten").html(data.error);
          } else {
            var resultHtml = "";
            $.each(data, function (index, value) {
              resultHtml += value + "<br>";
            });
            $(".resultaten").html(resultHtml);
          }
        },
        error: function () {
          alert("Er is een fout opgetreden bij het zoeken.");
        },
      });
    }
  });
});
