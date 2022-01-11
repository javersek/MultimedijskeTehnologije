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
			<a class="nav-item nav-link" href="index.php">Domov</a>
			<a class="nav-item nav-link" href="prevoz.php">Dodaj prevoz</a>
			<a class="nav-item nav-link" href="rezervacije.php">Rezervacije</a>
			<a class="nav-item nav-link active" href="mojiprevozi.php">Moji prevozi</a>
			<a class="nav-item nav-link" href="index.php?logout='1'" style="color:red">Logout</a>
			</div>
		</div>
	</nav>




	
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
					if(isset($_POST['idbrisanje'])){

						$idbrisanje=(int)$_POST['idbrisanje'];

						
						$sql="DELETE FROM prevozi WHERE idprevozi=$idbrisanje";
						$conn->exec($sql);
						

					}

					
				} catch(PDOException $e) {
					echo $sql . "<br>" . $e->getMessage();
				}


				try {
				$conn = new PDO("mysql:host=$servername;dbname=mydb", $username, $password);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);






				$sql = "SELECT idprevozi, znamka, iz, v, prostor, cas, uporabnik_uporabnikid FROM prevozi WHERE prostor>0 AND uporabnik_uporabnikid=$uporabnikIzpis";

				$stmt = $conn->prepare($sql);
				$stmt->execute();

				echo "<div class='row'>
				
						<div class='cell intr'><i class='fa fa-car'></i>Znamka</div>
						<div class='cell intr'><i class='fas fa-map-signs'></i>Iz lokacije</div>
						<div class='cell intr'><i class='fas fa-location-arrow'></i>Na lokacijo</div>
						<div class='cell intr'><i class='fas fa-chair'></i>Prosta mesta</div>
						<div class='cell intr'><i class='fa fa-clock-o'></i>Čas odhoda</div>
                        <div class='cell intr'><i class='fas fa-trash'></i>Brisanje</div>
					  
					  </div>";

				$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				foreach($stmt->fetchAll() as $k=>$v) {
					
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
					
                    if($uporabnikIzpis==$uporabnik_uporabnikid){
                        echo "<div class='row'>";


                        $pot = "<div class='cell'><i class='fa fa-car'></i>".$znamka."</div><div class='cell'><i class='fas fa-map-signs'></i>".$iz."</div><div class='cell'><i class='fas fa-location-arrow'></i>".$kam."</div><div class='cell'><i class='fas fa-chair'></i>".$prostor."</div><div class='cell'><i class='fa fa-clock-o'></i>".$cas."</div>";



                        $pot = $pot.'<div class="cell"><form method="post">

                                <input type="hidden" name="idbrisanje" value="'.$idbrisanje.'"></input>	
                                <input class="btn" type="submit" value="Izbriši"></input>
                                </form></div>';

                        /*
                        $pot = $pot.'<div class="cell">
                                    <button type="button" class="btn" id="risi" onclick="narisi(\''.$iz.'\',\''.$kam.'\')">Nariši pot</button>  
                                </div>';*/

                        echo $pot;

                        echo "</div>";
                    }
					

				}
			


				} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
				}

	  		?>


			
		</div>

			<!--/div>
	  
		</div-->
		
	</div>

	
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  	</body>
</html>
