$(function() {

    //ON WINDOW LOAD 
    window.onload = function() {
        var today = moment().format('YYYY-MM-DD');
        fetchDataUitleendatum(today);
        fetchDataTerugbrengDatum(today);
    };
    // IN AND OUT 
    function fetchDataUitleendatum(selectedDate) {
        // Clear existing data
        $('#smallInOut1').empty();
        $('#InOut1').empty();
        
        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '/ProgrammingProject1/php/admin/inAndOut/inAndOutBackend.php',
            method: 'POST',
            data: { selectedDate: selectedDate, type: 'uitleendatum' },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
    
                // Separate data based on source
                var query1Data = data.filter(item => item.source === 'query1');
                var query3Data = data.filter(item => item.source === 'query3');
    
                console.log('checkcheck');
                
                // Process query1Data
                query1Data.forEach(function(item1) {
                    // Check if there is a matching item in query3Data
                    var matchInQuery3 = query3Data.find(item3 => item3.product_id === item1.product_id);
    
                    // Create a new card element
                    var card = document.createElement('div');
                    card.className = 'inOutProduct';
                    card.setAttribute('data-lening-id', item1.lening_id);
                    card.setAttribute('data-terugbrengdatum', item1.terugbrengDatum);
                    card.setAttribute('data-uitleendatum', item1.Uitleendatum);
                    card.setAttribute('data-watdefect', item1.watDefect);
                    card.setAttribute('data-redendefect', item1.redenDefect);
                    card.setAttribute('data-image', item1.image_data);
                    
                    // Create the product info div
                    var productInfo = document.createElement('div');
                    productInfo.className = 'productInfo';
    
                    // Populate the product info
                    productInfo.innerHTML = `
                        <div id="intButtons2">
                            <a class="outBtn" href="">Out</a>
                        </div>
                        <div class="info">
                            <h3 class="Naam">${item1.voornaam} ${item1.achternaam}</h3>
                            <p class="accepterenProductID"  value="${item1.naam} ${item1.product_id}">${item1.naam}, ${item1.product_id}</p>
                        </div>
                    
                            <svg class="erroricon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#FFD43B" d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>                        <div class="moreinfo" onclick="openPopup()">
                            
                            <img class="dots"  src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                        </div>
                    `;
    
                    // If there is a match in query3, do something different
                    card.appendChild(productInfo);

                // If there is a match in query3, hide the erroricon
                if (matchInQuery3) {
                    console.log("Match found, hiding error icon for product_id:", item1.product_id);
                    var errorIcon = card.querySelector('.erroricon');
                    if (errorIcon) {
                        console.log("Error icon found, hiding it.");
                        errorIcon.style.display = 'none';
                    } else {
                        console.log("Error icon not found.");
                    }
                }
                    
    
                    // Append the card to the appropriate container
                    try {
                        document.getElementById('smallInOut1').appendChild(card);
                    } catch (error) {
                        document.getElementById('InOut1').appendChild(card);
                        console.error("An error occurred:", error);
                    }
                });
    
                // Process query2Data similarly if needed...
                // You can add specific processing logic for query2Data here
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    

    // Function to fetch and display data for terugbrengDatum
    function fetchDataTerugbrengDatum(selectedDate) {
        // Clear existing data
        $('#smallInOut2').empty();
        $('#InOut2').empty();

        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '/ProgrammingProject1/php/admin/inAndOut/inAndOutBackend.php',
            method: 'POST',
            data: { selectedDate: selectedDate, type: 'terugbrengDatum' },
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Loop through the data and create HTML elements
                data.forEach(function(item) {
                    // Check if the date matches the selected date
                    if (item.terugbrengDatum === selectedDate) {
                        // Create a new card element
                        var card = document.createElement('div');
                        card.className = 'inOutProduct';
                        card.setAttribute('data-lening-id', item.lening_id); // Set data-lening-id attribute
                        card.setAttribute('data-terugbrengdatum', item.terugbrengDatum); // Set data-lening-id attribute
                        card.setAttribute('data-uitleendatum', item.Uitleendatum); // Set data-lening-id attribute
                        card.setAttribute('data-watdefect', item.watDefect); // Set data-lening-id attribute
                        card.setAttribute('data-redendefect', item.redenDefect); // Set data-lening-id attribute
                        card.setAttribute('data-image', item.image_data);

                        



                        



                        // Create the product info div
                        var productInfo = document.createElement('div');
                        productInfo.className = 'productInfo';

                        // Populate the product info
                        productInfo.innerHTML = `
                            <div id="vandaagInButtons">
                                <a class="accepterenBtn" href="">Accepteren</a>
                                <a class="defectBtn defectButton" id="defectBtn90">Defect</a>
                            </div>
                            <div class="info">
                                <p id="accepterenProductID" style="display: none;" value="${item.product_id}"></p>
                                <p id="emailDefect" style="display: none;" value="${item.email}"></p>
                                <h5 class="Naam" value="${item.voornaam} ${item.achternaam}">${item.voornaam} ${item.achternaam}</h5>
                                <p class="accepterenProductID"  value="${item.naam} ${item.product_id}">${item.naam}, ${item.product_id}</p>
                            </div>
                            <div class="moreinfo" onclick="openPopup()">
                                <img class="dots"  src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                            </div>
                        `;

                        // Append product info to card
                        card.appendChild(productInfo);

                        // Append the card to the appropriate container
                        
                        
                        try {
                            document.getElementById('smallInOut2').appendChild(card);
                        } catch (error) {
                          document.getElementById('InOut2').appendChild(card);
                          console.error("An error occurred:", error);
                        }
  
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    

    // Initialize date picker
    $('input[name="selectedDate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: moment().year(), // Set minimum year to the current year
        maxYear: moment().year(), // Set maximum year to the current year
        minDate: moment(), // Set minimum date to today
        isInvalidDate: function(date) {
            // Disable Saturdays (day 6) and Sundays (day 0)
            return date.day() === 6 || date.day() === 0 || date.isBefore(moment(), 'day');
        }
    }, function(start, end, label) {
        var selectedDate = start.format('YYYY-MM-DD');
        console.log("checkcheck")

        // Call fetchDataUitleendatum function with the selected date
        fetchDataUitleendatum(selectedDate);

        // Call fetchDataTerugbrengDatum function with the selected date
        fetchDataTerugbrengDatum(selectedDate);
        
        
    });

    

    $(document).off('click', '#defectBtn90').on('click', '#defectBtn90', function(event) {
        event.preventDefault();
        let productnr = $(this).closest('.inOutProduct').find('#accepterenProductID').attr('value');
        let email = $(this).closest('.inOutProduct').find('#emailDefect').attr('value');
    
        if (productnr) {
            localStorage.setItem("productNr", productnr);
            localStorage.setItem("email", email);
        } else {
            console.log("No numerical value found.");
        }
        window.location.href = "/ProgrammingProject1/php/admin/inAndOut/defectProduct.php";
    });
    
    
    

    // Event listener for accepting an item
    $(document).on('click', '.accepterenBtn', function(e) {
        e.preventDefault();

        var $this = $(this);

        var leningId = $this.closest('.inOutProduct').data('lening-id');
        var productNr = $this.closest('.inOutProduct').find('.accepterenProductID').attr('value');
        var productNr = $this.closest('.inOutProduct').find('.accepterenProductID').attr('value');

        // Send AJAX request to delete the row from the database
        Swal.fire({
            title: 'Weet u zeker dat u dit wilt doen?',
            text: "Dit product zal worden geaccepteerd.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/ProgrammingProject1/php/productAccepteren.php',
                    method: 'POST',
                    data: { leningId: leningId, productNr: productNr},
                    success: function(response) {
                        
                        // Upon successful deletion, remove the corresponding row from the HTML
                        if (response === 'success') {
                            $this.closest('.inOutProduct').remove();
                            
                            
                        } else {
                            console.error('Failed to delete row');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
        
        
    });

    // Event listener for marking an item as returned
    $(document).on('click', '.outBtn', function(e) {
        e.preventDefault();

        // Store the context of 'this' in a variable
        var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
        var leningId = $this.closest('.inOutProduct').data('lening-id');

        // Send AJAX request to update the terugbrengDatum to NULL in the database
        $.ajax({
            url: '/ProgrammingProject1/php/update_uitleendatum.php',
            method: 'POST',
            data: { leningId: leningId },
            success: function(response) {
                // Upon successful update, hide the row from the page
                if (response === 'success') {
                    $this.closest('.inOutProduct').hide();
                } else {
                    console.error('Failed to update terugbrengDatum');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('.inputZoekbalk1').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#InOut1 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('.inputZoekbalk3').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#smallInOut1 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('.inputZoekbalk4').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#smallInOut2 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('.inputZoekbalk2').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#InOut2 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    let acceptBtn= document.getElementById("acceptBtn");
    let productNrInput = document.getElementById("productNrInput");


acceptBtn.addEventListener("click", function () {
        let productNr = productNrInput.value;
        var $this = $(this);
        
        if (productNr === "") {
                Swal.fire({
                        icon: "error",
                        title: "Oeps...",
                        text: "Het productnummer mag niet leeg zijn!"
                });
        } else {
                $.ajax({
                        url: "/ProgrammingProject1/php/checkProductNr.php",
                        method: "POST",
                        data: {
                                productNr: productNr
                        },
                        success: function (data) {
                                if (data === "true") {
                                        Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You are about to perform an action. Do you want to proceed?",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, proceed!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '/ProgrammingProject1/php/productAccepterenMetProductnr.php',
                                                        method: 'POST',
                                                        data: { productNr: productNr },
                                                        success: function(responsee) {
                                                                if (responsee === 'success') {
                                                                    console.log("success");
                                                                    $this.closest('.inOutProduct').remove();

                                                                } else {
                                                                    console.error('Failed to delete row');
                                                                }
                                                            },
                                                        error: function(xhr, status, error) {
                                                            console.error(error);
                                                        }
                                                    });
                                                }
                                            });
                                } else {
                                        Swal.fire({
                                                icon: "error",
                                                title: "Oeps...",
                                                text: "Het productnummer bestaat niet!"
                                        });
                                }
                        }
                });
        }    
});
function openPopup() {
    
    var overlay = document.getElementById("overlay");
    overlay.style.display = "block";
    var popup = document.getElementById("popup");
    var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
    var leningId = $this.closest('.inOutProduct').data('lening-id');
    var naam = $this.closest('.inOutProduct').find('.Naam').attr('value');
    var productNr = $this.closest('.inOutProduct').find('.accepterenProductID').attr('value');
    var terugbrengdatum = $this.closest('.inOutProduct').data('terugbrengdatum');
    var uitleendatum = $this.closest('.inOutProduct').data('uitleendatum');
    var watdefect = $this.closest('.inOutProduct').attr('data-watdefect');
    var redendefect = $this.closest('.inOutProduct').attr('data-redendefect');
    var image = $this.closest('.inOutProduct').attr('data-image');





    

  
    // Construct the popup content with the retrieved data
    popup.innerHTML = `
      <div class="popup-content">
        <span class="closePopup" onclick="closePopup()">&times;</span>
        <div class="popup_info">
            <div class="contents">
            <img class="statusImage" src="data:image/jpeg;base64,${image}">

                <h5 class="Naam">${naam}</h5>
                <p class="accepterenProductID">Product: ${productNr}</p>
                <p>Lening ID: ${leningId}</p>
            </div>
          <div>
            <div class="dates">
                <h6 class="aantalDagenTelaat">Uitleendatum: ${uitleendatum}</h6>
                
                <h6 class="aantalDagenTelaat">Terugbrengdatum: ${terugbrengdatum}</h6>
            
            </div>
            <div class="dates">
                
                <p>Wat is er defect: ${watdefect}</p>
                
                <p>Hoe is het defect ontstaan: ${redendefect}</p>
            </div>
          </div>
            
          
        </div>
        
      </div>
    `;
  
    
    popup.style.display = "block";
  }
  $(document).on('click', '.moreinfo', openPopup);

  
  function closePopup() {
    var overlay = document.getElementById("overlay");
    overlay.style.display = "none";
    
    var popup = document.getElementById("popup");
    popup.style.display = "none";
    popup.innerHTML = ""; // Clear popup content
  }
  $(document).on('click', '.closePopup', closePopup);

    
});

