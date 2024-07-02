  <?php
  $server = "localhost";
  $username = "root";
  $password = "";
  $dbname = "licenta";

  session_start();

  if (!isset($_SESSION["username"])) {
      header("Location: index.php");
      exit();
  }

  // Create a connection
  $conn = new mysqli($server, $username, $password, $dbname);

  $username = $_SESSION["username"];
  $isadmin = $_SESSION["isadmin"];
  $realname = $_SESSION["realname"];
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Game</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <style type="text/css">
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
      }
      #pano {
        flex: 1;
        width: 100%;
      }
      #map-container {
        position: absolute;
        bottom: 60px;
        right: 20px;
        width: 350px;
        height: 250px;
        z-index: 5;
        background-color: #fff;
        padding: 0;
        border: none;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      }
      #map {
        width: 100%;
        height: calc(100% - 40px);
      }
      #guessButton {
        margin: 0;
        width: 100%;
        background-color: #228B22; 
        color: #fff;
        padding: 10px 0;
        border: none;
        border-radius: 0 0 8px 8px;
        font-size: 16px;
        cursor: pointer;
      }
      #guessButton:hover {
        background-color: #196619; 
      }
      .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #808080;
        padding: 10px;
      }
      .home-button {
        width: 30px;
        height: 30px;
        background-image: url('home.png');
        background-size: cover;
        cursor: pointer;
      }
      .realname-label {
        color: #fff;
        font-size: 14px;
        margin-right: 10px;
      }
    </style>
    <script>
      var played = false;
      var map, guessMarker, targetMarker, linePath;
      var currentLocation, currentCords, currentCity;
      var guessButton;
      var panorama;

      var locations = [
      [{ lat: 42.345573, lng: -71.098326 }, { city: 'Boston' }],
      [{ lat: 48.858844, lng: 2.294351 }, { city: 'Paris' }],
      [{ lat: 40.748817, lng: -73.985428 }, { city: 'New York' }],
      [{ lat: 34.052235, lng: -118.243683 }, { city: 'Los Angeles' }],
      [{ lat: 51.507351, lng: -0.127758 }, { city: 'London' }],
      [{ lat: 35.689487, lng: 139.691711 }, { city: 'Tokyo' }],
      [{ lat: 55.755825, lng: 37.617298 }, { city: 'Moscow' }],
      [{ lat: -33.868820, lng: 151.209296 }, { city: 'Sydney' }],
      [{ lat: 37.774929, lng: -122.419418 }, { city: 'San Francisco' }],
      [{ lat: 19.432608, lng: -99.133209 }, { city: 'Mexico City' }],
      [{ lat: 1.352083, lng: 103.819839 }, { city: 'Singapore' }],
      [{ lat: 41.902782, lng: 12.496366 }, { city: 'Rome' }],
      [{ lat: 35.676193, lng: 139.650311 }, { city: 'Tokyo' }],
      [{ lat: 39.904202, lng: 116.407394 }, { city: 'Beijing' }],
      [{ lat: -22.906847, lng: -43.172897 }, { city: 'Rio de Janeiro' }],
      [{ lat: 52.520008, lng: 13.404954 }, { city: 'Berlin' }],
      [{ lat: 40.416775, lng: -3.703790 }, { city: 'Madrid' }],
      [{ lat: 31.230391, lng: 121.473701 }, { city: 'Shanghai' }],
      [{ lat: 41.008240, lng: 28.978359 }, { city: 'Istanbul' }],
      [{ lat: 13.756331, lng: 100.501762 }, { city: 'Bangkok' }],
      [{ lat: 28.613939, lng: 77.209021 }, { city: 'New Delhi' }],
      [{ lat: 43.653225, lng: -79.383186 }, { city: 'Toronto' }],
      [{ lat: 55.953251, lng: -3.188267 }, { city: 'Edinburgh' }],
      [{ lat: -34.603722, lng: -58.381592 }, { city: 'Buenos Aires' }],
      [{ lat: 48.135125, lng: 11.581981 }, { city: 'Munich' }],
      [{ lat: 45.464211, lng: 9.191383 }, { city: 'Milan' }],
      [{ lat: 25.276987, lng: 55.296249 }, { city: 'Dubai' }],
      [{ lat: 50.110924, lng: 8.682127 }, { city: 'Frankfurt' }],
      [{ lat: 35.689487, lng: 139.691711 }, { city: 'Tokyo' }],
      [{ lat: 39.904202, lng: 116.407394 }, { city: 'Beijing' }],
      [{ lat: -33.924870, lng: 18.424055 }, { city: 'Cape Town' }],
      [{ lat: -26.204103, lng: 28.047304 }, { city: 'Johannesburg' }],
      [{ lat: 55.755825, lng: 37.617298 }, { city: 'Moscow' }],
      [{ lat: 40.730610, lng: -73.935242 }, { city: 'New York' }],
      [{ lat: 34.052235, lng: -118.243683 }, { city: 'Los Angeles' }],
      [{ lat: 35.689487, lng: 139.691711 }, { city: 'Tokyo' }],
      [{ lat: 51.507351, lng: -0.127758 }, { city: 'London' }],
      [{ lat: 48.856613, lng: 2.352222 }, { city: 'Paris' }],
      [{ lat: 40.416775, lng: -3.703790 }, { city: 'Madrid' }],
      [{ lat: 41.902782, lng: 12.496366 }, { city: 'Rome' }],
      [{ lat: 52.520008, lng: 13.404954 }, { city: 'Berlin' }],
      [{ lat: 50.850346, lng: 4.351721 }, { city: 'Brussels' }],
      [{ lat: 45.764043, lng: 4.835659 }, { city: 'Lyon' }],
      [{ lat: 37.983810, lng: 23.727539 }, { city: 'Athens' }],
      [{ lat: 59.329323, lng: 18.068581 }, { city: 'Stockholm' }],
      [{ lat: 40.712776, lng: -74.005974 }, { city: 'New York' }],
      [{ lat: 34.052235, lng: -118.243683 }, { city: 'Los Angeles' }],
      [{ lat: 41.878113, lng: -87.629799 }, { city: 'Chicago' }]
  ];


      function checkDistance() {
        var lat1 = guessMarker.getPosition().lat();
        var lng1 = guessMarker.getPosition().lng();
        var lat2 = currentCords.lat;
        var lng2 = currentCords.lng;
        
        var R = 6371;
        var dLat = deg2rad(lat2 - lat1);
        var dLng = deg2rad(lng2 - lng1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c;
        return distance;
      }

      function deg2rad(deg) {
        return deg * (Math.PI / 180);
      }

      function nextRound() {
        played = false;
        guessButton.innerText = "Guess Now";
        document.getElementById("pano").style.display = "block";
        document.getElementById("map-container").style.width = "350px";
        document.getElementById("map-container").style.height = "250px";
        document.getElementById("map-container").style.bottom = "60px";
        document.getElementById("map-container").style.right = "20px";
        document.getElementById("map-container").style.borderRadius = "8px";

        if (guessMarker) {
          guessMarker.setMap(null);
        }
        if (targetMarker) {
          targetMarker.setMap(null);
        }
        if (linePath) {
          linePath.setMap(null);
        }

        initialize();
      }

      function initializeMapEvents() {
      // Mouseover event to increase map size only when the game is not being played
      document.getElementById("map-container").addEventListener("mouseover", function() {
          if (!played) {
              document.getElementById("map-container").style.width = "700px";
              document.getElementById("map-container").style.height = "500px";
          }
      });

      // Mouseout event to revert map size only when the game is not being played
      document.getElementById("map-container").addEventListener("mouseout", function() {
          if (!played) {
              document.getElementById("map-container").style.width = "350px";
              document.getElementById("map-container").style.height = "250px";
          }
      });
      }

      function initialize() {
        currentLocation = locations[Math.floor(Math.random() * locations.length)];
        currentCords = currentLocation[0];
        currentCity = currentLocation[1].city;

        const panoramaOptions = {
          position: currentCords,
          pov: {
            heading: 10,
            pitch: 5,
          },
          linksControl: false,
          panControl: false,
          enableCloseButton: false,
          addressControl: false,
          zoomControl: false,
          showRoadLabels: false,
        };

        if (!panorama) {
          panorama = new google.maps.StreetViewPanorama(
            document.getElementById("pano"),
            panoramaOptions
          );
        } else {
          panorama.setOptions(panoramaOptions);
        }

        const mapOptions = {
          center: { lat: 1.8069978668338413
              , lng: -160.57186954768204 },
          zoom: 1,
          mapTypeControl: false,
          streetViewControl: false,
          minZoom: 1,
          restriction: {
            latLngBounds: {
              north: 80,
              south: -80,
              east: 180,
              west: -180,
            }
          }
        };

        if (!map) {
          map = new google.maps.Map(
            document.getElementById("map"),
            mapOptions
          );
        } else {
          map.setOptions(mapOptions);
        }

        guessButton = document.getElementById("guessButton");
        guessButton.style.display = "block";
        guessButton.innerText ="Guess Now";
          guessButton.onclick = function () {
          if (played === false) {
              revealTarget();
          } else {
              nextRound();
          }
          };

          map.addListener("dblclick", (mapsMouseEvent) => {
      if (played === true) {
        return;
      }

      if (guessMarker) {
        guessMarker.setMap(null);
      }

      guessMarker = new google.maps.Marker({
        position: mapsMouseEvent.latLng,
        title: "Guessed here",
        map: map
      });
    });

    initializeMapEvents();

  }

  function revealTarget() {
    if (!guessMarker) {
      alert("Please make a guess first!");
      return;
    }

    const image = {
      url: "target.png",
      scaledSize: new google.maps.Size(10, 10), 
    };

    targetMarker = new google.maps.Marker({
      position: currentCords,
      title: currentCity,
      draggable: false,
      icon: image,
      map: map
    });

    // Calculate distance
  distance = checkDistance();
  console.log('Distance calculated:', distance);

  // Calculate score based on distance
  const sigma=250;
  score = 1000 * Math.exp(-0.5 * (distance / sigma) ** 2);
  console.log('Score calculated:', score);

  // Update user statistics in the database
  updateStatistics(score);
  console.log('User statistics updated');

  // Display info window
  const infoWindowContent = "Your target was " + currentCity + "<br>You were " + distance.toFixed(1) + " km away" + "<br>Your score for this round: " + score.toFixed(2);
  const infowindow = new google.maps.InfoWindow({
    content: infoWindowContent,
  });
  console.log('Info window displayed');


    infowindow.open(map, targetMarker);

    const lineCoordinates = [
      currentCords,
      guessMarker.getPosition(),
    ];

    linePath = new google.maps.Polyline({
      path: lineCoordinates,
      geodesic: false,
      strokeColor: "#FF0000",
      strokeOpacity: 1.0,
      strokeWeight: 2,
      map: map
    });

    played = true;
    guessButton.innerText = "Next Round";
    document.getElementById("pano").style.display = "none";
    document.getElementById("map-container").style.width = "100%";
    document.getElementById("map-container").style.height = "100%";
    document.getElementById("map-container").style.bottom = "50px";
    document.getElementById("map-container").style.right = "0";
    document.getElementById("map-container").style.borderRadius = "0";

    document.getElementById("map-container").style.width = "100%";
    document.getElementById("map-container").style.height = "100%";
    document.getElementById("map-container").style.bottom = "50px";
    document.getElementById("map-container").style.right = "0";
    document.getElementById("map-container").style.borderRadius = "0";
  }

  function updateStatistics(score) {
    // Update roundsplayed, totalscore, avgscore, and bestscore in the database
    fetch('update_statistics.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        score: score,
      }),
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
    })
    .catch((error) => {
      console.error('Error:', error);
    });
  }

  window.onload = function () {
    const mapContainer = document.createElement("div");
    mapContainer.id = "map-container";
    mapContainer.innerHTML = `
      <div class="top-bar">
        <div class="home-button" onclick="window.location.href='main_page.php'"></div>
        <div class="realname-label"><?php echo $realname; ?></div>
      </div>
      <div id="map"></div>
      <button id="guessButton">Guess Now</button>
    `;
    document.body.appendChild(mapContainer);
    initialize();
  };
    </script>


  </head>
  <body>
    <div id="pano"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initialize&libraries=geometry,drawing,places&v=weekly" async></script>
  </body>
  </html>
