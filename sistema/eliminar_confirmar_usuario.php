<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}
include "../conexion.php";

if (!empty($_POST)) {
    if (empty($_POST['idusuario'])) {
        header("location: lista_usuario.php");
    }
    $idusuario = $_POST['idusuario'];

    // Eliminar usuario
    $query_delete = mysqli_query($conection, "UPDATE usuarios SET estatus = 0 WHERE idusuario = $idusuario");
    mysqli_close($conection);

    if ($query_delete) {
        header("location: lista_usuario.php");
    } else {
        echo "Error al eliminar el usuario.";
    }
}

// Recuperar datos del usuario
if (empty($_REQUEST['id'])) {
    header("location: lista_usuario.php");
} else {
    $idusuario = $_REQUEST['id'];

    $query = mysqli_query($conection, "SELECT u.nombre, u.usuario, r.rol FROM usuarios u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $idusuario");
    mysqli_close($conection);
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $nombre = $data['nombre'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
        }
    } else {
        header("location: lista_usuario.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Usuario</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <h2>¿Está seguro de eliminar el siguiente usuario?</h2>
            <p>Nombre: <span><?php echo $nombre; ?></span></p>
            <p>Usuario: <span><?php echo $usuario; ?></span></p>
            <p>Rol: <span><?php echo $rol; ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                <a href="lista_usuario.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
