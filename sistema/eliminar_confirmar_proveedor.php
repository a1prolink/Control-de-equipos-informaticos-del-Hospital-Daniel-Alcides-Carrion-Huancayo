<?php
session_start();
include "../conexion.php";

if (!empty($_POST)) {
    if (empty($_POST['idproveedor'])) {
        header("location: lista_proveedor.php");
        exit;
    }
    $idproveedor = $_POST['idproveedor'];

    // Eliminar proveedor
    $query_delete = mysqli_query($conection, "UPDATE proveedores SET estatus = 0 WHERE codproveedor = $idproveedor");

    if ($query_delete) {
        header("location: lista_proveedor.php");
        exit;
    } else {
        echo "Error al eliminar el proveedor: " . mysqli_error($conection);
        exit;
    }
}

// Recuperar datos del proveedor
if (empty($_REQUEST['id'])) {
    header("location: lista_proveedor.php");
    exit;
} else {
    $idproveedor = $_REQUEST['id'];

    // Verificar que el ID es un número
    if (!is_numeric($idproveedor)) {
        header("location: lista_proveedor.php");
        exit;
    }

    $query = mysqli_query($conection, "SELECT proveedor, contacto, telefono, direccion FROM proveedores WHERE codproveedor = $idproveedor");
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $proveedor = $data['proveedor'];
            $contacto = $data['contacto'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
        }
    } else {
        header("location: lista_proveedor.php");
        exit;
    }
    mysqli_close($conection);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Proveedor</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <h2>¿Está seguro de eliminar el siguiente proveedor?</h2>
            <p>Nombre: <span><?php echo $proveedor; ?></span></p>
            <p>Contacto: <span><?php echo $contacto; ?></span></p>
            <p>Teléfono: <span><?php echo $telefono; ?></span></p>
            <p>Dirección: <span><?php echo $direccion; ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
                <a href="lista_proveedor.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
