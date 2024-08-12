
		<div class="menu">
			<nav class="navegador">
				<ul>
					<li><a href="../sessionStart/index.php" id="selected"></a></li>

					<li><a href="../apartados/nosotros.php">Nosotros</a></li>
					<li><a href="#"><?php echo $user['usuario']; ?></a>
						<ul class="navPerfil">
							<li><a href="../apartados/editarPerfil.php?id=<?php echo $user['id'];?>">Perfil</a></li>
							<li><a href="../apartados/subirEntradas.php">Subir Entrada</a></li>
							<li><a href="../apartadosPhp/cerrar_sesion_usuario.php">Cerrar sesion</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>