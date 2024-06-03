const header = document.querySelector(".calendar h3");
const dates = document.querySelector(".dates");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");


// Extract product name, Uitleendatum, and terugbrengDatum
function extractDetails(loanDetails) {
    const productNames = loanDetails.map(item => item.product_name);
    const uitleendatums = loanDetails.map(item => item.Uitleendatum);
    const terugbrengDatums = loanDetails.map(item => item.terugbrengDatum);
    const productID = loanDetails.map(item => item.product_id);
    const zichtbaar = loanDetails.map(item => item.zichtbaar);
    const soort = loanDetails.map(item => item.soort);
    const kit_id = loanDetails.map(item => item.kit_id); 
    const lening_id = loanDetails.map(item => item.lening_id);
    return { productNames, uitleendatums, terugbrengDatums, productID, zichtbaar, soort, kit_id, lening_id };
}

// Capture the returned object
const details = extractDetails(loanDetails);
const { productNames, uitleendatums, terugbrengDatums, productID, zichtbaar, soort, kit_id, lening_id} = details;

// Function to format date to day/month format
function formatDate(dateString) {
  const date = new Date(dateString);
  const day = date.getDate(); 
  const month = date.getMonth() + 1; // January is 0, so add 1 to get the correct month number
  return `${day}-${month}`;
}

// Function to get dates between two dates
function getDatesBetween(uitleendatum, terugbrengDatum) {
  const dates = [];
  let currentDate = new Date(uitleendatum);
  const endDate = new Date(terugbrengDatum);
  
  while (currentDate <= endDate) {
    const day = currentDate.getDate();
    const month = currentDate.getMonth() + 1;
    dates.push(`${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}`);
    currentDate.setDate(currentDate.getDate() + 1); // Move to the next day
  }

  return dates;
}



const months = [
  "Januari",
  "Februari",
  "Maart",
  "April",
  "Mei",
  "Juni",
  "Juli",
  "Augustus",
  "September",
  "October",
  "November",
  "December"
];

const daysOfWeek = [
  "Items",
  "Zo",
  "Ma",
  "Di",
  "Wo",
  "Do",
  "Vr",
  "Za"
];

const daysList = document.querySelector(".days");

const daysHtml = daysOfWeek.map((day, index) => {
  return `<li>${day} <span class="date"></span></li>`;
}).join("");

daysList.innerHTML = daysHtml;

