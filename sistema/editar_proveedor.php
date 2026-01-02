<?php
session_start();
include "../conexion.php";

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['tipoequipo'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $codproveedor = $_POST['id'];
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $tipoequipo = $_POST['tipoequipo'];

        $query_update = mysqli_query($conection, "UPDATE proveedores SET proveedor = '$proveedor', contacto = '$contacto', telefono = '$telefono', direccion = '$direccion', tipodeequipo = '$tipoequipo' WHERE codproveedor = $codproveedor");

        if ($query_update) {
            $alert = '<p class="msg_save">Proveedor actualizado correctamente.</p>';
        } else {
            $alert = '<p class="msg_error">Error al actualizar el proveedor.</p>';
        }
    }
}

// Mostrar datos
if (empty($_GET['id'])) {
    header('Location: lista_proveedor.php');
    mysqli_close($conection);
}
$idproveedor = $_GET['id'];

$sql = mysqli_query($conection, "SELECT p.codproveedor, p.proveedor, p.contacto, p.telefono, p.direccion, p.tipodeequipo, te.Equipo as tipoequipo FROM proveedores p INNER JOIN tipoequipo te ON p.tipodeequipo = te.codequipo WHERE codproveedor = $idproveedor");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_proveedor.php');
} else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {
        $idproveedor = $data['codproveedor'];
        $proveedor = $data['proveedor'];
        $contacto = $data['contacto'];
        $telefono = $data['telefono'];
        $direccion = $data['direccion'];
        $tipoequipo = $data['tipodeequipo'];
        $option = '<option value="' . $tipoequipo . '" select>' . $data['tipoequipo'] . '</option>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Editar Proveedor</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Editar Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idproveedor; ?>">
                <label for="proveedor">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor" value="<?php echo $proveedor; ?>">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre del contacto" value="<?php echo $contacto; ?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo $direccion; ?>">
                <label for="tipoequipo">Tipo de Equipo</label>

                <?php
                include "../conexion.php";
                $query_tipoequipo = mysqli_query($conection, "SELECT * FROM tipoequipo");
                mysqli_close($conection);
                $result_tipoequipo = mysqli_num_rows($query_tipoequipo);
                ?>

                <select name="tipoequipo" id="tipoequipo" class="notItemOne">
                    <?php
                    echo $option;
                    if ($result_tipoequipo > 0) {
                        while ($tipoequipo = mysqli_fetch_array($query_tipoequipo)) {
                    ?>
                        <option value="<?php echo $tipoequipo["codequipo"]; ?>"><?php echo $tipoequipo["Equipo"] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn_save"><i class="fas fa-save"></i> Guardar Cambios</button>
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
