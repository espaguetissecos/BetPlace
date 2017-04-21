<?php
require("class.php"); 
session_start(); //initiate / open session 
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>BetPlace, tu sitio de apuestas deportivas</title>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
      
    <script type="text/javascript">//<![CDATA[ 
    $(window).load(function(){
      $("[data-toggle]").click(function() {
        var toggle_el = $(this).data("toggle");
        $(toggle_el).toggleClass("open-sidebar");
      });
    });//]]>  
    
    </script>

<script>
	 window.onload = startInterval;

	 
	 function startInterval() {
	    setInterval(ajaxcall, 1000);
	 }
	 
	 function ajaxcall(){

	    var xmlhttp;
	    xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			data = xmlhttp.responseText;
   			data = data.split(":");
		    document.getElementById('hours').innerHTML = data[0];
		    document.getElementById('minutes').innerHTML = data[1];
		    document.getElementById('seconds').innerHTML = data[2];
		    document.getElementById('random').innerHTML = Math.floor(Math.random() * (500 - 200)) + 200;		    
		}
	    }
	    xmlhttp.open("GET", "gettime.php", true);
	    xmlhttp.send();
	 }
	</script>
	

</head>

<body>

		<div id = "header">
			<div id= "logo">
				<p2><a href="index.php"> BetPlace </a><div class="circle"></div> </p2>
			</div>
			<?php 
			$cookie_name = "user";
			if (isset($_COOKIE[$cookie_name]) && isset($_GET['logout'])){
				setcookie($cookie_name, $_COOKIE[$cookie_name], time() - 3600, "/");
				unset($_COOKIE[$cookie_name]);
			}elseif(isset($_COOKIE[$cookie_name])){ ?>
				<div id = "logged"><?php print_r($_COOKIE[$cookie_name]) ?><div id="photo"></div></div>
			<?php
			}
			?>
		</div>

	<div id = "nav_der">
		<form id="searchform" method="post" action="busqueda.php">
			<input id="buscar" name= "buscar" type="text" placeholder="Buscar...">
			<button id = "boton_buscar" type="submit">Buscar</button>
			<select id = "desplegable" name="categoria">			
				  <option value="Futbol" selected>Fútbol</option>
				  <option value="Baloncesto">Baloncesto</option>
				  <option value="Balonmano">Balonmano</option>
				  <option value="Otros">Otros</option>
			</select>
		</form>
		<br>
		<ul>
		<?php
		if(isset($_COOKIE[$cookie_name])){ ?>
			<li><a href="historial.php">Historial</a>
			<li><a href="anadirDinero.php">Añadir Saldo</a>
			<li><a href="index.php?logout">Desconectarse</a>
		<?php
		}else{ ?>
			<li><a href="login.php">Login</a>
			<li><a href="registrar.php">Registrarse</a>
			<li><a href="carrito.php">Carrito Invitado</a>				
		<?php
		}
		?>
		</ul>
	</div>


	<footer>Copyright © BetPlace 
		<div id = "fecha">
			Hora: <span id="hours">0</span>:<span id="minutes">0</span>:<span id="seconds">0</span> <br>
			Fecha: <?php echo date('m/d/Y a', time()) ?> <br>
		</div>
		<div id = "usuarios">			
			Usuarios en linea: <span id="random">0</span>
		</div>
	</footer>

    <div class="container">
      <div id="nav_izda">
          <ul name= "lista">
	         <?php    	        
	        	 
          	$apuestas2 = pg_connect("host=localhost dbname=si1 user=alumnodb password=alumnodb");

		$result = pg_query("SELECT * FROM bets");
		while ($row = pg_fetch_row($result))
			{
				?> <li><a href=<?php echo "apuestadetalle.php?categ=" . $row[2] . "&id=". $row[0]  . "&desc=" . $row[3] ?> > <?php echo $row[3] ?>  </a></li><?php
			}
			?>

	</ul>

      </div>
      <div class="main-content">
          <a href="#" data-toggle=".container" id="nav_izda-boton">
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
          </a>
          <div class="content">
          	<h1>BetPlace</h1>
			<div id = "cuadro_registro">
			<p>
			<?php
				if(!isset($_COOKIE[$cookie_name])){
					echo "<a href=registrar.php>No estás registrado. Pulsa aquí para registrarte.</a> <br>";
					echo "<a href=login.php>Si ya te has registrado, pulsa aquí para loguearte.</a>";
				}
				else{
						$userid= $_COOKIE["userid"];
						$credit = pg_fetch_row(pg_query("SELECT * FROM customers WHERE customerid= $userid"))[18];

						$coste = 0;

						foreach($_SESSION["carrito"]->apuestas as $partido){
							$coste = $coste + $partido->bet; 
						} 

						if ((int)$credit < $coste) {
							printf("No tienes saldo suficiente en la cuenta.\n Pago no procedido, volviendo...");
							?><meta http-equiv="refresh" content="3;url=index.php"><?php
			
						}
						$result = pg_query("INSERT INTO clientorders (customerid, totaloutcome, totalamount) VALUES ($userid, 0, 0)");
						$seq = pg_fetch_row(pg_query("SELECT last_value FROM clientorders_id_seq"))[0];
						
						foreach($_SESSION["carrito"]->apuestas as $partido){
							$result = pg_query("INSERT INTO clientbets (customerid, optionid, bet, ratio, outcome, betid, orderid) VALUES ($partido->customerid, $partido->optionid, $partido->bet, $partido->ratio, $partido->outcome, $partido->betid, $seq);");
						} 
						
						pg_query("UPDATE clientorders SET date=CURRENT_TIMESTAMP WHERE orderid=$seq");
						echo "pago confirmado, suerte!";
						unset($_SESSION['carrito']);
						session_destroy(); 


			}

			?>
			<meta http-equiv="refresh" content="5;url=index.php">
			
			</p>
			</div>
          </div>
      </div>
    </div>
    </body>
</html>