const dateSpans = daysList.querySelectorAll(".date");

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let dagenWeek = []; // Initialize an empty array to hold the days
dagenWeek[0] = "";
// Render the current week
// Render the current week
function renderCalendar() {
    const startDate = getStartDate(currentDate);
    const weekDates = getWeekDates(startDate);

    // Clear the dagenWeek array
    dagenWeek = [];

    // Iterate through each day in the week
    weekDates.forEach((date, index) => {
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const formattedDay = day < 10 ? '0' + day : day; // Add leading zero if day is less than 10
        const formattedMonth = month < 10 ? '0' + month : month; // Add leading zero if month is less than 10
        const dateKey = `${formattedDay}-${formattedMonth}`; // Format day-month

        const classNames = getDayClassNames(date);
        dateSpans[index + 1].textContent = `${day}/${date.getMonth() + 1}`; // Index + 1 to match the index in the HTML
        dateSpans[index + 1].parentNode.classList = classNames; // Setting class for the parent li

        // Populate dagenWeek array
        dagenWeek.push(dateKey);
    });

    header.textContent = `${months[currentMonth]} ${currentYear}`;


let html = "";
for (let indexLength = 0; indexLength < productNames.length; indexLength++) {
    let maxAantallen = 8;
    for (let index = 0; index < maxAantallen; index++) {
        const isKit = soort[indexLength] === 'kit'; // Use indexLength here
        const itemId = isKit ? kit_id[indexLength] : productID[indexLength]; // Use indexLength here
        const datesBetween = getDatesBetween(uitleendatums[indexLength], terugbrengDatums[indexLength]);
        if (index === 0) {
            //zichtbaar[indexLength] = 1;
            let visibilityButton;
            if (zichtbaar[indexLength] == 1) {
                visibilityButton = `<button class="fa fa-eye" style="font-size:15px" data-item-id="${itemId}" data-index="${indexLength}" data-soort="${soort[indexLength]}"></button>`;
            } else {
                visibilityButton = `<button class="fa fa-eye-slash" style="font-size:15px" data-item-id="${itemId}" data-index="${indexLength}" data-soort="${soort[indexLength]}"></button>`;
            }
            
            html += `<li class="inactive">
                <div class="items" style="font-size:18px">
                ${productNames[indexLength] + ", " + productID[indexLength]}
                </div>
                <div class="buttons_item">
                    <button class="reserveren" href="/reserveren/reserveren.php">Reserveren</button> </br>
                    ${visibilityButton}
                    <button class="fa fa-trash-o" style="font-size:15px" data-item-id="${itemId}" data-index="${indexLength}" data-soort="${soort[indexLength]}"></button>
                    <button class="fa fa-pencil" style="font-size:15px" data-product-id="${itemId}"></button>       
                </div>
            </li>`;
        } else if (currentYear != new Date(uitleendatums[indexLength]).getFullYear() &&
            currentYear != new Date(terugbrengDatums[indexLength]).getFullYear()) {
            html += `<li class="inactive">${"/"}</li>`;
        } else if (datesBetween.some(r => dagenWeek[index - 1].includes(r))) {
            html += `<li class="inactive">
                <button class="inactive calendar-button" 
                    data-lening-id="${lening_id[indexLength]}" data-item-id="${itemId}"
                >Uitgeleend</button>
            </li>`;

        } else {
            html += `<li class="inactive">${"/"}</li>`;
        }
    }
}


dates.innerHTML = html;
}
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('calendar-button')) {
        const lening_id = event.target.getAttribute('data-lening-id');
        const itemId = event.target.getAttribute('data-item-id');
        console.log('lening ID:', lening_id , "Item ID: " + itemId);

        Swal.fire({
            title: "Bent u zeker?",
            text: "Wilt u deze reservatie annuleren?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, annuleer de reservatie',
            cancelButtonText: 'Nee, annuleer de reservatie niet'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/ProgrammingProject1/sendAnullering.php',
                    type: 'POST',
                    data: {
                        lening_id: lening_id,
                        itemId: itemId,
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

                fetch('/ProgrammingProject1/php/admin/agenda/php/update_visibility.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lening_id: lening_id,
                        itemId: itemId,
                        action: "annuleer",
                    }),
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);
                    if (data.error) {
                        Swal.fire(
                            'Error5',
                            data.error,
                            'error'
                        );
                    } else if (data.success) {
                        Swal.fire(
                            'Geannuleerd',
                            'De reservatie is geannuleerd',
                            'success'
                        ).then(() => {
                           // window.location.reload();
                        });
                    } else {
                        throw new Error('Unexpected response format');
                    }
                })
                .catch(error => {
                    //JSON probleem voor nu uitgezet.
                     console.error('Fetch error:', error);
                     Swal.fire(
                        'Error',
                        'Failed to annuleer reservatie: ' + error.message,
                        'error'
                   );
                   //window.location.reload();
                });
            } else {
                console.log('Cancelled');
                Swal.fire(
                    'Cancelled',
                    'De reservatie is niet geannuleerd',
                    'error'
                );

            }
        });
    }
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fa-eye') || event.target.classList.contains('fa-eye-slash')) {
        const itemId = event.target.getAttribute('data-item-id');
        const indexLength = event.target.getAttribute('data-index');
        const soort = event.target.getAttribute('data-soort');
        
        Swal.fire({
            title: "Bent u zeker?",
            text: zichtbaar[indexLength] == 1 ? "Wilt u dit item onzichtbaar maken, u zal deze wel nog zien in de catalogus!" : "Wilt u dit item zichtbaar maken?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: zichtbaar[indexLength] == 1 ? 'Ja, maak het item onzichtbaar!' : 'Ja, maak het item zichtbaar!',
            cancelButtonText: 'Nee, maak het item niet zichtbaar!'
        }).then((result) => {
            if (result.isConfirmed) {
                const newVisibility = zichtbaar[indexLength] == 1 ? 0 : 1; // Toggle visibility

                fetch('/ProgrammingProject1/php/admin/agenda/php/update_visibility.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        itemId: itemId,
                        visibility: newVisibility,
                        soort: soort,
                        action: "zichtbaar",
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    
                    zichtbaar[indexLength] = data.visibility; // Update visibility in the array
                    Swal.fire(
                        data.visibility == 1 ? 'Zichtbaar!' : 'Onzichtbaar!',
                        `Het item is ${data.visibility == 1 ? 'zichtbaar' : 'onzichtbaar'} gezet`,
                        'success'
                    ).then(() => {
                        window.location.reload(); // Reload the page after the success message
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    Swal.fire(
                        'Error',
                        'Failed to update item visibility: ' + error.message,
                        'error'
                    );
                });
            } else {
                Swal.fire(
                    'Cancelled',
                    `Het item is niet ${zichtbaar[indexLength] == 1 ? 'onzichtbaar' : 'zichtbaar'} gezet.`,
                    'error'
                );
            }
        });
    }
});


