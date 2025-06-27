let statusConv = {
    2: "Anchored",
    3: "Restricted Maneuverability",
    5: "Moored",
    6: "Aground",
    7: "Engaged in fishing",
    8: "Under way sailing",
    14: "SART / MOB / EPIRB",
    15: "Undefined"
}
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
        handlerNotification(response);
        updateStatShips();
    }, data);
}

function displayShips(ships){
    let target = document.getElementById("shipContainer");
    target.innerHTML = "";
    if(ships.length === 0){
        let emptyMess = `<h2 class="text-sm font-bold text-white">No ships are registered yet !</h2>`
        target.insertAdjacentHTML("beforeend", emptyMess);
    }
    Array.from(ships).forEach( (s) => {
        console.log('ship spec is ', s);
        let card = `
            <div class="relative w-full max-w-md h-44 rounded-2xl overflow-hidden shadow-xl mx-auto">
                <!--
                <img
                        src="https://images.unsplash.com/photo-1607013251421-cf2a1f25b6fc?auto=format&fit=crop&w=800&q=80"
                        alt="Boat top view"
                        class="absolute inset-0 w-full h-full object-cover"
                />
                -->
                <!-- eff -->
                <div class="absolute inset-0 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-4 text-white">
                    <img
                            src="/assets/ship.jpeg"
                            class="w-14 h-14 rounded-md object-cover shadow-md"
                            alt="Boat icon"
                    />
    
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold drop-shadow">${s.vesselName}</h2>
                            <span class="text-xs bg-blue-200/30 text-white px-2 py-1 rounded-full backdrop-blur-sm drop-shadow">Cruising</span>
                        </div>
                        <p class="text-sm text-gray-200 drop-shadow">MMSI: ${s.mmsi}</p>
                        <div class="flex flex-wrap gap-2 mt-2 text-xs drop-shadow">
                            <span class="bg-white/20 px-2.5 py-1 rounded-md">⚓ Width: ${s.width}m</span>
                            <span class="bg-white/20 px-2.5 py-1 rounded-md">📏 Length: ${s.length}m</span>
                            <span class="bg-white/20 px-2.5 py-1 rounded-md">🌊 Draft: ${s.draft}m</span>
                        </div>
                    </div>
                </div>
            </div>
        `
        target.insertAdjacentHTML("beforeend", card);
    });
}

function updateStatShips(){
    ajaxRequest('GET', '/updatestatships', function(response) {
        console.log(response);
        document.getElementById("numShipsTracked").innerText = response.numShipsTracked;
        document.getElementById("numShipsDocked").innerText = response.numShipsDocked;
        displayShips(response.ships);
    });
}
//------------------------------------------------------------------------------
//--- Listeners --------------------------------------------------------------
//------------------------------------------------------------------------------
document.querySelector('button').addEventListener('click', (event) => {
    event.preventDefault();
    insertShip();
});

updateStatShips();