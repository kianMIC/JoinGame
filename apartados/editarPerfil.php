<?php
	include '../apartadosPhp/conexion_bd.php';
	session_start();
	$conexion;

	// Verificar si el usuario está autenticado
	if (!isset($_SESSION['usuario'])) {
		echo '
			<script>
				alert("No puedes acceder a este apartado, debes iniciar sesión primero");
				window.location = "../index.php";
			</script>
		';
		session_destroy();
		die();
	}

	// Obtener el ID del usuario a actualizar desde la sesión
	$id = $_SESSION['usuario']['id'];

	// Verificar si se recibió el ID desde la URL
	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		// Verificar que $id sea un número entero
		if (!filter_var($id, FILTER_VALIDATE_INT)) {
			echo "ID inválido";
			exit();
		}
	}

	// Obtener los datos del usuario a actualizar
	$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$resultado = $stmt->get_result();
	$user = $resultado->fetch_assoc();

	// Verificar si la consulta fue exitosa
	if (!$resultado) {
		echo "Error en la consulta: " . $conexion->error;
		exit();
	}

	// Procesar el formulario de actualización
	if (isset($_POST['actualizar'])) {
		// Obtener los datos del formulario
		$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
		$usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
		$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
		$sexo = mysqli_real_escape_string($conexion, $_POST['sexo']);
		$nacimiento = mysqli_real_escape_string($conexion, $_POST['nacimiento']);

		// Procesar la imagen de perfil
		$nombrea = $user['fotoPerfil'];  // Valor predeterminado
		if (!empty($_FILES['avatar']['name'])) {
			$type = 'jpg';
			$rfoto = $_FILES['avatar']['tmp_name'];
			$name = $id . '.' . $type;

			// Validar el tipo de archivo
			$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
			$file_info = pathinfo($_FILES['avatar']['name']);
			$file_extension = strtolower($file_info['extension']);

			if (in_array($file_extension, $allowed_types)) {
				$nombrea = $name;
				$destino = '../img/avatares/' . $name;

				// Mover el archivo
				if (!move_uploaded_file($rfoto, $destino)) {
					echo "Error al mover el archivo.";
					exit();
				}
			} else {
				echo "Tipo de archivo no permitido.";
				exit();
			}
		}

		// Preparar la consulta de actualización
		$update_query = mysqli_prepare($conexion, "UPDATE usuarios SET nombre_completo=?, correo=?, usuario=?, fotoPerfil=?, sexo=?, nacimiento=? WHERE id=?");
		mysqli_stmt_bind_param($update_query, "ssssssi", $nombre, $correo, $usuario, $nombrea, $sexo, $nacimiento, $id);

		// Verificar si la actualización fue exitosa
		if (mysqli_stmt_execute($update_query)) {
			echo "<script type='text/javascript'>alert('Actualización exitosa, por favor vuelva a iniciar sesion para que los cambios se efectuen correctamente.');</script>";
		
			// Generar una cadena de consulta única basada en el tiempo actual
			$random_string = uniqid();
		
			// Redirigir a la misma página con la cadena de consulta única
			echo "<script type='text/javascript'>window.location='editarPerfil.php?id=$id&random=$random_string';</script>";
			exit();
		} else {
			echo "Error al actualizar el perfil: " . mysqli_error($conexion);
			exit();
		}

		mysqli_stmt_close($update_query);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Game | Perfil</title>
    <link rel="shortcut icon" href="../img/iconos/logo.jpg">
    
    <!-- Links para los css -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/main.css">

    <!-- Los diferentes plugins Y JS -->
    <script src="../js/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1><a href="../sessionStart/index.php"><img src="../img/imgGeneral/logo.png" alt="logo"></a></h1>
        <?php 
            $user = $_SESSION['usuario'];
            if ($user['perfil'] === 1){
                include("../sessionStart/encabezadoAdmin.php");
            } else {
                include("../sessionStart/encabezadoUsuario.php");
            }
        ?>
    </header>
    <main class="columnas">
        <div class="perfil">
            <div class="imgNombre">
                <img src="../img/avatares/<?php echo $user['fotoPerfil']; ?>" alt="perfil">
                <p class="nombre"><?php echo $user['nombre_completo']; ?></p>
            </div>
            <div class="entradasPropias">
                <h3>ultimas entradas</h3>
                <?php
                    $query = "SELECT * FROM contenido WHERE creador =" . $user['id'];
                    $resultado = $conexion -> query($query);
                    while ($row = $resultado->fetch_assoc()){
                ?>
                    <p class="recientes"><?php echo "<a href='../apartados/blog.php?id=" . $row["Id"] . "' class='blog'>". $row['Titulo'] ."</a>" ?></p>
                <?php 
                    }
                ?>
            </div>
        </div>
        <div class="editar">
            <h5 class="editarPerfil">Editar datos de perfil</h5>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="nombre" class="label">Nombre Completo</label>
                        <input type="text" name="nombre" placeholder="Nombre Completo" value="<?php echo $user['nombre_completo']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="label">Usuario</label>
                        <input type="text" name="usuario" value="<?php echo $user['usuario']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="correo" class="label">Email</label>
                        <input type="text" name="correo" value="<?php echo $user['correo']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="label">Nueva foto de perfil</label>
                        <input type="file" name="avatar">
                    </div>
                    <div class="checkbox">
                        <input type="radio" value="H" name="sexo" <?php if($user['sexo'] === 'H'){ echo 'checked'; } ?>> Hombre
                        <input type="radio" value="M" name="sexo" <?php if($user['sexo'] === 'M'){ echo 'checked'; } ?>> Mujer
                    </div>
                    <div class="form-group">
                        <label class="label">Fecha de nacimiento</label>
                        <div class="input-group">
                            <input type="date" name="nacimiento" value="<?php echo $user['nacimiento'];?>" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" name="actualizar">Actualizar datos</button>
                </div>
            </form>
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
                ?>
            </div>
        </div>
    </main>
    <footer>
        <h6 class="footer">Por favor, sígueme en mis redes sociales y sitios de entretenimiento para ayudarme a crecer nuestra querida comunidad <3</h6>
        <div class="redes">
            <ul>
                <li><a href="https://www.facebook.com/kian14Oficial"><img src="../img/iconos/facebook.png" alt="Facebook"></a></li>
                <li><a href="https://www.instagram.com/kian14_mic/"><img src="../img/iconos/instagram.png" alt="Instagram"></a></li>
                <li><a href="https://www.twitch.tv/kian_14_mic"><img src="../img/iconos/twitch.png" alt="Twitch"></a></li>
                <li><a href="https://www.youtube.com/channel/UCjoR3qfEIXXoeAd0DU7y9og"><img src="../img/iconos/youtube.png" alt="Youtube"></a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
