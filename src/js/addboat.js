function insertShip() {
    const mmsi = document.getElementById('mmsi').value.trim();
    const name = document.getElementById('name').value.trim();
    const status = document.getElementById('status').value;
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    const timestamp = document.getElementById('timestamp').value;
    const sog = document.getElementById('sog').value;
    const cog = document.getElementById('cog').value;
    const heading = document.getElementById('heading').value;
    const length = document.getElementById('length').value;
    const width = document.getElementById('width').value;
    const draft = document.getElementById('draft').value;

    const data = new URLSearchParams({
        mmsi,
        name,
        status,
        latitude,
        longitude,
        timestamp,
        sog,
        cog,
        heading,
        length,
        width,
        draft
    }).toString();

    // Envoi de la requête AJAX
    ajaxRequest('POST', '/insertboat', function(response) {
        console.log(response);
    }, data);
}

document.querySelector('button').addEventListener('click', (event) => {
    event.preventDefault(); // Évite un éventuel rechargement de page
    insertShip();
});