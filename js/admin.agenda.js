const header = document.querySelector(".calendar h3");
const dates = document.querySelector(".dates");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

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

// Updated items array with placeholders for each day
const items = [
  "CANON 5/5",   // Item for 5/5
  "booked",             // Placeholder for 6/5
  "booked",             // Placeholder for 7/5
  "booked",
  "",
  "",
  "",
  "",             
  "MSI 5/5",     
  "",             
  "",             
  "",             
  "",            
  "",             
  ""              
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


// Render the current week
// Render the current week
function renderCalendar() {
  const startDate = getStartDate(currentDate);
  const weekDates = getWeekDates(startDate);

  let html = "";

  // Iterate through each day in the week
  weekDates.forEach((date, index) => {
    const day = date.getDate();
    const classNames = getDayClassNames(date);
    dateSpans[index + 1].textContent = `${day}/${date.getMonth() + 1}`; // Index + 1 to match the index in the HTML
    dateSpans[index + 1].parentNode.classList = classNames; // Setting class for the parent li

    header.textContent = `${months[currentMonth]} ${currentYear}`;


  });

  for (let index = 0; index < items.length; index++) {

    html += `<li class="inactive">${items[index]}</li>`; // Index is used to match with the items
    console.log(html + "/" + index);
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
