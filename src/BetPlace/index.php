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

<?php
    $apuestas= simplexml_load_file('apuestas.xml');
    
?>


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
				unset($_COOKIE["userid"]);
				session_destroy();
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
              <p>La página de apuestas BetPlace te espera para hacer apuestas sobre cualquier evento deportivo.<br>
		Aquí podrás realizar las apuestas sobre tus equipos favoritos.<br><br>
		Una muestra de Lipsum nos muestra el correcto funcionamiento del scroll en la página, sin alterar ni el pie
		de página ni las columnas laterales ni el encabezado.<br><br><br><br>

		 <i>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In viverra massa vel neque gravida, blandit dignissim orci efficitur. Nam iaculis diam vitae mi tincidunt pellentesque. Curabitur odio erat, viverra ac blandit id, bibendum sit amet arcu. Morbi commodo sed libero eu posuere. Mauris dui eros, facilisis quis vulputate non, viverra quis magna. Etiam iaculis congue orci, eget pulvinar ex. Ut sagittis est massa, sed gravida odio aliquam sed. Ut et augue at ipsum viverra tempor.<br>

		Nullam eleifend tortor eu pharetra ultricies. Nunc lobortis dictum viverra. Phasellus viverra ac risus non eleifend. Sed sit amet maximus justo, non varius risus. Vivamus congue quis lacus pharetra lacinia. Sed non gravida turpis. Maecenas nec quam ac nisl ultrices suscipit. Vivamus pretium vehicula nulla, eget luctus purus posuere euismod. Vivamus porttitor nulla non nunc laoreet, vitae lobortis tortor interdum. Donec faucibus lacinia tincidunt. Ut ex enim, mollis iaculis ultrices nec, fermentum vitae tellus. Integer placerat nunc ac tellus consequat, eget lacinia est accumsan. Nullam vehicula viverra ex, at euismod nisl dapibus ut. Nullam nisl nulla, varius et mauris ac, rhoncus sodales purus. Suspendisse vel hendrerit enim.<br>

		Integer ut placerat mi. Quisque pulvinar justo lacus, non commodo sapien eleifend non. Pellentesque at massa nulla. Donec euismod convallis nisl. In bibendum metus in tempor feugiat. Proin nibh mauris, laoreet sed mauris id, rutrum mattis ipsum. Suspendisse ullamcorper arcu massa, vel efficitur eros cursus vitae. Donec in orci in felis porttitor tempor. Phasellus vestibulum ligula urna, vitae congue justo finibus a. Duis ut convallis eros, non viverra ipsum. Vivamus sit amet ipsum sodales, vestibulum diam non, ullamcorper ex. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc et leo lorem. Donec laoreet ultricies vestibulum. Etiam aliquet nulla erat, at mollis justo pulvinar nec.<br>

		Mauris augue massa, feugiat semper vulputate ullamcorper, dapibus non eros. Vivamus laoreet odio eu pretium laoreet. Aenean at felis vel velit fermentum dictum sit amet non erat. Fusce condimentum maximus est et elementum. Sed sagittis laoreet nisi, vel rutrum libero. Nunc vel porta ex, a finibus risus. Quisque ac metus eu justo vulputate rutrum. In tincidunt mauris justo, eget feugiat arcu porta nec. Etiam pretium euismod velit ut dignissim. Nulla sit amet dui vulputate, pharetra sapien eu, tincidunt mauris.<br>

		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam in feugiat velit, sit amet lobortis risus. Nam hendrerit scelerisque ex faucibus venenatis. Curabitur gravida dictum venenatis. Quisque mollis varius nisl, sed accumsan mi semper eget. Phasellus sed sapien dui. Quisque sodales pretium dolor id rhoncus. Integer vel mi dignissim, maximus lorem et, dapibus ipsum. Proin consequat gravida risus at rhoncus. Nullam et ipsum magna. Proin commodo sodales dui, vel rhoncus dolor sagittis ut. Maecenas id arcu diam. Quisque feugiat, risus porttitor iaculis hendrerit, magna nibh auctor tellus, non blandit quam sem et ligula. Pellentesque tristique dictum eleifend.<br>

		Aenean placerat, augue ac laoreet porttitor, lorem sem vulputate urna, a porta justo lorem eget ipsum. Nunc molestie dignissim metus eget aliquam. Duis id dignissim nibh. Phasellus in mollis tellus. Sed sit amet nunc lorem. Etiam in congue dui. Maecenas eu arcu diam. In fermentum massa nec quam tincidunt tincidunt. Nulla fermentum dolor nec diam faucibus finibus. Aliquam aliquam urna erat, at ornare tellus rhoncus non. Ut sit amet arcu in ante porta maximus.</i><br>		
	      </p>
          </div>
      </div>
    </div>
  </body>
</html>
