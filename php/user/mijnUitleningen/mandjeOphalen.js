document.addEventListener("DOMContentLoaded", function () {
  function fetchDataAndPopulateTable() {
    console.log("Fetching data to populate the table...");
    $.ajax({
      url: "mandjeOphalen.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log("Data fetched successfully:", data);
        const tableBody = $("table tbody");
        tableBody.empty();

        data.forEach((row) => {
          const newRow = $("<tr>");
          const buttonClass = row.in_bezit === 1 ? "reserveren-button" : "uitlenen-button";
          let buttonText, action;

          if (row.isVerlenged) {
            buttonText = "Annuleren";
            action = "annuleren";
          } else if (row.in_bezit === 1) {
            buttonText = "Verlengen";
            action = "verlengen";
          } else {
            buttonText = "Annuleren";
            action = "annuleren";
          }

          newRow.html(`
            <td>${row.groep_naam}</td>
            <td>${row.Uitleendatum}</td>
            <td>${row.terugbrengDatum}</td>
            <td><button class="melden-button" value="${row.lening_id}" data-in_bezit="${row.in_bezit}">Melden</button></td>
            <td><button class="${buttonClass}" value="${row.lening_id}" data-id="${row.product_id}" style="background-color: ${(row.in_bezit === 1 && row.isVerlenged === 1) || row.in_bezit === 0 ? "red" : "green"}; color: white;">${buttonText}</button></td>
          `);

          tableBody.append(newRow);
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  function handleButtonClick(event) {
    const target = $(event.target);

    if (target.is("button")) {
      const button = target.get(0);
      const action = button.textContent.trim();

      if (action === "Verlengen") {
        extendReturnDate(button);
      } else if (action === "Annuleren") {
        if (button.classList.contains("reserveren-button")) {
          cancelExtension(button);
        } else if (button.classList.contains("uitlenen-button")) {
          cancelReservation(button);
        }
      } else if (action === "Melden") {
        reportDefect(button);
      }
    }
  }

  function extendReturnDate(button) {
    const row = button.closest("tr");
    const terugbrengDatumCell = row.cells[2];
    const lening_id = button.value;

    Swal.fire({
      title: "Ben je zeker?",
      text: "Wil je de uitleentermijn verlengen?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ja, verleng het",
      cancelButtonText: "Nee, annuleer",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "checkAlreadyUitgeleend.php",
          method: "POST",
          data: { lening_id: lening_id },
          dataType: "json",
          success: function (response) {
            if (response.allowExtension) {
              const currentDate = new Date();
              const returnDate = new Date(terugbrengDatumCell.textContent);
              returnDate.setDate(returnDate.getDate() + 7);
              const dayOfWeek = currentDate.getDay();

              if (currentDate > returnDate || dayOfWeek < 4 || dayOfWeek === 0) {
                Swal.fire({
                  title: "Verlenging niet toegestaan",
                  text: "Je kunt alleen verlengen op donderdag of later.",
                  icon: "error",
                  confirmButtonText: "Ok",
                });
                return;
              }

              button.textContent = "Annuleren";
              updateDate(lening_id, "verlengen", returnDate);
              button.classList.add("annuleren-button");
              button.classList.remove("reserveren-button");
              button.style.backgroundColor = "green";
              Swal.fire("Verlengd!", "De uitleentermijn is verlengd.", "success");
            } else {
              Swal.fire({
                title: "Verlenging niet toegestaan",
                text: "De uitleentermijn kan niet worden verlengd omdat er al een reservering is voor dit item.",
                icon: "error",
                confirmButtonText: "Ok",
              });
            }
          },
          error: function (error) {
            console.error("Error checking extension:", error);
          },
        });
      }
    });
  }

  function cancelExtension(button) {
    const lening_id = button.value;
    Swal.fire({
      title: "Ben je zeker?",
      text: "Wil je de verlenging annuleren?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ja, annuleer",
      cancelButtonText: "Nee, behoud",
    }).then((result) => {
      if (result.isConfirmed) {
        updateDate(lening_id, "annuleren");
        button.textContent = "Verlengen";
        button.classList.add("reserveren-button");
        button.classList.remove("annuleren-button");
        button.style.backgroundColor = "green";
        Swal.fire("Geannuleerd!", "De verlenging is geannuleerd.", "success").then(() => {
          window.location.reload();
        });
      }
    });
  }
  
  function cancelReservation(button) {
    const lening_id = button.value;
    Swal.fire({
      title: "Ben je zeker?",
      text: "Wil je de reservering annuleren?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ja, annuleer",
      cancelButtonText: "Nee, behoud",
    }).then((result) => {
      if (result.isConfirmed) {
        deleteRowFromDatabase(lening_id);
        button.closest("tr").remove();
        Swal.fire("Geannuleerd!", "De reservering is geannuleerd.", "success").then(() => {
          window.location.reload();
        });
      }
    });
  }

  function reportDefect(button) {
    const inBezit = button.dataset.in_bezit;
    if (inBezit === "1") {
      const lening_id = button.value;
      $("#lening_id").val(lening_id);
      toonMMeldenPopUp();

      const form = $("#defectMeldenForm");
      form.submit(function (event) {
        event.preventDefault();
        const watDefect = $("#watDefect").val();
        const redenDefect = $("#redenDefect").val();

        $.ajax({
          url: "defectMelden.php",
          method: "POST",
          data: { lening_id: lening_id, watDefect: watDefect, redenDefect: redenDefect },
          success: function (response) {
            Swal.fire("Defect gemeld!", "Het defect is succesvol gemeld.", "success");
            sluitMMeldenPopUp();
          },
          error: function (error) {
            console.error("Error reporting defect:", error);
            Swal.fire({
              title: "Er is iets fout gegaan",
              text: "Probeer het later opnieuw.",
              icon: "error",
              confirmButtonText: "Ok",
            });
          },
        });
      });
    } else {
      Swal.fire({
        title: "Niet toegestaan",
        text: "Je kunt dit item niet melden omdat je het niet in bezit hebt.",
        icon: "warning",
        confirmButtonText: "Ok",
      });
    }
  }

  function updateDate(lening_id, action, newDate = null) {
    const data = { lening_id: lening_id, action: action };
    if (newDate) {
      data.newDate = newDate.toISOString().split("T")[0];
    }

    $.ajax({
      url: "updateDate.php",
      method: "POST",
      data: data,
      dataType: "json",
      success: function (data) {
        if (data.success) {
          console.log("Date updated successfully:", data.message);
        } else {
          console.error("Error updating date:", data.message);
        }
      },
      error: function (error) {
        console.error("Error updating date:", error);
      },
    });
  }

  function deleteRowFromDatabase(lening_id) {
    $.ajax({
      url: "deleteRowUitleningen.php",
      method: "POST",
      data: { lening_id: lening_id },
      dataType: "json",
      success: function (data) {
        if (data.success) {
          console.log("Row deleted successfully:", data.message);
        } else {
          console.error("Error deleting row:", data.message);
        }
      },
      error: function (error) {
        console.error("Error deleting row:", error);
      },
    });
  }

  fetchDataAndPopulateTable();
  $("table").on("click", "button", handleButtonClick);

  let waarschuwingenCount = document.querySelector(".waarschuwingenCount");
  if (waarschuwingenCount) {
    fetch("waarschuwingenCount.php")
      .then((response) => response.json())
      .then((data) => {
        waarschuwingenCount.textContent = data - 1;
      })
      .catch((error) => console.error("Error fetching waarschuwingen count:", error));
  } else {
    console.error("Element with class 'waarschuwingenCount' not found.");
  }
});

function toonMMeldenPopUp() {
  document.getElementById("meldenPopUp").style.display = "block";
}

function sluitMMeldenPopUp() {
  document.getElementById("meldenPopUp").style.display = "none";
}
