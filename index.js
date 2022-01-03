/*let map;

var markers = [];

function initMap(markers) {
  markers=[]
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 46.060976362379066, lng: 14.510848589269866 },
    zoom: 13,
  });

  const styles = {
    hide: [
      {
        featureType: "poi",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "administrative",
        elementType: "labels",
        stylers: [{ visibility: "off" }],
      },
    ],
  };


  map.setOptions({styles: styles["hide"]});
}


var marker;
  const url="https://api.ontime.si/api/v1/bicikelj/?format=json";

  async function getapi(url){
    const response = await fetch(url);
    var data = await response.json();
    for(let i = 0; i<data["results"].length; i++){
      const pozicija = {lat: data["results"][i]["lat"], lng: data["results"][i]["lng"]};

      marker = new google.maps.Marker({
        position: pozicija,
        map: map,
      });

      marker.metadata = {id: i};

      markers[i]=marker;
      

      var infowindow = new google.maps.InfoWindow()


      google.maps.event.addListener(marker,'click', (function(marker,infowindow){
        return function(){



          function ajax(){
            $.ajax({
              url: 'https://api.ontime.si/api/v1/bicikelj/?format=json',
              type: "GET",
              success: function(data){
                console.log(data["results"][marker.metadata.id]["available_bikes"]);
                var content = data["results"][i]["location_name"] + "<br><a>Available bikes: " + data["results"][i]["available_bikes"] + "</a>"
                                                        + "<br><a>Available stands: " + data["results"][i]["available_stands"] + "</a>";

                infowindow.setContent(content);
              },
              error: function (error) {
                console.log(`Error ${error}`);
              }
            })
            
          }

          var content = data["results"][i]["location_name"] + "<br><a>Available bikes: " + data["results"][i]["available_bikes"] + "</a>"
                                                        + "<br><a>Available stands: " + data["results"][i]["available_stands"] + "</a>";
          infowindow.setContent(content);

          infowindow.open(map,marker);

          setInterval(ajax, 10000);

        };
      })(marker,infowindow));

    }
  }
  getapi(url);*/



let map;





var markers = [];

function initMap(markers) {
  const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer();
  markers=[]
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 46.060976362379066, lng: 14.510848589269866 },
    zoom: 13,
  });

  document.getElementById("hide-markers").addEventListener("click", hideMarkers);
  document.getElementById("show-markers").addEventListener("click", showMarkers);

  const styles = {
    hide: [
      {
        featureType: "poi",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "administrative",
        elementType: "labels",
        stylers: [{ visibility: "off" }],
      },
    ],
  };


  map.setOptions({styles: styles["hide"]});

  directionsRenderer.setMap(map);

  const onChangeHandler = function () {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
  };

  document.getElementById("risi").addEventListener("change", onChangeHandler);

}

/*google.maps.event.addEventListener(map, 'click', function() {
  marker.setVisible(false);
});*/


const url2='https://api.ontime.si/api/v1/avant2go/?format=json';

var marker;
  const url="https://api.ontime.si/api/v1/bicikelj/?format=json";


  async function getapi2(url2, markers){
    const response = await fetch(url2);
    var data = await response.json();
    for(let i = markers.length; i<data["results"].length+markers.length; i++){
      const pozicija = {lat: data["results"][i]["lat"], lng: data["results"][i]["lng"]};

      marker = new google.maps.Marker({
        position: pozicija,
        icon: {url:"http://maps.google.com/mapfiles/ms/icons/blue-dot.png"},
        map: map,
        
      });

      marker.metadata = {id: i};

      markers[i]=marker;
      

      var infowindow = new google.maps.InfoWindow()


      google.maps.event.addListener(marker,'click', (function(marker,infowindow){
        return function(){



          function ajax(){
            $.ajax({
              url: 'https://api.ontime.si/api/v1/avant2go/?format=json',
              type: "GET",
              success: function(data){
                console.log(data["results"][marker.metadata.id]["free_spaces"]);
                var content = data["results"][i]["location_name"] + "<br><a>Free spaces: " + data["results"][i]["free_spaces"] + "</a>"
                                                        + "<br><a>Reservable cars: " + data["results"][i]["reservable_cars"] + "</a>";

                infowindow.setContent(content);
              },
              error: function (error) {
                console.log(`Error ${error}`);
              }
            })
            
          }

          var content = data["results"][i]["location_name"] + "<br><a>Free spaces: " + data["results"][i]["free_spaces"] + "</a>"
                                                        + "<br><a>Reservable cars: " + data["results"][i]["reservable_cars"] + "</a>";
          infowindow.setContent(content);

          infowindow.open(map,marker);

          setInterval(ajax, 10000);

        };
      })(marker,infowindow));

    }
  }




  async function getapi(url, markers){
    const response = await fetch(url);
    var data = await response.json();
    for(let i = 0; i<data["results"].length; i++){
      const pozicija = {lat: data["results"][i]["lat"], lng: data["results"][i]["lng"]};

      marker = new google.maps.Marker({
        position: pozicija,
        map: map,
      });

      marker.metadata = {id: i};

      markers[i]=marker;
      

      var infowindow = new google.maps.InfoWindow()


      google.maps.event.addListener(marker,'click', (function(marker,infowindow){
        return function(){



          function ajax(){
            $.ajax({
              url: 'https://api.ontime.si/api/v1/bicikelj/?format=json',
              type: "GET",
              success: function(data){
                console.log(data["results"][marker.metadata.id]["available_bikes"]);
                var content = data["results"][i]["location_name"] + "<br><a>Available bikes: " + data["results"][i]["available_bikes"] + "</a>"
                                                        + "<br><a>Available stands: " + data["results"][i]["available_stands"] + "</a>";

                infowindow.setContent(content);
              },
              error: function (error) {
                console.log(`Error ${error}`);
              }
            })
            
          }

          var content = data["results"][i]["location_name"] + "<br><a>Available bikes: " + data["results"][i]["available_bikes"] + "</a>"
                                                        + "<br><a>Available stands: " + data["results"][i]["available_stands"] + "</a>";
          infowindow.setContent(content);

          infowindow.open(map,marker);

          setInterval(ajax, 10000);

        };
      })(marker,infowindow));

    }
  }



  function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }
  
  function hideMarkers() {
    setMapOnAll(null);
  }
  
  function showMarkers() {
    setMapOnAll(map);
  }




getapi(url, markers);
getapi2(url2, markers);




