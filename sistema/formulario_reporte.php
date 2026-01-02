<?php
session_start();
include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Generar Reporte de Equipos</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1>Generar Reporte de Equipos</h1>
        <form action="reporte_equipos.php" method="post" class="form_search">
            <label for="fecha_desde">Desde:</label>
            <input type="date" name="fecha_desde" id="fecha_desde" required>
            <label for="fecha_hasta">Hasta:</label>
            <input type="date" name="fecha_hasta" id="fecha_hasta" required>
            <label for="usuario">Usuario:</label>
            <select name="usuario" id="usuario" required>
                <option value="">Seleccione un Usuario</option>
                <?php
                $query_user = mysqli_query($conection, "SELECT idusuario, nombre FROM usuarios WHERE estatus = 1 ORDER BY nombre ASC");
                while ($user = mysqli_fetch_array($query_user)) {
                    echo '<option value="' . $user['idusuario'] . '">' . $user['nombre'] . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="btn_search"><i class="fas fa-search"></i> Generar Reporte</button>
        </form>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
