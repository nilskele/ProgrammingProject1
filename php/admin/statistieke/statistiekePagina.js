function filterProducts() {
    var groupID = document.getElementById('searchInput').value;
    if (groupID === "") {
        // Als het zoekveld leeg is, haal dan alle gegevens op
        loadAllProducts();
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'statistiekeBackendPagina.php?groupID=' + groupID, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var table = document.getElementById('productTable');
            table.innerHTML = `
                <tr>
                    <th>Groep_id</th>
                    <th>Product naam</th>
                    <th>Aantal keer gereserveerd</th>
                    <th>Aantal defecten gemeld</th>
                </tr>`;
            data.forEach(function(row) {
                var tr = document.createElement('tr');
                tr.innerHTML = `<td>${row.groep_id}</td><td>${row.naam}</td><td>${row.reserve_count}</td><td>${row.defect_count}</td>`;
                table.appendChild(tr);
            });
        }
    };
    xhr.send();
}

function loadAllProducts() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'statistiekeBackendPagina.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            var table = document.getElementById('productTable');
            table.innerHTML = `
                <tr>
                    <th>Groep_id</th>
                    <th>Product naam</th>
                    <th>Aantal keer gereserveerd</th>
                    <th>Aantal defecten gemeld</th>
                </tr>`;
            data.forEach(function(row) {
                var tr = document.createElement('tr');
                tr.innerHTML = `<td>${row.groep_id}</td><td>${row.naam}</td><td>${row.reserve_count}</td><td>${row.defect_count}</td>`;
                table.appendChild(tr);
            });
        }
    };
    xhr.send();
}

// Laad alle producten bij het laden van de pagina
document.addEventListener('DOMContentLoaded', loadAllProducts);