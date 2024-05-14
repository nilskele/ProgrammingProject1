<link rel="stylesheet" href="/ProgrammingProject1/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/styles.css" />
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.css">
<link rel="stylesheet" href="/ProgrammingProject1/css/admin.kalender.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!-- Include your custom JavaScript file -->
<script src="/ProgrammingProject1/php/admin/inAndOut/js/inandout.js"></script>

<?php 
include("admin.header.php");
include('../../database.php');
?>
<div id="overlay" class="overlay"></div>

<!-- Popup -->
<div id="popup" class="popup"></div>


<div id="adminDashboard">
  <div id="container1">
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Product Nr.</h1>
        <input type="text" class="form-control grey-input" id="productNrInput" placeholder="product nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtn" class="accepterenBtn">
          accepteren
        </a>
        <a class="defectBtn" id="defectBtn">
          defect
        </a>
        <a href="reserveren/reserveren.php">
          <button class="reserverenBtn" id="reserverenButtonProduct">
            reserveren
          </button>
        </a>
      </div>
    </div>
    <div class="adminAccepteren">
      <div class="productNr">
        <h1>Kit Nr.</h1>
        <input type="text" class="form-control" id="inputName3" placeholder="kit nr" />
      </div>
      <div class="knoppen">
        <a id="acceptBtn" class="accepterenBtn">
          accepteren
        </a>
        <a href="inAndOut/defectProduct.php" class="defectBtnAccepteren">
          defect
        </a>
        <a class="reserverenBtn">
          reserveren
        </a>
      </div>
    </div>
  </div>
</div>
<div id="smallInOutDiv">
  <div id="title-kalender-In-Out">
    <h1>In and Out</h1>
    <input type="text" name="selectedDate" id="selectedDate" readonly />
  </div>
  <div class="inOutTitels">
    <h1>Vandaag Geleend</h1>
    <h1>Vandaag Terug</h1>
  </div>
  <div class="inOutTitels">
  <input type="text" id="zoekbalka" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk3">

  <input type="text" id="zoekbalkb" name="zoekbalk" placeholder="Zoek naar studenten" class="inputZoekbalk4">

  </div>

  <div class="inoutdiv">
    <div id="smallInOut1" class="productContainer overflow-auto">

    </div>
    <div id="smallInOut2" class="productContainer overflow-auto "></div>
  </div>
</div>

<script src="/ProgrammingProject1/php/admin/inAndOut/js/inandout.js"></script>

</div>
<div class="toTopAnker">
  <button onclick="topFunction()" id="topBtn">Top &#8593;</button>
</div>
<script src="/ProgrammingProject1/php/admin/inAndOut/js/inandout.js"></script>
<script src="/ProgrammingProject1/js/admin.index.js"></script>

    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div class="buttons_kalender">
    <form action="/zoeken" method="GET">
      <input type="text" name="Zoeken" placeholder="Zoeken...">
    </form>
    <div class="buttons-container">
      <a href="/ProgrammingProject1/php/admin/kitToevoegen/kit_toevoegen.php"><button>Kit toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/productToevoegen/product_toevoegen.php"><button>Product toevoegen</button></a>
      <a href="/ProgrammingProject1/php/admin/categoryWijzigen/category_wijzigen.php"><button>Categorie wijzigen</button></a>
    </div>
  </div>
  <h1 class="titel">Calendar</h1>
  <div class="calendar">
    <header>
      <h3></h3>
      <nav>
        <button id="prev"></button>
        <button id="next"></button>
      </nav>
    </header>
    <section>
      <ul class="days">
        <li>Items <span class="date"></span></li>
        <li>Zo <span class="date"></span></li>
        <li>Ma <span class="date"></span></li>
        <li>Di <span class="date"></span></li>
        <li>Wo <span class="date"></span></li>
        <li>Do <span class="date"></span></li>
        <li>Vr <span class="date"></span></li>
        <li class="new-row"><span class="date"></span></li> 
      </ul>
      <ul class="dates"></ul>
    </section>
  </div>
</body>
<script src="../../js/admin.agenda.js"></script>
<?php 

// SQL-query
$sql = "SELECT ML.Uitleendatum, ML.terugbrengDatum, G.naam AS product_naam
        FROM MIJN_LENINGEN ML
        JOIN PRODUCT P ON ML.product_id_fk = P.product_id
        JOIN GROEP G ON P.groep_id = G.groep_id
        WHERE G.naam = 'CANON M50'";

// Voer de query uit
$result = $conn->query($sql);

// Array om de resultaten op te slaan
$loanDetails = array();

// Controleer of er resultaten zijn
if ($result->num_rows > 0) {
    // Output gegevens van elke rij
    while($row = $result->fetch_assoc()) {
        // Sla de resultaten op in een array
        $loanDetails[] = array(
          //  "product_naam" => $row["product_naam"],
          //  "Uitleendatum" => $row["Uitleendatum"],
           // "terugbrengDatum" => $row["terugbrengDatum"]
        );
    }
} else {
    echo "Geen resultaten gevonden";
}

// Sluit de verbinding
$conn->close();

// Output the array contents
echo "<pre>";
//print_r($loanDetails);
echo "</pre>";

// Convert loanDetails to JSON
$loanDetailsJSON = json_encode($loanDetails);


?>
<script>

</script>
<script src="../../js/admin.agenda.js"></script>
<script>
// Pass PHP array to JavaScript
const loanDetails = <?php echo $loanDetailsJSON; ?>;

var data = <?php echo json_encode($loanDetails); ?>;
   // alert(JSON.stringify(data))



</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const header = document.querySelector(".calendar h3");
const dates = document.querySelector(".dates");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");


// Extract product name, Uitleendatum, and terugbrengDatum
const productNames = data.map(item => item.product_naam);
const uitleendatums = data.map(item => item.Uitleendatum);
const terugbrengDatums = data.map(item => item.terugbrengDatum);

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
//console.log("Product Details:");
data.forEach(item => {
   // console.log(`Product: ${productNames[index]}`);
    //console.log(`Uitleendatum: ${uitleendatums[index]}`);
    //console.log(`TerugbrengDatum: ${terugbrengDatums[index]}`);
    index++;
    //console.log("Index:" + index); // Empty line for separation

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

// Updated items array with placeholders for each day
const items = [
  "CANON 5/5", // Item for 5/5
  "booked", // Placeholder for 6/5
  "booked", // Placeholder for 7/5
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

    
    
    // Log the updated dagenWeek
    console.log("dagen:" + dagenWeek);

    // Update the HTML of the dates
    let html = "";
    for (let indexLength = 0; indexLength < productNames.length; indexLength++) {
        let maxAantallen = 8;
        for (let index = 0; index < maxAantallen; index++) {
            const datesBetween = getDatesBetween(uitleendatums[indexLength], terugbrengDatums[indexLength]);
            if (index === 0) {
                html += `<li class="inactive">${productNames[indexLength]}</li>`;
            } else if (datesBetween.some(r => dagenWeek[index - 1].includes(r))) {
                html += `<li class="inactive">${"Booked"}</li>`;
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
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
