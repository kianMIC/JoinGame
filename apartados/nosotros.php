<?php 
	
	session_start();
	if(!isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Join Game</title>
	<link rel="shortcut icon" href="../img/iconos/logo.jpg">
	
	<!-- Links para los css -->
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/main.css">

	<!-- Los diferentes plugins Y JS -->
  	<script src="../js/jquery-3.6.0.min.js"></script>
  	<script src="../js/js.js"></script>
</head>
<body>
	<header>
		<h1><a href="../index.php"><img src="../img/imgGeneral/logo.png" alt="logo"></a></h1>
		<div class="menu">
			<nav class="navegador">
				<ul>
					<li><a href="../index.php" id="selected"></a></li>
					<!-- <li><a href="#">Categorias</a>
						<ul class="navCategoria">
							<li><a href="#">Terror</a></li>
							<li><a href="#">Accion y Aventura</a></li>
							<li><a href="#">Mundo Abierto</a></li>
							<li><a href="#">Retro</a></li>
							<li><a href="#">Metroidvania</a></li>
						</ul>
						
					</li> -->
					<li><a href="#">Nosotros</a></li>
					<li><a href="formulario.php">Registro/Inicio</a></li>
				</ul>
			</nav>
		</div>
		
	</header>
<?php 
	}else{
		include("../apartadosPhp/conexion_bd.php");
		$user = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Join Game | Contactos </title>
	<link rel="shortcut icon" href="../img/iconos/logo.jpg">
	
	<!-- Links para los css -->
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<header>
		<h1><a href="../sessionStart/index.php"><img src="../img/imgGeneral/logo.png" alt="logo"></a></h1>
		<?php 
			$user = $_SESSION['usuario'];
			if ($user['perfil'] === 1){
			    include("../sessionStart/encabezadoAdmin.php");
			}else{
			    include("../sessionStart/encabezadoUsuario.php");
			}
		}
		?>
	</header>
	<main>
		<div class="explicacion">
			<h2 class="titulosNosotros">¿Quienes somos?</h2>
			<p class="detallesNosotros">
				JoinGame es un proyecto realizado por un pequeño grupo de jovenes dispuestos a crear un sitio web diseñado para la comunidad de todo tipo de videojuegos, de momento solo estamos realizando pequeños blogs de noticias y consejos para algunas categorias de juegos, pero poco a poco esperamos que se puda crear una buena base de seguidores para realizar una comunidad activa, ya sea para chatear por medio de nuestro sitio web o incluso para realizar pequeños eventos en distintos juegos para crear una comunidad sana y sustentable.
			</p>
			<p class="detallesNosotros">
				Esperemos JoinGame sea de tu agrado, poco a poco nuestra pagina ira mejorando con el tiempo, espero los cambios realizados sean de su agrado, cualquier duda o sugerencia seran bien recibida por nuestra comunidad de seguidores. 
			</p>
		</div>
		<div class="novedades">
			<h3 class="titulosNosotros">
				las proximas actualizaciones a realizar incluiran los siguientes cambios.
			</h3>
			<ul>
				<li>Listas de favoritos en los perfiles, para volver a ellos de manera mas facil y eficiente.</li>
				<li>Buscador interno para una mejor accesibilidad.</li>
				<li>Blogs especificos para un chat global de temas especificos.</li>
				<li>Sistema de correos para sugerencias.</li>
			</ul>
		</div>
		<div class="informacion">
			<h3 class="titulosNosotros">Contactanos</h3>
			<div class="informacionCont">
				<div class="infImg">
					<img src="../img/imgGeneral/inf1.jfif" alt="inf">
				</div>
				<div class="apartadosInf">
					<div class="divInf">
						<img src="../img/iconos/contacto.png" alt="imgContacto">
						<p class="detallesInf">Contactanos a traves de nuestro E-mail.</p>
						<p class="detallesInf">joinGame@gmail.com</p>
					</div>
					<div class="divInf">
						<img src="../img/iconos/ubicacion.png" alt="imgUbicacion">
						<p class="detallesInf">Pronto abriremos nuestra tienda fisica</p>
						<p class="detallesInf">Estate al pendiente para los eventos programados.</p>
					</div>
					<div class="divInf">
						<p class="detallesTitulo">SIGUENOS</p>
						<p class="detallesInf">Siguenos en nuestras redes sociles.</p>
						<p class="detallesInf">Estaremos hacinedo distintos sorteos.</p>
					</div>
					<div class="divInf">
						<img src="../img/iconos/apoyar.png" alt="imgApoyo">
						<p class="detallesInf">Buscamos gente que nos ayude a sacar el proyecto adelante</p>
						<p class="detallesInf">Ponte en contacto con nosotros, no es requerida la experiencia.</p>
					</div>
				</div>
			</div>
			
		</div>
	</main>
	<footer>
		<h6 class="footer">Por favor, sigueme en mis redes sociales y sitios de entretenimiento para ayudarme a crecer nuestra querida comunidad <3</h6>
		<div class="redes">
			<ul>
				<li><a href="https://www.facebook.com/kian14Oficial"><img src="../img/iconos/facebook.png" alt="Facebook"></img></a></li>
				<li><a href="https://www.instagram.com/kian14_mic/"><img src="../img/iconos/instagram.png" alt="Instagram"></img></a></li>
				<li><a href="https://www.twitch.tv/kian_14_mic"><img src="../img/iconos/twitch.png" alt="Twitch"></img></a></li>
				<li><a href="https://www.youtube.com/channel/UCjoR3qfEIXXoeAd0DU7y9og"><img src="../img/iconos/youtube.png" alt="Youtube"></img></a></li>
			</ul>
		</div>
	</footer>
</body>
</html>