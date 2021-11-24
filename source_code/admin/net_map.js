//Map Section
let mymap = L.map('mapid');
let tiles = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {foo: 'bar'});
tiles.addTo(mymap);
mymap.setView([38.2462420, 21.7350847], 5);


function reqListener () {
   console.log(this.responseText);
}


function setMarkers(data) {
  var max= 0;
  data.forEach(function (obj) {

    new L.Marker([obj.lat, obj.lng]).addTo(mymap);
    new L.Marker([obj.ulat, obj.ulng]).addTo(mymap);
    if(obj.count>max){
      max=obj.count;
    }
    var weight = (obj.count/max)*10;
    var latlngs = [
      [obj.lat, obj.lng],
      [obj.ulat, obj.ulng]
    ];
    
    var polyline = L.polyline(latlngs, {color: 'red', weight: weight}).addTo(mymap);
  });
}

var data;
var oReq = new XMLHttpRequest(); 
oReq.onload = function() {

   data = JSON.parse(this.responseText);
   setMarkers(data);

};
oReq.open("get", "net_map_data.php", true);

oReq.send();