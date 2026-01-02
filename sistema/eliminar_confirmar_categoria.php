<?php
session_start();
include "../conexion.php";

if (!empty($_POST)) {
    if (empty($_POST['idcategoria'])) {
        header("location: lista_categoria.php");
    }
    $idcategoria = $_POST['idcategoria'];

    // Eliminar categoría
    $query_delete = mysqli_query($conection, "UPDATE tipoequipo SET estatus = 0 WHERE codequipo = $idcategoria");
    mysqli_close($conection);

    if ($query_delete) {
        header("location: lista_categoria.php");
    } else {
        echo "Error al eliminar la categoría.";
    }
}

// Recuperar datos de la categoría
if (empty($_REQUEST['id'])) {
    header("location: lista_categoria.php");
} else {
    $idcategoria = $_REQUEST['id'];

    $query = mysqli_query($conection, "SELECT Equipo FROM tipoequipo WHERE codequipo = $idcategoria");
    mysqli_close($conection);
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $nombre = $data['Equipo'];
        }
    } else {
        header("location: lista_categoria.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Categoría</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <h2>¿Está seguro de eliminar la siguiente categoría?</h2>
            <p>Nombre: <span><?php echo $nombre; ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idcategoria" value="<?php echo $idcategoria; ?>">
                <a href="lista_categoria.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
