let map;

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
  getapi(url);
