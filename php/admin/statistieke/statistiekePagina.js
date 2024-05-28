function filterProducts() {
    var groupID = document.getElementById('searchInput').value;
    var url = 'statistiekeBackendPagina.php';
    if (groupID !== "") {
        url += '?groupID=' + groupID;
    }
    fetchData(url);
}

function loadAllProducts() {
    fetchData('statistiekeBackendPagina.php');
}

function fetchData(url) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            displayProducts(data);
        }
    };
    xhr.send();
}

function displayProducts(data) {
    var table = document.getElementById('productTable');
    table.innerHTML = `
        <tr>
            <th>Groep_id</th>
            <th>Product naam</th>
            <th>Aantal keer gereserveerd</th>
            <th>Aantal defecten gemeld</th>
            <th>De meest voorkomende reden</th>
        </tr>`;
    data.forEach(function(row) {
        var tr = document.createElement('tr');
        tr.innerHTML = `<td>${row.groep_id}</td><td>${row.naam}</td><td>${row.reserve_count}</td><td>${row.defect_count}</td><td>${row.most_common_reason}</td>`;
        table.appendChild(tr);
    });
}

// Laad alle producten bij het laden van de pagina
document.addEventListener('DOMContentLoaded', loadAllProducts);
