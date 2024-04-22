document.addEventListener("DOMContentLoaded", function() {
  // Function to fetch data from the server and populate the table
  function fetchDataAndPopulateTable() {
    fetch('mandjeOphalen.php')
      .then(response => response.json())
      .then(data => {
        // Select the table body
        const tableBody = document.querySelector('table tbody');

        // Clear existing table rows
        tableBody.innerHTML = '';

        // Iterate over the data and create table rows
        data.forEach(row => {
          // Create a new table row
          const newRow = document.createElement('tr');

          // Format Uitleendatum to 'dd/mm/yyyy' format
          const uitleendatumFormatted = formatDate(row.datumBeschikbaar);

          // Determine button classes based on possession
          const buttonClass = row.in_bezit === 1 ? 'reserveren-button' : 'uitlenen-button';

          // Populate the table row with data
          newRow.innerHTML = `
            <td>${row.groep_naam}</td>
            <td>${uitleendatumFormatted}</td>
            <td>${getTerugbrengDatum(row.datumBeschikbaar)}</td>
            <td><button class="melden-button">Melden</button></td>
            <td><button class="${buttonClass}" style="background-color: ${row.in_bezit === 1 ? 'green' : 'red'}; color: white;">${row.in_bezit === 1 ? 'Verlengen' : 'Annuleren'}</button></td>
          `;

          // Append the new row to the table body
          tableBody.appendChild(newRow);
        });
      })
      .catch(error => console.error('Error fetching data:', error));
  }

  // Function to format date as 'dd/mm/yyyy'
  function formatDate(dateString) {
    const datumBeschikbaarDate = new Date(dateString);
    const terugbrengDatumDate = new Date(datumBeschikbaarDate);
    terugbrengDatumDate.setDate(terugbrengDatumDate.getDate()); // Assuming 5 days lending period
    return terugbrengDatumDate.toLocaleDateString('en-NL');
  }

  // Function to calculate the terugbrengdatum (assumed 5 days after datumBeschikbaar)
  function getTerugbrengDatum(datumBeschikbaar) {
    const datumBeschikbaarDate = new Date(datumBeschikbaar);
    const terugbrengDatumDate = new Date(datumBeschikbaarDate);
    terugbrengDatumDate.setDate(terugbrengDatumDate.getDate() + 5); // Assuming 5 days lending period
    return terugbrengDatumDate.toLocaleDateString('en-NL'); // Format the date as per your requirement
  }

  // Call the function to fetch data and populate the table when the page loads
  fetchDataAndPopulateTable();

  // Event delegation for button clicks
  document.querySelector('table').addEventListener('click', function(event) {
    const target = event.target;

    // Check if the clicked element is a button
    if (target.tagName === 'BUTTON') {
      // Handle button clicks based on class name
      if (target.classList.contains('melden-button')) {
        // Handle Melden button click
        alert('Melden button clicked');
      } else if (target.classList.contains('reserveren-button')) {
        // Handle Reserveren button click
        if (target.textContent === 'Annuleren') {
          Swal.fire({
            title: 'Weet je zeker dat je wil annuleren?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, annuleren!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Cancelled!',
                'Je verlenging is geannuleerd.',
                'success'
              );
              // Add any further actions here after cancellation confirmation
              target.textContent = 'Verlengen';
              target.style.backgroundColor = 'green';
            }
          });
        } else {
          target.textContent = 'Annuleren';
          target.style.backgroundColor = 'red';
        }
      } else if (target.classList.contains('uitlenen-button')) {
        // Handle Uitlenen button click
        if (target.textContent === 'Annuleren') {
          Swal.fire({
            title: 'Weet je zeker dat je de reservatie wilt annuleren?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, annuleren!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Cancelled!',
                'Je reservatie is geannuleerd.',
                'success'
              );
              // Add any further actions here after cancellation confirmation
              target.textContent = 'Uitlenen';
              target.style.backgroundColor = 'green';
            }
          });
        } else {
          Swal.fire({
            title: 'Weet je zeker dat je het item wil uitlenen?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, leen het uit!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Uitgeleend!',
                'Het item is uitgeleend.',
                'success'
              );
              // Add any further actions here after lending confirmation
              target.textContent = 'Annuleren';
              target.style.backgroundColor = 'red';
            }
          });
        }
      }
    }
  });
});
