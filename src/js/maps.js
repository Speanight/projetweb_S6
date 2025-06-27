colorsCluster = {
    0 : "#BC4B51",
    1 : "#5B8E7D",
    2 : "#F4A259",
    3 : "#8CB369",
    4 : "#5B2E48",
    5 : "#2274A5",
    6 : "#131B23",
    7 : "#BBD686",
    8 : "#C2A83E"
};

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
       console.log(positions);
        const grouped = {};
        positions.forEach(entry => {
            const { lat, lon, ship } = entry;
            const { mmsi, vesselName, cluster } = ship;
            const num_cluster = cluster.num_cluster;

            if (!grouped[mmsi]) {
                grouped[mmsi] = {
                    name: vesselName,
                    mmsi: mmsi,
                    lats: [],
                    lons: [],
                    num_cluster: num_cluster // Ajout ici
                };
            }

            grouped[mmsi].lats.push(lat);
            grouped[mmsi].lons.push(lon);
        });
        const ships = Object.values(grouped).map((ship, index) => ({
            ...ship,
            color: colorsCluster[ship.num_cluster]
        }));
        console.log(ships);
        displayMap(ships);
    }, data);
}

function getAllMMSI(){
    ajaxRequest("GET", "/mmsi", (data) => {
        let mmsi = data.map((obj) => obj.mmsi);
        let target = document.getElementById("listMMSI");
        mmsi.forEach((m) => {
            target.insertAdjacentHTML("beforeend", `<option>${m}</option>`);
        });
    });
}

//------------------------------------------------------------------------------
//--- Listeners --------------------------------------------------------------
//------------------------------------------------------------------------------
function initPredicts() {
    document.querySelectorAll('.predict-trajectory').forEach(item => {
        item.addEventListener('click', (event) => {
        event.preventDefault();
        timestamp = event.target.parentNode.parentNode.getElementsByClassName("input-timestamp")[0].value;
        mmsi = event.target.parentNode.parentNode.getElementsByClassName("input-timestamp")[0].id.substr(10);
        // SOG COG Heading VesselType Delta_sec
        id = event.target.parentNode.parentNode.getElementsByClassName("trajectory-id")[0].value;
    
        const data = new URLSearchParams({
            id,
            timestamp,
            mmsi
        }).toString();
    
        ajaxRequest('GET', '/predicttrajectory', function(response) {
            event.target.parentNode.parentNode.parentNode.getElementsByClassName("pred-answer")[0].style.display = 'block';
            event.target.parentNode.parentNode.parentNode.getElementsByClassName("pred-text")[0].innerHTML = `
            Your ship is predicted to be at <strong>${response.LAT} / ${response.LON}</strong> after <strong>${response.time}</strong> minutes.`
        }, data);
        })
    });
    
    document.querySelectorAll('.change-type').forEach(item => {
        item.addEventListener('click', (event) => {
            event.preventDefault();
            mmsi = event.target.parentNode.parentNode.getElementsByClassName("boatType-mmsi")[0].value;
            type = event.target.parentNode.parentNode.getElementsByClassName("boatType-type")[0].value;
    
            const data = new URLSearchParams({
                mmsi,
                type
            })
    
            ajaxRequest('PUT', '/edit/vesseltype', function(response) {
                handlerNotification(response);
    
                var color = "";
    
                switch (response.type) {
                    case 60:
                        color = "text-red-600";
                        break;
                    
                    case 70:
                        color = "text-lime-600";
                        break;
                    
                    case 80:
                        color = "text-sky-600";
                        break;
                }
    
                event.target.parentNode.parentNode.parentNode.getElementsByClassName("type-prediction")[0].innerHTML = `
                The ship is predicted to be a <strong class="${color}">${response.descr}</strong>`
            }, data);
        })
    })
}

//Display the map again by taking account of the eventual filters
document.getElementById("applyFilters").addEventListener("click", (event) =>{
    event.preventDefault();
    handlePositions();
});

