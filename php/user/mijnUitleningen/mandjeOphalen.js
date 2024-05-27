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

          const uitleendatumFormatted = row.Uitleendatum;
          const terugbrengDatumFormatted = row.terugbrengDatum;

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
            <td>${uitleendatumFormatted}</td>
            <td>${terugbrengDatumFormatted}</td>
            <td><button class="melden-button" value="${row.lening_id}" data-in_bezit="${row.in_bezit}">Melden</button></td>
            <td><button class="${buttonClass}" value="${row.lening_id}" data-id="${row.product_id}" style="background-color: ${
            (row.in_bezit === 1 && row.isVerlenged === 1) || row.in_bezit === 0
              ? "red"
              : "green"
          }; color: white;">${buttonText}</button></td>
          `);

          tableBody.append(newRow);
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  function extendReturnDate(target) {
    console.log("Extending return date...");
    const button = target.get(0);

    if (button && button.tagName === "BUTTON") {
      const row = button.parentNode.parentNode;
      const terugbrengDatumCell = row.cells[2];
      const buttonText = button.textContent.trim();
      const isVerlenged = buttonText === "Annuleren";
      const lening_id = button.value;

      if (!isVerlenged) {
        Swal.fire({
          title: "Ben je zeker?",
          text: "Wil je de uitleentermijn verlengen?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ja, verleng het",
          cancelButtonText: "Nee, annuleer",
        }).then((result) => {
          if (result.isConfirmed) {
            const action = "verlengen";
            button.textContent = "Annuleren";
            updateDate(lening_id, action);
            let returnDate = new Date(terugbrengDatumCell.textContent);
            returnDate.setDate(returnDate.getDate() + 7);
            const formattedDate = returnDate.toISOString().split("T")[0];
            terugbrengDatumCell.textContent = formattedDate;
            button.classList.toggle("verlengen-button");
            button.classList.toggle("annuleren-button");
            button.style.backgroundColor = "green";
            Swal.fire("Verlengd!", "De uitleentermijn is verlengd.", "success");
          }
        });
      } else {
        Swal.fire({
          title: "Ben je zeker?",
          text: "Wil je de verlenging annuleren?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ja, annuleer het",
          cancelButtonText: "Nee, behoud",
        }).then((result) => {
          if (result.isConfirmed) {
            const action = "annuleren";
            updateDate(lening_id, action);
            let returnDate = new Date(terugbrengDatumCell.textContent);
            returnDate.setDate(returnDate.getDate() - 7);
            const formattedDate = returnDate.toISOString().split("T")[0];
            terugbrengDatumCell.textContent = formattedDate;
            button.textContent = "Verlengen";
            button.classList.toggle("verlengen-button");
            button.classList.toggle("annuleren-button");
            button.style.backgroundColor = "red";
            Swal.fire("Geannuleerd!", "De verlenging is geannuleerd.", "success");
          }
        });
      }
    } else {
      console.error("Target is not a button element or does not exist.");
    }
  }

  function decreaseReturnDate(target) {
    console.log("Decreasing return date...");
    if (target && target.tagName === "BUTTON") {
      const row = target.closest("tr");
      if (row) {
        const terugbrengDatumCell = row.cells[2];
        if (terugbrengDatumCell) {
          let returnDate = new Date(terugbrengDatumCell.textContent);
          const buttonText = target.textContent.trim();

          if (buttonText === "Uitlenen") {
            Swal.fire({
              title: "Ben je zeker?",
              text: "Wil je dit item uitlenen?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Ja, leen uit",
              cancelButtonText: "Nee, annuleer",
            }).then((result) => {
              if (result.isConfirmed) {
                returnDate.setDate(returnDate.getDate() + 4);
                const formattedDate = returnDate.toISOString().split("T")[0];
                terugbrengDatumCell.textContent = formattedDate;
                target.textContent = "Annuleren";
                target.classList.toggle("uitlenen-button");
                target.classList.toggle("annuleren-button");
                target.style.backgroundColor = "red";
                const lening_id = target.value;
                updateDatabase(lening_id, formattedDate);
                Swal.fire("Uitgeleend!", "Het item is uitgeleend.", "success");
              }
            });
          } else {
            Swal.fire({
              title: "Ben je zeker?",
              text: "Wil je de uitlening annuleren?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Ja, annuleer",
              cancelButtonText: "Nee, behoud",
            }).then((result) => {
              if (result.isConfirmed) {
                returnDate.setDate(returnDate.getDate() - 4);
                const formattedDate = returnDate.toISOString().split("T")[0];
                terugbrengDatumCell.textContent = formattedDate;
                target.textContent = "Uitlenen";
                target.classList.toggle("uitlenen-button");
                target.classList.toggle("annuleren-button");
                target.style.backgroundColor = "green";
                const lening_id = target.value;
                updateDatabase(lening_id, formattedDate);
                Swal.fire("Geannuleerd!", "De uitlening is geannuleerd.", "success");
              }
            });
          }
        }
      }
    }
  }

  fetchDataAndPopulateTable();

  $("table").on("click", "button", function () {
    const target = $(this);

    if (target.is("button")) {
      if (target.hasClass("reserveren-button")) {
        console.log("Reserveren button clicked");
        extendReturnDate(target);
      } else if (target.hasClass("uitlenen-button")) {
        console.log("Uitlenen button clicked");
        const lening_id = target.val();
        deleteRowFromDatabase(lening_id);
        decreaseReturnDate(target);
      } else if (target.hasClass("melden-button")) {
        const inBezit = target.data("in_bezit");
        if (inBezit === 1) {
          console.log("Melden button clicked");
          let buttonValue = target.val();
          $("#lening_id").val(buttonValue);
          toonMMeldenPopUp();

          const form = $("#defectMeldenForm");

          form.submit(function (event) {
            event.preventDefault();
            console.log("Submitting defect melden form...");
            const lening_id = $("#lening_id").val();
            const watDefect = $("#watDefect").val();
            const redenDefect = $("#redenDefect").val();

            $.ajax({
              url: "defectMelden.php",
              method: "POST",
              data: {
                lening_id: lening_id,
                watDefect: watDefect,
                redenDefect: redenDefect,
              },
              success: function (response) {
                console.log("Defect reported successfully:", response);
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
    }
  });

  let waarschuwingenCount = document.querySelector(".waarschuwingenCount");
  let waarschuwingenDiv = document.querySelector(".waarschuwingenDiv");

  if (waarschuwingenCount) {
    fetch("waarschuwingenCount.php")
      .then((response) => response.json())
      .then((data) => {
        console.log("Waarschuwingen count fetched successfully:", data);
        let waarschuwingenCountPhp = data;
        waarschuwingenCount.textContent = waarschuwingenCountPhp - 1;
      })
      .catch((error) => console.error("Error fetching waarschuwingen count:", error));
  } else {
    console.error("Element with class 'waarschuwingenCount' not found.");
  }
});

function toonMMeldenPopUp() {
  console.log("Displaying melden popup...");
  document.getElementById("meldenPopUp").style.display = "block";
}

function sluitMMeldenPopUp() {
  console.log("Closing melden popup...");
  document.getElementById("meldenPopUp").style.display = "none";
}

function deleteRowFromDatabase(lening_id) {
  console.log("Deleting row from database with lening_id:", lening_id);
  $.ajax({
    url: "deleteRowUitleningen.php",
    method: "POST",
    data: { lening_id: lening_id },
    dataType: "json",
    success: function (data) {
      if (data.success) {
        console.log("Row deleted successfully:", data.message);
        window.location.reload();
      } else {
        console.error("Error deleting row:", data.message);
      }
    },
    error: function (error) {
      console.error("Error deleting row:", error);
    },
  });
}

function updateDate(lening_id, action) {
  console.log("Updating date for lening_id:", lening_id, "with action:", action);
  $.ajax({
    url: "updateDate.php",
    method: "POST",
    data: { lening_id: lening_id, action: action },
    dataType: "json",
    success: function (data) {
      if (data.success) {
        console.log("Date updated successfully:", data.message);
        window.location.reload();
      } else {
        console.error("Error updating date:", data.message);
      }
    },
    error: function (error) {
      console.error("Error updating date:", error);
    },
  });
}
