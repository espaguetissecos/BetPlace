<?php
require("class.php"); 
session_start(); //initiate / open session 
?>
<!DOCTYPE html>
<html><head>
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
				<div id = "logged"><?php print_r($_COOKIE[$cookie_name]) ?>
					<div id="photo"></div> 
					<?php if (isset($_SESSION['carrito'])) { ?>
							<div id="carro" onclick="location.href='carrito.php'"> </div>
					<?php } ?>
				</div>
			<?php
			}
			?>
		</div>

	<div id = "nav_der">
		<form id="searchform">
			<input id="buscar" type="text" placeholder="Buscar..." required>
			<button id = "boton_buscar" type="submit" onclick="location.href='error-guest.php';">Buscar </button>

			<select id = "desplegable" name="Categoria"> 
				  <option value="Futbol">Fútbol</option>
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
			<br>
			<?php
			$custom_id = $_COOKIE["userid"];
			$result_saldo = pg_query("SELECT credit FROM customers WHERE customerid= $custom_id ;");
			$row_s = pg_fetch_row($result_saldo);
			?>
			Saldo actual: <?php echo $row_s[0]?>
			<br>
			<form method="post" action="anadirDineroprocess.php">
			   Saldo a añadir: <input class="registro" type="number" name="saldo" placeholder="Saldo" required>
			   <br>

			   <center><input type="submit" name="submit" value="Añadir"></center>
			</form>
			</p>
			</div>
          </div>
      </div>
    </div>
  </body>
</html>
