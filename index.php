<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>
  	<head>
		<meta charset="utf-8">
		<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="./style.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
		<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<script src="./index.js"></script>
  	</head>
  	<body>

  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand">Midway</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
			<a class="nav-item nav-link active" href="index.php">Domov</a>
			<a class="nav-item nav-link" href="prevoz.php">Dodaj prevoz</a>
			<a class="nav-item nav-link" href="rezervacije.php">Rezervacije</a>
			<a class="nav-item nav-link" href="mojiprevozi.php">Moji prevozi</a>
			<a class="nav-item nav-link" href="index.php?logout='1'" style="color:red">Logout</a>
			</div>
		</div>
	</nav>


	<div id="floating-panel" class="col-4">
      <input id="hide-markers" class="btn" type="button" value="Hide Markers" />
	  <input id="show-markers" class="btn" type="button" value="Show Markers" />
    </div>


	<div id="map"></div>

	<script>
  		var a=[];
		var b=[];
		var ali=false;

  		function shraniIz(lat, long){
			a=[];
			a.push(lat);
			a.push(long);
			ali=true;
		}

		function shraniKam(lat, long){
			b=[]
			b.push(lat);
			b.push(long);
			if(ali){
				pot(a,b);
			}
		}


		function narisi(iz, kam){

			let izLat;
			let izLong;
			let kamLat;
			let kamLong;

			var geocoder = new google.maps.Geocoder();
        	geocoder.geocode({ 'address': iz, 'region': 'si' }, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					izLat = results[0].geometry.location.lat();
					izLong = results[0].geometry.location.lng();
					
				} else {

				}
				shraniIz(izLat, izLong);
				

        	});

			geocoder.geocode({ 'address': kam }, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					kamLat = results[0].geometry.location.lat();
					kamLong = results[0].geometry.location.lng();
					
				} else {

				}
				shraniKam(kamLat, kamLong);
        	})

			/*const directionsService = new google.maps.DirectionsService();
  			const directionsRenderer = new google.maps.DirectionsRenderer();

			directionsService.route({
			origin: {
				query: iz,
			},
			destination: {
				query: kam,
			},
			travelMode: google.maps.TravelMode.DRIVING,
			})
			.then((response) => {
			directionsRenderer.setDirections(response);
			})
			.catch((e) => window.alert("Directions request failed due to " + status));*/

		}




		function pot(a,b){
			//console.log(a);
			//console.log(b);

		
			const flightPlanCoordinates = [
				{ lat: a[0], lng: a[1] },
				{ lat: b[0], lng: b[1] },
			];

			const flightPath = new google.maps.Polyline({
				path: flightPlanCoordinates,
				geodesic: true,
				strokeColor: "#FF0000",
				strokeOpacity: 1.0,
				strokeWeight: 2,
			});

			flightPath.setMap(map);
		}



	</script>


	<div class="okoliTabele" style="overflow-x: auto;">
	

  		<div class="table">
	  	<!--div id="meni" class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Vožnje
			</button>

			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton"-->

	  		<?php

				$servername = "localhost";
				$username = "root";
				$password = "";

				try {
					$conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $ime=$_SESSION['username'];
                    $sql = "SELECT uporabnikid FROM uporabnik WHERE username='$ime'";
                    $stmt = $conn->prepare($sql);
				    $stmt->execute();
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $uporabnikIzpis=$result;

					
				} catch(PDOException $e) {
					echo $sql . "<br>" . $e->getMessage();
				}


				try {
					$conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


					if(isset($_POST['prostorbrisanje'], $_POST['idbrisanje'])){
						
						$prostorbrisanje=$_POST['prostorbrisanje'];

						$idbrisanje=(int)$_POST['idbrisanje'];


						
						
							
						
						if($prostorbrisanje==1){
							$sql="DELETE FROM prevozi WHERE idprevozi=$idbrisanje";
							$conn->exec($sql);
						} 

						if($prostorbrisanje>1){
							$prostorbrisanje=$prostorbrisanje-1;
							$sql="UPDATE `prevozi` SET `prostor` = $prostorbrisanje WHERE `idprevozi` = $idbrisanje";
							$stmt = $conn->prepare($sql);
							$stmt->execute();
						}

						///////////////////



						$sql = "SELECT znamka, barva, iz, v, cas, uporabnik_uporabnikid FROM prevozi WHERE uporabnik_uporabnikid=$uporabnikIzpis LIMIT 1";

						$stmt = $conn->query($sql);
						//$stmt->execute();

						$result = $stmt->fetch();

						/*echo $result[0];
						echo $result[1];
						echo $result[2];
						echo $result[3];
						echo $result[4];
						echo $result[5];*/

						$sql = "INSERT INTO rezervacije(znamka, barva, iz, v, cas, uporabnik_uporabnikid) VALUES ('$result[0]','$result[1]','$result[2]', '$result[3]', '$result[4]', '$result[5]')";

						$conn->exec($sql);

						/*foreach($stmt->fetchAll() as $k=>$v) {
							

							$vv = implode(";",$v);
							$vv = explode(";",$vv);


							$idprevoz=$vv[0];
							$znamka=$vv[1];
							$barva=$vv[2];
							$iz=$vv[3];
							$kam=$vv[4];
							$cas=$vv[5];
							$uporabnik_uporabnikid=$vv[6];

							echo "delaaaaaaaaaaaaaaaaaaaa";

							$sql = "INSERT INTO rezervacije(znamka, barva, iz, v, cas, uporabnik_uporabnikid) VALUES ('$znamka','$barva','$iz', '$kam', '$cas', $uporabnik_uporabnikid)";

							$conn->exec($sql);
							

						}*/

						//$znamka=$seznam[];


						//////////////////


						//$sql = "INSERT INTO rezervacije(znamka, barva, iz, v, cas, uporabnik_uporabnikid) VALUES ('$znamka','$barva','$iz', '$v', '$cas', $idponudnik)";

						//$conn->exec($sql);


					}

					/*if(isset($_POST['iz'], $_POST['kam'])){
						$risanjeIz=$_POST['iz'];
						$risanjeKam=$_POST['kam'];
						echo "<script>
							function narisi(risanjeIz, risanjeKam){
								console.log('delaaaaaaaaaaaaa');
							}
							narisi('$risanjeIz', '$risanjeKam');

						</script>";
					}*/

					
				} catch(PDOException $e) {
					echo $sql . "<br>" . $e->getMessage();
				}


				try {
				$conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


				$sql = "SELECT idprevozi, znamka, iz, v, prostor, cas, uporabnik_uporabnikid FROM prevozi WHERE prostor>0";

				$stmt = $conn->prepare($sql);
				$stmt->execute();

				echo "<div class='row'>
				
						<div class='cell intr'><i class='fa fa-car'></i>Znamka</div>
						<div class='cell intr'><i class='fas fa-map-signs'></i>Iz lokacije</div>
						<div class='cell intr'><i class='fas fa-location-arrow'></i>Na lokacijo</div>
						<div class='cell intr'><i class='fas fa-chair'></i>Prosta mesta</div>
						<div class='cell intr'><i class='fa fa-clock-o'></i>Čas odhoda</div>
						<div class='cell intr'><i class='fas fa-check'></i>Rezervacija</div>
						<div class='cell intr'><i class='fas fa-edit'></i>Risanje poti</div>
					  
					  </div>";

				$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);


				$result = $stmt->fetchAll();
				//print_r($result[0]["cas"]);


				function date_compare($el1, $el2){
					$el1=strtotime($el1["cas"]);
					$el2=strtotime($el2["cas"]);
					return $el1 - $el2;
				}
				usort($result, 'date_compare');



				foreach($result as $k=>$v) {
					echo "<div class='row'>";
					$pot = "";

					$vv = implode(";",$v);
					$vv = explode(";",$vv);

					$idbrisanje=$vv[0];
					$znamka=$vv[1];
					$iz=$vv[2];
					$kam=$vv[3];
					$prostor=$vv[4];
					$cas=$vv[5];
					$uporabnik_uporabnikid=$vv[6];
					
					$pot = "<div class='cell'><i class='fa fa-car'></i>".$znamka."</div><div class='cell'><i class='fas fa-map-signs'></i>".$iz."</div><div class='cell'><i class='fas fa-location-arrow'></i>".$kam."</div><div class='cell'><i class='fas fa-chair'></i>".$prostor."</div><div class='cell'><i class='fa fa-clock-o'></i>".$cas."</div>";



					$pot = $pot.'<div class="cell"><form method="post">

							<input type="hidden" name="idbrisanje" value="'.$idbrisanje.'"></input>	
							<input type="hidden" name="prostorbrisanje" value="'.$prostor.'"></input>
							<input class="btn" type="submit" value="Rezerviraj prostor"></input>
							</form></div>';


					$pot = $pot.'<div class="cell">
								<button type="button" class="btn" id="risi" onclick="narisi(\''.$iz.'\',\''.$kam.'\')">Nariši pot</button>  
							</div></div>';

					echo $pot;


					/*$sql = "SELECT idponudnik, ime, znamka, barva FROM ponudnik WHERE idponudnik=$vv[5]";
					
					$stmt2 = $conn->prepare($sql);
					$stmt2->execute();
					$result = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
					foreach($stmt2->fetchAll() as $l=>$b) {
					$bb = implode(";",$b);
					$bb = explode(";",$bb);

						for($j=1;$j<count($bb);$j++){
							$pot = "$pot".", "."$bb[$j]";
						}

					$bid=$bb[0];*/

					

				}
			


				} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
				}

	  		?>


			
		</div>

			<!--/div>
	  
		</div-->
		
	</div>




		
		
		<script
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu01p6HUScvtSVttrouq7hjDTShktANS4&libraries=places&callback=initMap&v=weekly"
			async
		></script>

	
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  	</body>
</html>
