let mymap = L.map('mapid');
let tiles = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {foo: 'bar'});
tiles.addTo(mymap);
mymap.setView([38.2462420, 21.7350847], 6);


function reqListener () {
   console.log(this.responseText);
}

var data;
var oReq = new XMLHttpRequest(); 
oReq.onload = function() {

   data = JSON.parse(this.responseText);
   let testData = data;
   let cfg = {"radius": 40,
   "maxOpacity": 0.8,
   "scaleRadius": false,
   "useLocalExtrema": false,
   latField: "lat",
   lngField: "lng",
   valueField: "count"};
   let heatmapLayer = new HeatmapOverlay(cfg);
   mymap.addLayer(heatmapLayer);
   heatmapLayer.setData(testData);
   
};
oReq.open("get", "map_data.php", true);

oReq.send();