<?php
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
    header("location: ./");
}
include "../conexion.php";

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['TipoEquipo']) || empty($_POST['Proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $tipodeequipo = $_POST['TipoEquipo'];
        $proveedor = $_POST['Proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['idUser'];

        $query_insert = mysqli_query($conection, "INSERT INTO proveedores(tipodeequipo, proveedor, contacto, telefono, direccion, usuario_id) VALUES('$tipodeequipo', '$proveedor', '$contacto', '$telefono', '$direccion', '$usuario_id')");

        if ($query_insert) {
            $alert = '<p class="msg_save">Proveedor guardado correctamente.</p>';
        } else {
            $alert = '<p class="msg_error">Error al crear el Proveedor.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro de Proveedor</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form_register">
            <h1><i class="far fa-building"></i> Registro de Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="TipoEquipo">Tipo de Equipo</label>
                <?php
                $query_tipoequipo = mysqli_query($conection, "SELECT codequipo, Equipo FROM tipoequipo WHERE estatus = 1 ORDER BY Equipo ASC");
                $result_tipoequipo = mysqli_num_rows($query_tipoequipo);
                ?>
                <select name="TipoEquipo" id="TipoEquipo">
                    <?php
                    if ($result_tipoequipo > 0) {
                        while ($tipoequipo = mysqli_fetch_array($query_tipoequipo)) {
                            echo '<option value="'.$tipoequipo['codequipo'].'">'.$tipoequipo['Equipo'].'</option>';
                        }
                    }
                    ?>
                </select>
                <label for="Proveedor">Proveedor</label>
                <input type="text" name="Proveedor" id="Proveedor" placeholder="Nombre del Proveedor">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre Completo del contacto">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección">
                <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Guardar Proveedor</button>
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
