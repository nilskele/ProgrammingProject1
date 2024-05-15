document.addEventListener("DOMContentLoaded", function () {
  // Function to fetch data from the server and populate the table
  function fetchDataAndPopulateTable() {
    fetch("mandjeOphalen.php")
      .then((response) => response.json())
      .then((data) => {
        // Select the table body
        const tableBody = document.querySelector("table tbody");

        // Clear existing table rows
        tableBody.innerHTML = "";

        // Iterate over the data and create table rows
        data.forEach((row) => {
          // Create a new table row
          const newRow = document.createElement("tr");

          // Format Uitleendatum to 'dd/mm/yyyy' format
          const uitleendatumFormatted = (row.Uitleendatum);
          const terugbrengDatumFormatted = (row.terugbrengDatum);

          // Determine button classes based on possession
          const buttonClass =
            row.in_bezit === 1 ? "reserveren-button" : "uitlenen-button";

          // Populate the table row with data
          newRow.innerHTML = `
            <td>${row.groep_naam}</td>
            <td>${uitleendatumFormatted}</td>
            <td>${terugbrengDatumFormatted}</td>
            <td><button class="melden-button" value="${
              row.lening_id
            }">Melden</button></td>
            <td><button class="${buttonClass}" value="${row.lening_id}" data-id="${
            row.product_id
          }" style="background-color: ${
            row.in_bezit === 1 ? "green" : "red"
          }; color: white;">${
            row.in_bezit === 1 ? "Verlengen" : "Annuleren"
          }</button></td>
          `;

          // Append the new row to the table body
          tableBody.appendChild(newRow);
        });
      })
      .catch((error) => console.error("Error fetching data:", error));
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

    const formattedDate = returnDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD

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
  const row = target.parentNode.parentNode; // Get the parent row
  const terugbrengDatumCell = row.cells[2]; // Get the third cell (terugbrengdatum)
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

  const formattedDate = returnDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD

  // Update the content of the third cell with the new date
  terugbrengDatumCell.textContent = formattedDate;

  // Toggle button text between "Uitlenen" and "Annuleren"
  target.textContent = buttonText === "Uitlenen" ? "Annuleren" : "Uitlenen";

  // Toggle button class
  target.classList.toggle("uitlenen-button");
  target.classList.toggle("annuleren-button");

  // Toggle button background color
  target.style.backgroundColor = buttonText === "Annuleren" ? "green" : "red";
}

  // Call the function to fetch data and populate the table when the page loads
  fetchDataAndPopulateTable();

  // Event delegation for button clicks
  document.querySelector("table").addEventListener("click", function (event) {
    const target = event.target;

    // Check if the clicked element is a button
    if (target.tagName === "BUTTON") {
      if (target.classList.contains("reserveren-button")) {
        extendReturnDate(target);
    } else if (target.classList.contains("uitlenen-button")) {
        const lening_id = target.value;

        deleteRowFromDatabase(lening_id);
        decreaseReturnDate(target);
    } else if (target.classList.contains("melden-button")) {
      let buttonValue = target.getAttribute("value");
      document.getElementById("lening_id").value = buttonValue;
      toonMMeldenPopUp();

      const form = document.getElementById("defectMeldenForm");

      form.addEventListener("submit", function (event) {
          event.preventDefault();

          const lening_id = localStorage.getItem("product_id");
          document.getElementById("lening_id").value = lening_id;

          const formData = new FormData(form);

          fetch(form.action, {
            method: "POST",
            body: formData,
          })
            .then((response) => {
              if (response.ok) {
                Swal.fire(
                  "Defect gemeld!",
                  "Het defect is succesvol gemeld.",
                  "success"
                );
              } else {
                throw new Error("Failed to submit form.");
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              Swal.fire({
                title: "Er is iets fout gegaan",
                text: "Probeer het later opnieuw.",
                icon: "error",
                confirmButtonText: "Ok",
              });
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
  // Create a FormData object with the loan ID
  const formData = new FormData();
  formData.append("lening_id", lening_id);

  // Fetch request to the PHP script
  fetch("deleteRowUitleningen.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Row deleted successfully, perform any additional actions here if needed
        console.log(data.message);
      } else {
        // Error occurred while deleting row, handle the error
        console.error(data.message);
      }
    })
    .catch((error) => {
      // Error occurred while fetching or parsing response, handle the error
      console.error("Error:", error);
    });
}