//Update cluster on button refresh
document.getElementById("refreshClusters").addEventListener("click", (event) => {
    event.preventDefault();
    handlerNotification({type: "warning", message: "Refreshing clustering, this might take a while..."});
    ajaxRequest("PUT", "/updateClusters", function (response) {
        handlePositions();
        handlerNotification(response);
    });
});
handlePositions();
getAllMMSI();


//////////////////////////////////////////
/////              TABLE             /////
//////////////////////////////////////////
var page = 1;

document.querySelector("#previous-page").addEventListener('click', (event) => {
    if (page > 1) {
        page -= 1;
        document.getElementById("pageNumber").innerHTML = page;

        const data = new URLSearchParams({page})

        ajaxRequest('GET', '/get/nboats', updateTable, data)
    }
})

document.querySelector("#next-page").addEventListener('click', (event) => {
    if (page < document.getElementById('pageLimit').innerHTML) {
        page += 1;
        document.getElementById("pageNumber").innerHTML = page;

        const data = new URLSearchParams({page});

        ajaxRequest('GET', '/get/nboats', updateTable, data);
    }
})

function updateTable(response) {
    const table = document.getElementById("tableContent")
    table.innerHTML = '';
    response.forEach(pos => {
            switch (pos.type) {
                case 60:
                    color = "text-red-600";
                    break;
                
                case 70:
                    color = "text-lime-600";
                    break;
                
                case 80:
                    color = "text-sky-600";
                    break;
            }

        // {"id":40,"LAT":25.80402,"LON":-80.2561,"timestamp":{"date":"2023-05-29 00:00:04.000000","timezone_type":3,"timezone":"UTC"},
        // "SOG":0,"COG":0,"Heading":310,"status":0,"mmsi":"354543000","vesselName":"BETTY K VI",
        // "imo":"801216 ","Length":61,"Width":12,"Draft":3.9,"type":70,"description":"cluster zero",
        // "num_cluster":0}
        table.innerHTML += `
        <tr class="border-b bg-gray-800 border-gray-700 hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">${pos.vesselName}</th>
            <td class="px-6 py-4">${pos.humanTimestamp}</td>
            <td class="px-6 py-4">${pos.mmsi}</td>
            <td class="px-6 py-4">
                ${pos.LAT} / ${pos.LON}
            </td>
            <td class="px-6 py-4">${pos.SOG} / ${pos.COG} / ${pos.Heading}</td>
            <td class="px-6 py-4">${pos.Length} / ${pos.Width} / ${pos.Draft}</td>
            <!-- Buttons for prediction -->
            <td class="flex items-center px-6 py-4">
                <!-- Section for button and modal -->
                <section x-data="{modalOpen: false}">
                    <button @click="modalOpen = true" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-gray text-white focus:ring-4 focus:outline-none focus:ring-cyan-800">
                        <span class="relative px-5 transition-all ease-in duration-75 bg-gray-900 rounded-md  group-hover:bg-transparent">
                        Predict type
                        </span>
                    </button>
                    <div x-show="modalOpen" x-transition
                        class="fixed left-0 top-0 flex h-full min-h-screen w-full items-center justify-center bg-dark/90 px-4 py-5">
                        <div @click.outside="modalOpen = false"
                            class="w-full max-w-[570px] rounded-[20px] bg-white px-8 py-12 text-center md:px-[70px] md:py-[60px]">
                            <h3 class="type-prediction pb-[18px] text-xl font-semibold text-dark sm:text-2xl">
                                The ship is predicted to be a <strong class="${color}">${pos.tdescription}</strong>
                            </h3>
                            <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                Please note that our model is only able to predict Passager, Cargo and Tanker. If you're willing to manually adjust your ship type, you may do so thanks to the dropdown below.
                            </p>
                            
                            <div class="flex items-center gap-4">
                                <div class="relative w-3/4">
                                    <div class="container">
                                        <div>
                                        <div class="relative">
                                            <select name="default-select"
                                            class="boatType-type w-full appearance-none rounded-lg border border-stroke bg-transparent py-3 pl-5 pr-12 text-dark outline-hidden focus:border-primary ">
                                            <option value="60" class="text-red-600""><strong>Passenger</strong></option>
                                            <option value="70" class="text-lime-600"><strong>Cargo</strong></option>
                                            <option value="80" class="text-sky-600"><strong>Tanker</strong></option>
                                            </select>
                                            <input type="text" class="hidden boatType-mmsi" value="${pos.mmsi}" />
                                            <span
                                            class="pointer-events-none absolute right-0 top-0 flex h-full w-12 items-center justify-center text-dark-5">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                d="M2.29645 5.15354L2.29642 5.15357L2.30065 5.1577L7.65065 10.3827L8.00167 10.7255L8.35105 10.381L13.7011 5.10603L13.7011 5.10604L13.7036 5.10354C13.7221 5.08499 13.7386 5.08124 13.75 5.08124C13.7614 5.08124 13.7779 5.08499 13.7964 5.10354C13.815 5.12209 13.8188 5.13859 13.8188 5.14999C13.8188 5.1612 13.8151 5.17734 13.7974 5.19552L8.04956 10.8433L8.04955 10.8433L8.04645 10.8464C8.01604 10.8768 7.99596 10.8921 7.98519 10.8992C7.97756 10.8983 7.97267 10.8968 7.96862 10.8952C7.96236 10.8929 7.94954 10.887 7.92882 10.8721L2.20263 5.2455C2.18488 5.22733 2.18125 5.2112 2.18125 5.19999C2.18125 5.18859 2.18501 5.17209 2.20355 5.15354C2.2221 5.13499 2.2386 5.13124 2.25 5.13124C2.2614 5.13124 2.2779 5.13499 2.29645 5.15354Z"
                                                fill="currentColor" stroke="currentColor" />
                                            </svg>
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <button type="button"
                                            class="change-type w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800">
                                        Modify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section x-data="{modalOpen: false}">
                    <button @click="modalOpen = true" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-gray text-white focus:ring-4 focus:outline-none focus:ring-cyan-800">
                        <span class="relative px-5 transition-all ease-in duration-75 bg-gray-900 rounded-md  group-hover:bg-transparent">
                        Predict trajectory
                        </span>
                    </button>

                    <div x-show="modalOpen" x-transition
                        class="fixed left-0 top-0 flex h-full min-h-screen w-full items-center justify-center bg-dark/90 px-4 py-5">
                        <div @click.outside="modalOpen = false"
                            class="w-full max-w-[570px] rounded-[20px] bg-white px-8 py-12 text-center md:px-[70px] md:py-[60px]">
                            <h3 class="pb-[18px] text-xl font-semibold text-dark sm:text-2xl">
                                Predict your ship position !
                            </h3>
                            <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                You can predict your ship position after a specific time by using below buttons.
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="relative w-3/4">
                                    <input type="number" id="timestamp-${pos.mmsi}" name="timestamp"
                                        class="input-timestamp w-full pr-12 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                        min="1" step="1" required
                                        placeholder="Duration"
                                    />
                                    <input type="text" class="hidden trajectory-id" value="${pos.id}" />
                                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-500 text-sm">
                                        min
                                    </span>
                                </div>
                                <div class="w-1/4">
                                    <button type="button"
                                            class="predict-trajectory w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800">
                                        Predict
                                    </button>
                                </div>
                            </div>
                            <!-- Pred answer -->
                            <div class="mt-6 pred-answer hidden">
                                <span class=" inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                <p class="pred-text">Your ship is predicted to be at POS after X minutes</p>
                            </div>
                        </div>
                    </div>
                </section>
            </td>
        </tr>
        `
    });
    initPredicts();
}


ajaxRequest('GET', '/get/nboats', updateTable, "page=" + page);