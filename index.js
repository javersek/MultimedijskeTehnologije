let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 46.060976362379066, lng: 14.510848589269866 },
    zoom: 13,
  });
}
