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
	  <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Leer el parámetro aviso de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const aviso = urlParams.get('aviso');

            // Mostrar un alerta basada en el aviso
            switch (aviso) {
                case 'comentario_publicado':
                    window.alert('Comentario publicado correctamente.');
                    break;
                case 'error_publicacion':
                    window.alert('Error al publicar el comentario.');
                    break;
                case 'no_autenticado':
                    window.alert('Debes iniciar sesión para comentar.');
                    break;
                // Agrega más casos según sea necesario
            }
        });
    </script>
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
	<main>
		<div id="wrapper">
			<?php
				include("../apartadosPhp/conexion_bd.php");
     			$query = "SELECT a.ID, a.Img, a.Titulo, a.subtitulo, b.usuario, a.Fecha, a.Comentario1, a.img2, a.Comentario2, a.pieEntrada FROM contenido a 
     			INNER Join usuarios b on b.id = a.creador WHERE a.Id = " . $_GET['id'] . "";
                              $resultado = $conexion -> query($query);
                              while ($row = $resultado->fetch_assoc()){
     		?>
			<div class="contenido">	
	     		<p class="fecha"><?php echo $row['Fecha'] ?></p>
	     		<h2 class="titulo">
	     			<?php echo $row['Titulo'] ?>
	     		</h2>
	     		<h3 class="subtitulo2">
	     			<?php echo $row['subtitulo'] ?>
	     		</h3>
	     		<div class="imgBlog">
	     			<img src="../img/entradas/<?php echo $row['Img'] ?>" alt="img">
	     		</div>
	     		<p class="informacion"><?php echo $row['Comentario1'] ?></p>
	     		<div class="imgBlog">
	     			<img src="../img/entradas/<?php echo $row['img2'] ?>" alt="img">
	     		</div>
	     		<p class="informacion"><?php echo $row['Comentario2'] ?></p>
	     		<p class="pieEntrada"><?php echo $row['pieEntrada'] ?></p>
	     		<p class="creadro">Blog Subido por: <a href="mostrarPerfil.php?perfil=<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></p>
			</div>
			<?php 
				}
			?>
			
			<div class="usuariosComent">
				<div id="comentariosBlog">
					<h2>Deja un comentario</h2>
					<form action="../apartadosPhp/procesar_comentario.php" method="post">

						<label for="comentario" type="hidden"></label>
						<textarea name="comentario" rows="4" required></textarea>

						<!-- Cambio en el campo oculto para incluir la ID del contenido -->
						<input type="hidden" name="contenido_id" value="<?php echo $_GET['id']; ?>">
						
						<button type="submit">Comentar</button>
					</form>
				</div>
				<!-- Mostrar comentarios -->
				<?php
					// Incluir el archivo de conexión
					include '../apartadosPHP/conexion_bd.php';

					// Obtener el valor de 'id' desde la URL
					if (isset($_GET['id'])) {
						// Sanitizar el ID para prevenir SQL Injection
						$contenido_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

						// Consultar comentarios para el contenido específico usando sentencia preparada
						$stmt = $conexion->prepare("SELECT c.*, u.usuario, u.fotoPerfil
													FROM comentarios c
													INNER JOIN usuarios u ON c.usuario = u.id
													WHERE c.contenido = ?
													ORDER BY c.fecha DESC");
						$stmt->bind_param("i", $contenido_id);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							echo "<div id='mostrarComentarios'>";
							echo "<h2>Comentarios</h2>";

							while ($row = $result->fetch_assoc()) {
								echo "<div class='comentario'>";
								echo "<div class='hComent'>";
								echo "<div class='usuario'><img src='../img/avatares/{$row['fotoPerfil']}' alt='Foto de perfil'><a href='mostrarPerfil.php?perfil={$row['usuario']}'>{$row['usuario']}</a></div> <h4 class='fecha'>{$row['fecha']}</h4>";
								echo "</div>";
								echo "<p>{$row['comentario']}</p>";
								echo "</div>";
							}

							echo "</div>";
						} else {
							echo "<div id='mostrarComentarios'><p>No hay comentarios aún.</p></div>";
						}
					} else {
						echo "<p>No se proporcionó un ID de contenido válido.</p>";
					}
				?>

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