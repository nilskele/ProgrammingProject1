document.addEventListener("DOMContentLoaded", function () {
  // Function to fetch data from the server and populate the table
  function fetchDataAndPopulateTable() {
    // Ajax request to fetch data
    $.ajax({
      url: "mandjeOphalen.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        // Select the table body
        const tableBody = $("table tbody");

        // Clear existing table rows
        tableBody.empty();

        // Iterate over the data and create table rows
        data.forEach((row) => {
          // Create a new table row
          const newRow = $("<tr>");

          // Format Uitleendatum to 'dd/mm/yyyy' format
          const uitleendatumFormatted = row.Uitleendatum;
          const terugbrengDatumFormatted = row.terugbrengDatum;

          // Determine button classes based on possession
          const buttonClass = row.in_bezit === 1 ? "reserveren-button" : "uitlenen-button";

          // Populate the table row with data
          newRow.html(`
            <td>${row.groep_naam}</td>
            <td>${uitleendatumFormatted}</td>
            <td>${terugbrengDatumFormatted}</td>
            <td><button class="melden-button" value="${row.lening_id}">Melden</button></td>
            <td><button class="${buttonClass}" value="${row.lening_id}" data-id="${row.product_id}" style="background-color: ${row.in_bezit === 1 ? "green" : "red"}; color: white;">${row.in_bezit === 1 ? "Verlengen" : "Annuleren"}</button></td>
          `);

          // Append the new row to the table body
          tableBody.append(newRow);
        });
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      }
    });
  }

  function extendReturnDate(target) {
    const row = target.parentNode.parentNode; // Get the parent row
    const terugbrengDatumCell = row.cells[2]; // Get the third cell (terugbrengdatum)
    let returnDate = new Date(terugbrengDatumCell.textContent);
    const buttonText = target.textContent.trim(); // Get the text content of the button

    // Check the current action based on button text
    if (buttonText === "Annuleren") {
      // Decrease the return date by 7 days
      returnDate.setDate(returnDate.getDate() - 7);
    } else {
      // Add 7 days to the return date
      returnDate.setDate(returnDate.getDate() + 7);
    }

    const formattedDate = returnDate.toISOString().split("T")[0]; // Format as YYYY-MM-DD

    // Update the content of the third cell with the new date
    terugbrengDatumCell.textContent = formattedDate;

    // Toggle button text between "Verlengen" and "Annuleren"
    target.textContent = buttonText === "Annuleren" ? "Verlengen" : "Annuleren";

    // Toggle button class
    target.classList.toggle("verlengen-button");
    target.classList.toggle("annuleren-button");

    // Toggle button background color
    target.style.backgroundColor = buttonText === "Annuleren" ? "green" : "red";
  }

  // Function to decrease the return date by 7 days
  function decreaseReturnDate(target) {
    // Check if target is defined and is a button element
    if (target && target.tagName === "BUTTON") {
        const row = target.closest("tr"); // Find the closest parent table row
        if (row) {
            const terugbrengDatumCell = row.cells[2]; // Get the third cell (terugbrengdatum)
            if (terugbrengDatumCell) {
                let returnDate = new Date(terugbrengDatumCell.textContent);
                const buttonText = target.textContent.trim(); // Get the text content of the button

                // Check the current action based on button text
                if (buttonText === "Uitlenen") {
                    // Decrease the return date by 4 days
                    returnDate.setDate(returnDate.getDate() + 4);
                } else {
                    // Add 4 days to the return date
                    returnDate.setDate(returnDate.getDate() - 4);
                }

                const formattedDate = returnDate.toISOString().split("T")[0]; // Format as YYYY-MM-DD

                // Update the content of the third cell with the new date
                terugbrengDatumCell.textContent = formattedDate;

                // Toggle button text between "Uitlenen" and "Annuleren"
                target.textContent = buttonText === "Uitlenen" ? "Annuleren" : "Uitlenen";

                // Toggle button class
                target.classList.toggle("uitlenen-button");
                target.classList.toggle("annuleren-button");

                // Toggle button background color
                target.style.backgroundColor = buttonText === "Annuleren" ? "green" : "red";

                // Call AJAX to update database (assuming you want to update the return date in the database)
                const lening_id = target.value;
                updateDatabase(lening_id, formattedDate);
            }
        }
    }
}

  // Call the function to fetch data and populate the table when the page loads
  fetchDataAndPopulateTable();

  // Event delegation for button clicks
  $("table").on("click", "button", function () {
    const target = $(this);

    // Check if the clicked element is a button
    if (target.is("button")) {
      if (target.hasClass("reserveren-button")) {
        extendReturnDate(target);
      } else if (target.hasClass("uitlenen-button")) {
        const lening_id = target.val();
        deleteRowFromDatabase(lening_id);
        decreaseReturnDate(target);
      } else if (target.hasClass("melden-button")) {
        let buttonValue = target.val();
        $("#lening_id").val(buttonValue);
        toonMMeldenPopUp();

        const form = $("#defectMeldenForm");

        form.submit(function (event) {
          event.preventDefault();

          const lening_id = localStorage.getItem("product_id");
          $("#lening_id").val(lening_id);

          $.ajax({
            url: form.attr("action"),
            method: form.attr("method"),
            data: form.serialize(),
            success: function (response) {
              Swal.fire("Defect gemeld!", "Het defect is succesvol gemeld.", "success");
            },
            error: function (error) {
              console.error("Error:", error);
              Swal.fire({
                title: "Er is iets fout gegaan",
                text: "Probeer het later opnieuw.",
                icon: "error",
                confirmButtonText: "Ok",
              });
            }
          });
        });
      }
    }
  });

  let waarschuwingenCount = document.querySelector(".waarschuwingenCount");
  let waarschuwingenDiv = document.querySelector(".waarschuwingenDiv");

  if (waarschuwingenCount) {
    fetch("waarschuwingenCount.php")
      .then((response) => response.json())
      .then((data) => {
        let waarschuwingenCountPhp = data;
        waarschuwingenCount.textContent = waarschuwingenCountPhp - 1;
      })
      .catch((error) => console.error("Error fetching data:", error));
  } else {
    console.error("Element with class 'waarschuwingenCount' not found.");
  }

  // Function to display defect report popup
  function toonMMeldenPopUp() {
    document.getElementById("meldenPopUp").style.display = "block";
  }

  // Function to close defect report popup
  function sluitMMeldenPopUp() {
    document.getElementById("meldenPopUp").style.display = "none";
  }
});

function deleteRowFromDatabase(lening_id) {
  $.ajax({
    url: "deleteRowUitleningen.php",
    method: "POST",
    data: { "lening_id": lening_id },
    dataType: "json",
    success: function (data) {
      if (data.success) {
        console.log(data.message);
        window.location.reload();
      } else {
        console.error(data.message);
      }
    },
    error: function (error) {
      console.error("Error:", error);
    }
  });
}