document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fa-trash-o')) {
        const button = event.target;
        const itemId = button.getAttribute('data-item-id');
        const soort = button.getAttribute('data-soort');

        Swal.fire({
            title: "Bent u zeker?",
            text: "Eens het item is verwijderd kan je hem niet terugkrijgen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ja, verwijder het item!',
            cancelButtonText: 'Nee, niet verwijderen!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('http://127.0.0.1/ProgrammingProject1/php/admin/agenda/php/update_visibility.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        itemId: itemId,
                        soort: soort,
                        action: 'delete'
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Verwijderd!',
                            'Het item is verwijderd',
                            'success'
                        );
                        button.closest('li').remove();
                        window.location.reload();
                    } else {
                        throw new Error(data.error || 'Unknown error');
                    }
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    Swal.fire(
                        'Error',
                        'Failed to delete item: ' + error.message,
                        'error'
                    );
                });
            } else {
                Swal.fire(
                    'Cancelled',
                    'Het item is niet verwijderd.',
                    'error'
                );
            }
        });
    }
});




function handleReserverenClick() {
   
    window.location.href = "/ProgrammingProject1/php/admin/reserveren/reserveren.php";
}

//function redirect naar aanpassen
function handleEditClick(productId) {
    window.location.href = `/ProgrammingProject1/php/admin/productWijzigen/productWijzigen.php?product_id=${productId}`;
}


document.addEventListener('click', function(event) {
    const itemId = event.target.getAttribute('data-item-id');
    //reserveren
    if (event.target.classList.contains('reserveren')) {
        handleReserverenClick();
    }

    //aanpassen
    if (event.target.classList.contains('fa-pencil')) {
        const productId = event.target.getAttribute('data-product-id');
        handleEditClick(productId);
    }
});



document.addEventListener("DOMContentLoaded", function() {
    // Select all elements with class "reserveren" and "fa-pencil"
    var reserverenBtns = document.querySelectorAll(".reserveren");
    var editBtns = document.querySelectorAll(".fa-pencil");

    // Loop through each "reserveren" button and attach event listener
    reserverenBtns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            // Redirect to reservation page
            window.location.href = "/ProgrammingProject1/php/admin/reserveren/reserveren.php";
        });
    });

    // Attach event listener for edit buttons
    editBtns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            // Get the product ID from the data attribute
            const productId = btn.getAttribute('data-product-id');
            // Redirect to edit product page with the product ID as a query parameter
            window.location.href = `/ProgrammingProject1/php/admin/productWijzigen/productWijzigen.php?product_id=${productId}`;
        });
    });
});


// Get the start date of the week
function getStartDate(date) {
  const copyDate = new Date(date);
  copyDate.setDate(copyDate.getDate() - copyDate.getDay()); // Move to the first day of the week
  return copyDate;
}

// Get an array of dates for the current week
function getWeekDates(startDate) {
  const weekDates = [];
  for (let i = 0; i < 7; i++) {
    const date = new Date(startDate);
    date.setDate(startDate.getDate() + i);
    weekDates.push(date);
  }
  return weekDates;
}

// Get class names for a day based on current month and whether it's today or inactive
function getDayClassNames(date) {
  const isCurrentMonth = date.getMonth() === currentMonth;
  const isToday = isCurrentMonth && date.getDate() === currentDate.getDate();
  if (!isCurrentMonth) {
    return "inactive";
  } else if (isToday) {
    return "today";
  } else {
    return "";
  }
}

// Event listeners for navigation buttons
prevButton.addEventListener("click", () => {
  currentDate.setDate(currentDate.getDate() - 7);
  if (currentDate.getMonth() !== currentMonth) {
    currentMonth = currentDate.getMonth();
    currentYear = currentDate.getFullYear();
  }
  renderCalendar();
});

nextButton.addEventListener("click", () => {
  currentDate.setDate(currentDate.getDate() + 7);
  if (currentDate.getMonth() !== currentMonth) {
    currentMonth = currentDate.getMonth();
    currentYear = currentDate.getFullYear();
  }
  renderCalendar();
});

// Initial rendering
renderCalendar();

src="https://cdn.jsdelivr.net/npm/sweetalert2@11"


  