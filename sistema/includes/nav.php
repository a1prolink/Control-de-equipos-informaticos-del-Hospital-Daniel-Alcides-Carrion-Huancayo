  <nav>
		    <ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
			<?php
                if ($_SESSION['rol'] == 1) {
                ?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Usuarios <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuario.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
					</ul>
				</li>
			<?php } ?>
                 <li class="principal">
					<a href="#"><i class="far fa-building"></i> Categoria <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_categoria.php">Nuevo Categoria</a></li>
						<li><a href="lista_categoria.php">Lista de Cateoria</a></li>
					</ul>
				</li>
            <?php
                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                ?>
				<li class="principal">
					<a href="#"><i class="far fa-building"></i> Proveedores <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
						<li><a href="lista_proveedor.php"><i class="far fa-list-alt"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#"><i class="fas fa-cubes"></i> Equipos <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<?php
                if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                ?>
						<li><a href="registro_equipos.php"><i class="fas fa-plus"></i> Nuevo Equipo</a></li>
				<?php } ?>
						<li><a href="lista_equipos.php"><i class="fas fa-cube"></i> Lista de Equipos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#"><i class="fas fa-file-alt"></i> Reportes <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="formulario_reporte.php"><i class="fas fa-plus"></i> Nuevo Reporte</a></li>
						<li><a href="lista_reportes.php"><i class="far fa-newspaper"></i> Lista de Reportes</a></li>
					</ul>
				</li>
			</ul>
		</nav>
