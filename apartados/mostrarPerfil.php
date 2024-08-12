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
	<title>Join Game | Blog </title>
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
	<main id="perfiles">
		<div class="columnas">
			<div class="perfil">
				<?php
					include '../apartadosPhp/conexion_bd.php';

					// Obtener el nombre de usuario desde la URL
					$perfil_usuario = isset($_GET['perfil']) ? $_GET['perfil'] : null;

					if ($perfil_usuario) {
						// Consultar información del usuario específico
						$sql_usuario = "SELECT * FROM usuarios WHERE usuario = '$perfil_usuario'";
						$resultado_usuario = $conexion->query($sql_usuario);

						if ($resultado_usuario->num_rows > 0) {
							$usuario = $resultado_usuario->fetch_assoc();
							?>
							<div class="imgNombre">
								<img src="../img/avatares/<?php echo "{$usuario['fotoPerfil']}" ?>" alt="imagen de Perfil">
								<p class="nombre"><?php echo "{$usuario['usuario']}"?></p>
							</div>
							<div class="datos">
								<h3> Datos del usuario</h3>
								<ul>
									<li>Nickname: <p class="nombre"><?php echo "{$usuario['usuario']}"?></p></li>
									<li>Cumpleaños: <p class="nombre"><?php echo "{$usuario['nacimiento']}"?></p></li>
									<li>Sexo: <p class="nombre"><?php echo "{$usuario['sexo']}"?></p></li>
								</ul>
							</div>
			</div>
			<div class="editar">
				<?php
					// Consultar posts del usuario
					$sql_posts = "SELECT * FROM contenido WHERE creador = {$usuario['id']} ORDER BY Fecha DESC";
					$resultado_posts = $conexion->query($sql_posts);

						if ($resultado_posts->num_rows > 0) {
							echo "<h5 class='editarPerfil'>Publicaciones recientes:</h5>";
							
							while ($post = $resultado_posts->fetch_assoc()) {
								// Verificar si la clave 'ID' existe en el array $post
								$id_post = isset($post['Id']) ? $post['Id'] : null;
							?>
								<div class="prevpublicaciones">
									<div class="img">	
										<img class="imgEntrada" src="../img/entradas/<?php echo $post ['Img']?>" alt="imgEntrada">
									</div>
									<div class="detalles">
										<?php echo "<a href='../apartados/blog.php?id=" . $post["Id"] . "' class='blog'><h3>". $post['Titulo'] ."</h3></a>" ?>
										<p class="subtitulo"><?php echo $post['subtitulo'] ?></p>
										<div class="creador_fecha">
											<h5 class="fecha"><?php echo $post['Fecha'] ?></h5>
										</div>
										
										<p class="descripcion"><?php echo $post['Comentario1'] ?></p>
									</div>
								</div>
						<?php
							}
							} else {
								echo "<h5 class='editarPerfil'>El usuario no ha publicado ningún post.</h5>";
							}
						} else {
							echo "<p>No se encontró el perfil del usuario: $perfil_usuario</p>";
						}
					} else {
						echo "<p>No se proporcionó un nombre de usuario válido en la URL</p>";
					}
			
				?>
			</div>
			<div class="publicaciones">
            <h3>ULTIMAS PUBLICACIONES</h3>
            <div class="entradas">
                <?php 
                    $query = "SELECT * FROM contenido LIMIT 9";
                    $resultado = $conexion -> query($query);
                    while ($row = $resultado->fetch_assoc()){
                ?>
                    <p class="recientes"><?php echo "<a href='../apartados/blog.php?id=" . $row["Id"] . "' class='blog'>". $row['Titulo'] ."</a>" ?></p>
                <?php 
                    }
					$conexion->close();
                ?>
            </div>
        </div>
			         
        </div>
		<div>
			
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