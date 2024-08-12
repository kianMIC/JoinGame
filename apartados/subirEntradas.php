					<!-- PRIMERO HACEMOS UNA VALIDACION PARA QUE SOLO LAS PERSONAS REGISTRADAS PUEDAN ENTRAR A ESTA SECCION -->

<?php 
     include '../apartadosPhp/conexion_bd.php';
	session_start();
	$user = $_SESSION['usuario'];
	if(!isset($user)/* || $user['perfil'] !== 1*/){
		echo '
			<script>
				alert("No puedes acceder a este apartado, tienes que iniciar sesion primero");
				window.location = "../index.php";
			</script>
		';
		session_destroy();
		die();
	}
		if (!empty($_POST)) {
          $alert = '';
          if (empty($_POST['titulo']) || empty($_POST['descripcion']) || empty($_POST['foto']) <= 0){
               $alert = '<p class="msg_error">Por favor rellene los apartados obligatorios.</p>';
          }else{

          		$usuario = $user['id'];

               $categoria = $_POST['categoria'];
               $fecha = date("Y-m-d H:i:s");
               $titulo = $_POST['titulo'];
               $subtitulo = $_POST['subtitulo'];
               $descripcion = $_POST['descripcion'];
               $descripcion2 = $_POST['descripcion2'];
               $pieEntrada = $_POST['pieEntrada'];
              	$creador = $usuario;

               $foto = $_FILES['foto'];
               $nombre_foto = $foto['name'];
               $type = $foto['type'];
               $url_temp = $foto['tmp_name'];

               $imgEntrada = '../img/img_entrada.jpg';

               if ($nombre_foto != '') {
                    $destino = '../img/entradas/';
                    $img_nombre = 'img_1'.md5(date('d-m-Y H:m:s'));
                    $imgEntrada= $img_nombre.'.jpg';
                    $src = $destino.$imgEntrada; 
               }


               $foto2 = $_FILES['foto2'];
               $nombre_foto2 = $foto2['name'];
               $type2 = $foto2['type'];
               $url_temp2 = $foto2['tmp_name'];

               $imgEntrada2 = '../img/img_entrada.jpg';

               if ($nombre_foto2 != '') {
                    $destino = '../img/entradas/';
                    $img_nombre2 = 'img_2'.md5(date('d-m-Y H:m:s'));
                    $imgEntrada2= $img_nombre2.'.jpg';
                    $src2 = $destino.$imgEntrada2; 
               }

               $query_inset = mysqli_query($conexion, "INSERT INTO contenido(categoria, creador, Titulo, subtitulo, Fecha, Img, comentario1, img2, comentario2, pieEntrada) VALUES ('$categoria', '$creador', '$titulo', '$subtitulo', '$fecha', '$imgEntrada', '$descripcion', '$imgEntrada2', '$descripcion2', '$pieEntrada')");
               if ($query_inset) {
                    if ($nombre_foto !== '') {
                         move_uploaded_file($url_temp, $src);
                         $alert = '<p class="msg_save">Entrada guardada correctamente.</p>';
                    }
                    
               }else{
                    $alert = '<p class="msg_error">Error al guardar la Entrada.</p>';
               }
               if ($query_inset) {
                    if ($nombre_foto2 !== '') {
                         move_uploaded_file($url_temp2, $src2);
                         $alert = '<p class="msg_save">Entrada guardada correctamente.</p>';
                    }
                    
               }else{
                    $alert = '<p class="msg_error">Error al guardar la Entrada.</p>';
               }
          }
     }
		
?>



					<!-- AHORA SI CONTINUAMOS -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nueva Entrada | Join Game</title>
	<link rel="shortcut icon" href="../img/iconos/logo.jpg">
	
	<!-- Links para los css -->
	<link rel="stylesheet" href="../css/reset.css">
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/cssEntrada.css">

	<!-- Los diferentes plugins Y JS -->
  	<script src="../js/jquery-3.6.0.min.js"></script>
  	<script src="../js/formEntrada.js"></script>

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
		?>
	</header>
	<main>
		<div class="formEntrada">
			<h2>Nueva Entrada | Join Game</h2>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<form action="" method="POST" id="subirEntrada" enctype="multipart/form-data">
				<label for="Categoria">Categoria</label>
				<?php 
                    include("../apartadosPhp/conexion_bd.php");
                    $query_categoria = mysqli_query($conexion, "SELECT * FROM categorias");
                    $result_categoria = mysqli_num_rows($query_categoria);
                    mysqli_close($conexion);
                ?>
                <select name="categoria" id="categoria">
                    <?php 
                        if($result_categoria > 0){
                            while($categoria = mysqli_fetch_array($query_categoria)){
                    ?>
                    <option value="<?php echo $categoria['nombre_categoria'];?>"><?php echo $categoria['nombre_categoria'];?></option>
                    <?php 
                              }
                         }
                     ?>          
                </select>
				<label for="titulo">Titulo</label>
				<input type="text" name="titulo" id="titulo" placeholder="Titulo de la Entrada">

				<div class="photo">
                <label for="foto">Foto:</label>
                    <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                    </div>
                    <div class="upimg">
                     	<input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>

                <label for="subtitulo">Subtitulo</label>
                <textarea name="subtitulo" id="subtitulo" placeholder="(No Obligatorio)"></textarea>
                
                <label for="descripcion">Descripcion</label>
                <textarea name="descripcion" id="descripcion" placeholder="Agrega aqui la primera descripcion"></textarea>

                <div class="photo2">
                <label for="foto2">Foto:</label>
                    <div class="prevPhoto2">
                        <span class="delPhoto2 notBlock2">X</span>
                        <label for="foto2"></label>
                    </div>
                    <div class="upimg2">
                     	<input type="file" name="foto2" id="foto2">
                    </div>
                    <div id="form_alert2"></div>
                </div>

                <label for="descripcion2">Descripcion</label>
                <textarea name="descripcion2" id="descripcion2" placeholder="Agrega aqui la segunda descripcion"></textarea>
                <textarea name="pieEntrada" id="pieEntrada" placeholder="Agrega un final con una nota a tu Entrada (no Obligatorio)"></textarea>
                <button type="submit" class="btn_save">Subir Entrada</button>
			</form>
			<div id="error"></div>
		</div>
		
	</main>
		
</body>
</html>