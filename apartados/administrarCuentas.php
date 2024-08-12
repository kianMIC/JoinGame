<?php
    // Incluir el archivo de conexión
    include '../apartadosPhp/conexion_bd.php';

    // Verificar si el usuario tiene perfil de administrador (perfil 1)
    session_start();

    // Asegurarse de que el usuario esté autenticado y tenga perfil 1
    if (!(isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] == 1)) {
        // Redirigir al usuario a otra página o mostrar un mensaje de error
        header("Location: ../index.php");
        exit();
    }

    // Obtener la lista de usuarios
    $sql = "SELECT id, usuario, correo, sexo, fotoPerfil, perfil FROM usuarios";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
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
                    include("../sessionStart/encabezadoAdmin.php");
            ?>
        </header>
        <main id="editarPerfiles">
            <h2>Administrar Cuentas</h2>

            <table class="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Sexo</th>
                        <th>Foto de Perfil</th>
                        <th>Perfil</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $resultado->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td><?php echo $row['correo']; ?></td>
                            <td><?php echo $row['sexo']; ?></td>
                            <td>
                                <?php
                                if ($row['fotoPerfil'] != '') {
                                    echo '<img src="../img/avatares/' . $row['fotoPerfil'] . '" alt="Foto de Perfil" style="width: 50px; height: 50px;">';
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td>
                                <form action="../apartadosPhp/actualizarPerfil.php" method="post">
                                    <select name="nuevoPerfil">
                                        <option value="1" <?php echo $row['perfil'] == 1 ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="2" <?php echo $row['perfil'] == 2 ? 'selected' : ''; ?>>Usuario Común</option>
                                    </select>
                                    <input type="hidden" name="usuarioId" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Actualizar Perfil</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </main>
        <footer>
            <h6 class="footer">Por favor, sigueme en mis redes sociales y sitios de entretenimiento para ayudarme a crecer nuestra querida comunidad <3</h6>
            <div class="redes">
                <ul>
                    <li><a href="https://www.facebook.com/kian14Oficial" target="_blank"><img src="../img/iconos/facebook.png" alt="Facebook"></img></a></li>
                    <li><a href="https://www.instagram.com/kian14_mic/" target="_blank"><img src="../img/iconos/instagram.png" alt="Instagram"></img></a></li>
                    <li><a href="https://www.twitch.tv/kian_14_mic" target="_blank"><img src="../img/iconos/twitch.png" alt="Twitch"></img></a></li>
                    <li><a href="https://www.youtube.com/channel/UCjoR3qfEIXXoeAd0DU7y9og" target="_blank"><img src="../img/iconos/youtube.png" alt="Youtube"></img></a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>
<?php
} else {
echo "No hay usuarios registrados.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
