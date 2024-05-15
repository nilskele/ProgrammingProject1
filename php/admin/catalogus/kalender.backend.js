// script.js
document.addEventListener("DOMContentLoaded", function() {
    // Extract product name, Uitleendatum, and terugbrengDatum
    const productNames = loanDetailsJSON.map(item => item.product_naam);
    const uitleendatums = loanDetailsJSON.map(item => item.Uitleendatum);
    const terugbrengDatums = loanDetailsJSON.map(item => item.terugbrengDatum);
    const productID = loanDetailsJSON.map(item => item.product_id);

    console.log(productNames);

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

    // Print product names along with Uitleendatum and terugbrengDatum
    let index = 0;
    productNames.forEach(item => {
        console.log(`Product: ${productNames[index]}`);
        console.log(`Uitleendatum: ${uitleendatums[index]}`);
        console.log(`TerugbrengDatum: ${terugbrengDatums[index]}`);
        index++;
    });

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

        // Update the HTML of the dates
        let html = "";
        for (let indexLength = 0; indexLength < productNames.length; indexLength++) {
            let maxAantallen = 8;
            for (let index = 0; index < maxAantallen; index++) {
                const datesBetween = getDatesBetween(uitleendatums[indexLength], terugbrengDatums[indexLength]);
                if (index === 0) {
                    html += `<li class="inactive">
                    <div class="items" style="font-size:18px">
                    ${productNames[indexLength] + ", " + productID[indexLength]}
                    </div>
                    <div class="buttons_item">
                        <button class="reserveren">Reserveren</button> </br>

                        <button class="glyphicon glyphicon-eye-open" style="font-size:15px"></button> 
                        <button class="fa fa-trash-o" style="font-size:15px"></button>
                        <button class="fa fa-pencil" style="font-size:15px"></button>
                    </div>
                    </li>`;
                } else if (datesBetween.some(r => dagenWeek[index - 1].includes(r))) {
                    html += `<li class="inactive">${"Uitgeleend"}</li>`;
                } else {
                    html += `<li class="inactive">${"/"}</li>`;
                }
            }
        }

        // Update the HTML of the dates
        dates.innerHTML = html;
    }

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
    });
    
    // Delete item button
    document.addEventListener('DOMContentLoaded', function() {
        // Get all delete buttons
        const deleteButtons = document.querySelectorAll('.fa-trash-o');
    
        // Add event listener to each delete button
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Show the SweetAlert popup
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
                    // If the user confirms deletion
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Verwijderd!',
                            'Het item is verwijderd',
                            'success'
                        );
                        // Optionally, you can add the logic to delete the item here
                    } else {
                        // If the user cancels deletion
                        Swal.fire(
                            'Cancelled',
                            'Het item is niet verwijderd.',
                            'error'
                        );
                    }
                });
            });
        });
    });
    
    // Reservation button
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
    
        // Loop through each "edit" button and attach event listener
        editBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                // Redirect to edit product page
                window.location.href = "/ProgrammingProject1/php/admin/productToevoegen/product_wijzigen.php";
            });
        });
    });
    
