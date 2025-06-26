function getColor(index) {
    const colors = ["red", "blue", "green", "orange", "purple", "brown"];
    return colors[index % colors.length];
}
function displayMap(ships){
    const traces = ships.map(ship => ({
        type: "scattermapbox",
        mode: "lines+markers",
        lat: ship.lats,
        lon: ship.lons,
        name: `${ship.name} (${ship.mmsi})`,
        line: { width: 3, color: ship.color },
        marker: { size: 6 }
    }));

    const layout = {
        mapbox: {
            style: 'mapbox://styles/mapbox/light-v10',
            center: { lon: -90, lat: 26 },
            zoom: 5.5,
        },
        margin: { t: 0, b: 0, l: 0, r: 0 },
        showlegend: false,
    };

    if(ships.length !== 0){
        Plotly.setPlotConfig({ mapboxAccessToken: 'pk.eyJ1IjoibmlyaWphbSIsImEiOiJjbWNiMHhyZWQwYXF1MmtzYnRvNHRzenpjIn0.iY39sB9K0IUgezsqp_4Icg' });
        Plotly.newPlot('map', traces, layout, { responsive: true });
    }
    else{
        handlerNotification({type: "error", message: "No entry found with the specified criterias"})
        document.getElementById("map").innerHTML = "";
    }


}

function handlePositions(){
    let filters = [];
    let data;
    Array.from(document.querySelectorAll("input[type='checkbox']")).forEach((inp, index) => {
        if(inp.checked){
            filters.splice(index, 0, parseInt(inp.value));
        }
        else{
            filters.splice(index, 0, 0);
        }
    });
    filters.push(document.getElementById("mmsi_filter").value);

    if((filters[0] + filters[1]  + filters[2]) === 0 && filters[3] === ""){ //no filter print all !
        data = null;
    }
    else{
        let [passenger, cargo, tanker, mmsi] = filters;
        data = new URLSearchParams({
            passenger,
            cargo,
            tanker,
            mmsi
        }).toString();
    }

    console.log("filters:", filters);
    console.log("data:", data);

    ajaxRequest('GET', '/obtainpositions', function(positions) {
        console.log("in call back handlePositions");
        const grouped = {};
        positions.forEach(entry => {
            const { lat, lon, ship } = entry;
            const { mmsi, vesselName } = ship;

            if (!grouped[mmsi]) {
                grouped[mmsi] = {
                    name: vesselName,
                    mmsi: mmsi,
                    lats: [],
                    lons: []
                };
            }

            grouped[mmsi].lats.push(lat);
            grouped[mmsi].lons.push(lon);
        });
        const ships = Object.values(grouped).map((ship, index) => ({
            ...ship,
            color: getColor(index)
        }));
        console.log(ships);
        displayMap(ships);
    }, data);
}

document.getElementById("applyFilters").addEventListener("click", (event) =>{
    event.preventDefault();
    handlePositions();
});

handlePositions();