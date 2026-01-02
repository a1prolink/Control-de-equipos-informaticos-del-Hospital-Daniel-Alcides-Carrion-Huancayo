<?php
session_start();
if($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)
{
    header("location: ./");
}
include "../conexion.php";

if(!empty($_POST))
{
    $alert = '';
    if(empty($_POST['nombre']))
    {
        $alert = '<p class="msg_error">El nombre de la categoría es obligatorio.</p>';
    }else{
        $idCategoria = $_POST['id'];
        $nombre = $_POST['nombre'];

        $query = mysqli_query($conection, "SELECT * FROM tipoequipo WHERE Equipo = '$nombre' AND codequipo != $idCategoria");

        $result = mysqli_fetch_array($query);

        if($result > 0){
            $alert = '<p class="msg_error">El nombre de la categoría ya existe.</p>';
        }else{
            $sql_update = mysqli_query($conection, "UPDATE tipoequipo SET Equipo = '$nombre' WHERE codequipo = $idCategoria");

            if($sql_update){
                $alert = '<p class="msg_save">Categoría actualizada correctamente.</p>';
            }else{
                $alert = '<p class="msg_error">Error al actualizar la categoría.</p>';
            }
        }
    }
}

// Mostrar Datos
if(empty($_REQUEST['id']))
{
    header('Location: lista_categoria.php');
    mysqli_close($conection);
}
$idCategoria = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM tipoequipo WHERE codequipo = $idCategoria AND estatus = 1");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
    header('Location: lista_categoria.php');
}else{
    while ($data = mysqli_fetch_array($sql)) {
        $idCategoria  = $data['codequipo'];
        $nombre       = $data['Equipo'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Editar Categoría</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form_register">
            <h1>Editar categoría</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idCategoria; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de la categoría" value="<?php echo $nombre; ?>">
                <input type="submit" value="Actualizar categoría" class="btn_save">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
