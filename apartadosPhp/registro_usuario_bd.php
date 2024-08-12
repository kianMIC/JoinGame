<?php 

	include("conexion_bd.php");

	$nombre_completo = $_POST['nombre_completo'];
	$correo = $_POST['correo'];
	$usuario = $_POST['usuario'];
	$contrasena = $_POST['contrasena'];
	
	$contrasena = hash('sha512', $contrasena);//con esto encriptamos la contraseña

	$datos = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena, perfil, fotoPerfil, sexo) 
			VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena', '2', 'usuario.png', 'H')";

			// verificar que el correo no se repita en la base de datos

	$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo ='$correo' ");
	if(mysqli_num_rows($verificar_correo) > 0){
		echo ' 
			<script>
				alert("Este correo ya se encuentra registrado, intenta con uno diferente");
				window.location = "../apartados/formulario.php";
			</script>
		';
		exit(); 
	}
			// verificar que el nombre de usuario no se repita en la base de datos

	$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario ='$usuario' ");
	
	if(mysqli_num_rows($verificar_usuario) > 0){
		echo ' 
			<script>
				alert("Este usuario ya se encuentra registrado, intenta con uno diferente");
				window.location = "../apartados/formulario.php";
			</script>
		';
		exit(); 
	}

			//contianuacion de el registro si todos los datos son correctos 

	$ejecutar = mysqli_query($conexion, $datos);

	if($ejecutar){
		echo '
			<script>
				alert("El usuario fue registrado exitosamente");
				window.location = "../sessionStart/index.php";
			</script>
		';
	}else{
		echo '
			<script>
				alert("Ha ocurrido un error, por favor vuelve a intentarlo");
				window.location = "../index.php";
			</script>
		';
	}

	mysqli_close($conexion); 
?>