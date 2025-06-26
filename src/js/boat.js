//------------------------------------------------------------------------------
//--- Listeners --------------------------------------------------------------
//------------------------------------------------------------------------------
function insertShip() {
    const mmsi = document.getElementById('mmsi').value.trim();
    const vesselname = document.getElementById('name').value.trim();
    const status = document.getElementById('status').value;
    const lat = document.getElementById('latitude').value;
    const lon = document.getElementById('longitude').value;
    const timestamp = document.getElementById('timestamp').value;
    const sog = document.getElementById('sog').value;
    const cog = document.getElementById('cog').value;
    const heading = document.getElementById('heading').value;
    const length = document.getElementById('length').value;
    const width = document.getElementById('width').value;
    const draft = document.getElementById('draft').value;

    const data = new URLSearchParams({
        mmsi,
        vesselname,
        status,
        lat,
        lon,
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

function updateStatShips(){
    ajaxRequest('GET', '/updatestatships', function(response) {
        document.getElementById("numShipsTracked").innerText = response.numShipsTracked;
        document.getElementById("numShipsDocked").innerText = response.numShipsDocked;
    });
}
//------------------------------------------------------------------------------
//--- Listeners --------------------------------------------------------------
//------------------------------------------------------------------------------
document.querySelector('button').addEventListener('click', (event) => {
    event.preventDefault();
    insertShip();
});