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
		<script
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu01p6HUScvtSVttrouq7hjDTShktANS4&sensor=false&libraries=places"
		></script>
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
			<a class="nav-item nav-link" href="index.php">Domov</a>
			<a class="nav-item nav-link active" href="prevoz.php">Dodaj prevoz</a>
			<a class="nav-item nav-link" href="rezervacije.php">Rezervacije</a>
			<a class="nav-item nav-link" href="mojiprevozi.php">Moji prevozi</a>
			<a class="nav-item nav-link" href="index.php?logout='1'" style="color:red">Logout</a>
			</div>
		</div>
	</nav>


  		




		<div class="loginOkno col-4 shadow p-3 mb-5 bg-white rounded">



			<?php

				if(isset($_POST['ime'], $_POST['znamka'], $_POST['barva'], $_POST['prostor'], $_POST['iz'], $_POST['v'], $_POST['cas'])){

					$ime=$_POST['ime'];
					$znamka=$_POST['znamka'];
					$barva=$_POST['barva'];

					$prostor=$_POST['prostor'];
					$iz=$_POST['iz'];
					$v=$_POST['v'];
					$cas=$_POST['cas'];

					$servername = "localhost";
					$username = "root";
					$password = "";

					try {
					$conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


					$stmt = $conn->prepare("SELECT uporabnikid FROM uporabnik WHERE username='$ime'");
					$stmt->execute();

					// set the resulting array to associative
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

					$idponudnik=$result;
					

					$sql = "INSERT INTO prevozi(barva, znamka, iz, v, prostor, cas, uporabnik_uporabnikid) VALUES ('$barva','$znamka','$iz', '$v', $prostor, '$cas', $idponudnik)";

					$conn->exec($sql);
					header("Refresh:0");

					}catch(PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
					}


				}

			?>

		

			<form method="post">
				<input type="hidden" name="ime" value="<?php echo $_SESSION['username']; ?>"><br>
				<label>Znamka:</label><br>
				<input type="text" name="znamka" required><br>
				<label>Barva:</label><br>
				<input type="text" name="barva" required><br>
				<label>Prostor:</label><br>
				<input type="number" min="1" name="prostor" required><br>
				<label>Iz:</label><br>
				<input type="text" name="iz" id="iz" required><br>
				<label>V:</label><br>
				<input type="text" name="v" id="v" required><br>
				<label>Čas:</label><br>
				<input type="datetime-local" name="cas" required><br>
				<br>
				<input type="submit" value="Dodaj">
			</form> 



			<script>
				function initialize() {
					var input = document.getElementById('iz');
					const options = {
						componentRestrictions: {country: "si"},
					}
					new google.maps.places.Autocomplete(input, options);
				}

				google.maps.event.addDomListener(window, 'load', initialize);


				function initialize2() {
					var input = document.getElementById('v');
					const options = {
						componentRestrictions: {country: "si"},
					}
					new google.maps.places.Autocomplete(input, options);
				}

				google.maps.event.addDomListener(window, 'load', initialize2);
			</script>




		</div>


	 	
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  	</body>
</html>
