const ships = [
    {
        name: "Ship A",
        mmsi: "123456789",
        lats: [29.75, 29.80, 29.85],
        lons: [-95.36, -95.30, -95.25],
        color: "red"
    },
    {
        name: "Ship B",
        mmsi: "987654321",
        lats: [22.20, 22.25, 22.30],
        lons: [-97.85, -97.80, -97.75],
        color: "blue"
    },
    {
        name: "Ship C",
        mmsi: "192837465",
        lats: [30.65, 30.70, 30.75],
        lons: [-88.05, -88.00, -87.95],
        color: "green"
    }
];

// Générer les traces pour chaque navire
const traces = ships.map(ship => ({
    type: "scattermapbox",
    mode: "lines+markers",
    lat: ship.lats,
    lon: ship.lons,
    name: `${ship.name} (${ship.mmsi})`,
    line: { width: 3, color: ship.color },
    marker: { size: 6 }
}));

const data = traces; //can make array for multiple instance to draw

const layout = {
    mapbox: {
        style: 'mapbox://styles/mapbox/light-v10',
        center: { lon: -90, lat: 26 },
        zoom: 5.5,
    },
    margin: { t: 0, b: 0, l: 0, r: 0 },
    showlegend: false,
};

Plotly.setPlotConfig({ mapboxAccessToken: 'pk.eyJ1IjoibmlyaWphbSIsImEiOiJjbWNiMHhyZWQwYXF1MmtzYnRvNHRzenpjIn0.iY39sB9K0IUgezsqp_4Icg' });

Plotly.newPlot('map', data, layout, { responsive: true });