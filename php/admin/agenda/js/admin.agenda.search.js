// Function for the toggle switch
function updateSearchType() {
    var searchToggle = document.getElementById('searchToggle');
    var searchType = document.getElementById('searchType');
    var labelID = document.getElementById('labelID');
    var labelNaam = document.getElementById('labelNaam');

    if (searchToggle.checked) {
        searchType.value = 'naam';
        labelID.classList.remove('active');
        labelNaam.classList.add('active');
    } else {
        searchType.value = 'id';
        labelID.classList.add('active');
        labelNaam.classList.remove('active');
    }

    // Save the state to localStorage
    localStorage.setItem('searchToggleState', searchToggle.checked);
}

function loadSearchType() {
    var searchToggle = document.getElementById('searchToggle');
    var searchType = document.getElementById('searchType');
    var labelID = document.getElementById('labelID');
    var labelNaam = document.getElementById('labelNaam');

    // Get the state from localStorage
    var toggleState = localStorage.getItem('searchToggleState') === 'true';

    // Set the state of the checkbox
    searchToggle.checked = toggleState;

    // Set the searchType and labels based on the state
    if (toggleState) {
        searchType.value = 'naam';
        labelID.classList.remove('active');
        labelNaam.classList.add('active');
    } else {
        searchType.value = 'id';
        labelID.classList.add('active');
        labelNaam.classList.remove('active');
    }
}

// Initialize the toggle labels and state on page load
document.addEventListener("DOMContentLoaded", function() {
    loadSearchType();
});

function scrollToResults() {
    // Scroll to the results section after form submission
    setTimeout(function() {
        document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
    }, 100); // Slight delay to ensure results are rendered
}

// Check if search was performed and scroll to results
window.addEventListener('DOMContentLoaded', (event) => {
    if (new URLSearchParams(window.location.search).has('Zoeken')) {
        scrollToResults();
    }
});
