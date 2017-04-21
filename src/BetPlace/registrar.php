<?php
require("class.php"); 
session_start(); //initiate / open session 
?>

<!DOCTYPE html>
<html><head>
  <link rel="stylesheet" type="text/css" href="style.css">

  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>BetPlace, tu sitio de apuestas deportivas</title>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
      
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


    <script>
function passwordStrength(password)
{
	var desc = new Array();
	desc[0] = "Muy débil";
	desc[1] = "Débil";
	desc[2] = "Leve";
	desc[3] = "Medio";
	desc[4] = "Difícil";
	desc[5] = "Muy difícil";

	var score   = 0;

	//if password bigger than 6 give 1 point
	if (password.length > 6) score++;

	//if password has both lower and uppercase characters give 1 point	
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

	//if password has at least one number give 1 point
	if (password.match(/\d+/)) score++;

	//if password has at least one special caracther give 1 point
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

	//if password bigger than 12 give another 1 point
	if (password.length > 12) score++;

	 document.getElementById("passwordDescription").innerHTML = desc[score];
	 document.getElementById("passwordStrength").className = "strength" + score;
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
			<form method="post" action="registro.php">

			   Nombre: <input class="registro" type="text" name="nombre" placeholder="Nombre" required>
			   <br>
			   Apellidos: <input class="registro" type="text" name="apellidos" placeholder="Apellidos" required>
			   <br><br>
			   Dirección 1: <input class="registro" type="text" name="direccion1" placeholder="Direccion 1" required>
			   <br>
			   Dirección 2: <input class="registro" type="text" name="direccion2" placeholder="Direccion 2" required>
			   <br><br>
			   Ciudad: <input class="registro" type="text" name="ciudad" placeholder="Ciudad" required>
			   <br>
			   Codigo Postal: <input class="registro" type="text" name="zip" placeholder="Codigo postal" required>
			   <br>
			   Comunidad Autonoma: <input class="registro" type="text" name="region" placeholder="Region" required>
			   <br>	
			   Pais: <input class="registro" type="text" name="pais" placeholder="Pais" required>
			   <br><br>
			   Username:  <input class="registro" type="text" name="name" placeholder="Nombre de usuario" required><br>

			   Contraseña: <input class="registro" type="password" name="password" id="pass" onkeyup="passwordStrength(this.value)" placeholder="Contraseña" required><br>
			   Confirmar: <input class="registro" type="password" name="password2" placeholder="Confirmar contraseña" required><br>
			   Seguridad de la contraseña: <div id="passwordDescription">No se ha introducido contraseña.</div>

			   Numero de tarjeta: <input class="registro" type="text" name="card" placeholder="Numero de tarjeta" required>
			   <br>
			   Tipo de tarjeta: <input class="registro" type="text" name="typecard" placeholder="Tipo de tarjeta" required>
			   <br>			   
			   Fecha de vencimiento: <input class="registro" type="text" name="caducidad" placeholder="Caducidad" min="1" max="12"required><br>

			   Saldo inicial: <input class="registro" type="number" name="saldo" min="0" placeholder="Euros" required><br><br>
			   <center><input type="submit" name="submit" value="Registrarse"></center>
			</form>
			</p>
			</div>
          </div>
      </div>
    </div>
  </body>
</html>
