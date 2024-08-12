<?php
    // Incluir el archivo de conexión
    include 'conexion_bd.php';

    // Recuperar datos del formulario
    $comentario = $_POST['comentario'];
    $contenido_id = $_POST['contenido_id'];

    // Obtener el ID del usuario actual desde la sesión si está iniciada
    session_start();
    $usuario_id = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;

    // Verificar si el usuario ha iniciado sesión
    if ($usuario_id === null) {
        // Usuario no autenticado, redirigir con parámetro de aviso
        header("Location: ../apartados/blog.php?id=$contenido_id&aviso=no_autenticado");
        exit();
    }

    // Insertar comentario en la base de datos
    $sql = "INSERT INTO comentarios (comentario, usuario, contenido, fecha)
            VALUES ('$comentario', $usuario_id, $contenido_id, NOW())";

    if ($conexion->query($sql) === TRUE) {
        // Comentario publicado correctamente, redirigir con parámetro de aviso
        header("Location: ../apartados/blog.php?id=$contenido_id&aviso=comentario_publicado");
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        // Error al publicar el comentario, redirigir con parámetro de aviso
        header("Location: ../apartados/blog.php?id=$contenido_id&aviso=error_publicacion");
        exit();
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
?>
