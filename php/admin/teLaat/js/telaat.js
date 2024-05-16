$(function() {
    
    // IN AND OUT
    function teLaatTerugGebracht() {
        // Clear existing data
        
        $('#InOut3').empty();
    
        // Send the selected date to a PHP script using AJAX
        $.ajax({
            url: '../teLaat/teLaatIngebracht.backend.php', 
            method: 'POST',
            
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
                
    
                // Loop through the data and create HTML elements
                data.forEach(function(item) {
                    // Check if the date matches the selected date
                    
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
                                <a class="defectBtn defectButton" id="defectBtn90" href="">Defect</a>
                            </div>
                            <div class="info">
                                <h5 class="Naam" value="${item.voornaam} ${item.achternaam}">${item.voornaam} ${item.achternaam}</h5>
                                <p class="userId" value="${item.user_id_fk}">User ID: ${item.user_id_fk}</p>
                                <p class="accepterenProductID" value="${item.product_id}">Product ID: ${item.product_id}</p>
                            </div>
                            <div class="aantalDagenTelaat2">
                            <p class="aantalDagenTelaat" value="${item.image_data}">Aantal dagen te laat: ${item.daysDifference}</p>
                            
                            </div>
                            <div class="moreinfo">
                                <img class="dots"  src="/ProgrammingProject1/images/9025404_dots_three_icon.png" alt="More info image">
                            </div>
                        `;
    
                        // Append product info to card
                        card.appendChild(productInfo);
    
                        document.getElementById('InOut3').appendChild(card);
                        
                        
                    
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                
            }
        });
    }


    //ON WINDOW LOAD 
     
    

    // Event listener for accepting an item
    $(document).on('click', '.accepterenBtn', function(e) {
        e.preventDefault();

        // Store the context of 'this' in a variable
        var $this = $(this);

        // Retrieve the lening_id associated with the clicked row
        var leningId = $this.closest('.inOutProduct').data('lening-id');

        // Send AJAX request to delete the row from the database
        $.ajax({
            url: '../../productAccepteren.php',
            method: 'POST',
            data: { leningId: leningId },
            success: function(response) {
                // Upon successful deletion, remove the corresponding row from the HTML
                if (response === 'success') {
                    // Remove the closest '.inOutProduct' element
                    $this.closest('.inOutProduct').remove();
                } else {
                    console.error('Failed to delete row');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
        
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

    $('.inputZoekbalk5').on('keyup', function() {
        let zoekterm = $(this).val().toLowerCase();

        $('#InOut3 .inOutProduct').each(function() {
            let naam = $(this).find('.Naam').text().toLowerCase();

            if (naam.includes(zoekterm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    teLaatTerugGebracht();

    function openPopup() {
    
        var overlay = document.getElementById("overlay");
        overlay.style.display = "block";
        var popup = document.getElementById("popup");
        var $this = $(this);
    
            // Retrieve the lening_id associated with the clicked row
        var leningId = $this.closest('.inOutProduct').data('lening-id');
        var naam = $this.closest('.inOutProduct').find('.Naam').attr('value');
        var productNr = $this.closest('.inOutProduct').find('.accepterenProductID').attr('value');
        var userNr = $this.closest('.inOutProduct').find('.userId').attr('value');
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
                    <p class="userId">User ID: ${userNr}</p>
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




    
