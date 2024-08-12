<?php
// Incluir el archivo de conexión
include '../apartadosPhp/conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nuevoPerfil = $_POST['nuevoPerfil'];
    $usuarioId = $_POST['usuarioId'];

    // Actualizar el perfil del usuario en la base de datos
    $sql = "UPDATE usuarios SET perfil = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $nuevoPerfil, $usuarioId);

    if ($stmt->execute()) {
        // Redirigir al usuario de nuevo a la página de administración después de la actualización
        header("Location: ../apartados/administrarCuentas.php");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso no autorizado.";
}
?>
