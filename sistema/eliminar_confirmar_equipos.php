<?php
session_start();
include "../conexion.php";

if (!empty($_POST)) {
    if (empty($_POST['id_equipo'])) {
        header("location: lista_equipos.php");
        exit;
    }
    $id_equipo = $_POST['id_equipo'];

    // Eliminar equipo
    $query_delete = mysqli_query($conection, "UPDATE equipo SET estatus = 0 WHERE codequipos = $id_equipo");
    
    if ($query_delete) {
        header("location: lista_equipos.php");
        exit;
    } else {
        echo "Error al eliminar el equipo: " . mysqli_error($conection);
        exit;
    }
}

// Recuperar datos del equipo
if (empty($_REQUEST['id'])) {
    header("location: lista_equipos.php");
    exit;
} else {
    $id_equipo = $_REQUEST['id'];

    // Verificar que el ID es un número
    if (!is_numeric($id_equipo)) {
        header("location: lista_equipos.php");
        exit;
    }

    $query = mysqli_query($conection, "SELECT e.codequipos, te.Equipo, e.marca, e.modelo, e.serie, e.codpratimonial, e.Descripcion, e.foto FROM equipo e INNER JOIN tipoequipo te ON e.tipoequipo = te.codequipo WHERE e.codequipos = $id_equipo");
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
            $codequipo = $data['codequipos'];
            $tipoequipo = $data['Equipo'];
            $marca = $data['marca'];
            $modelo = $data['modelo'];
            $serie = $data['serie'];
            $codpratimonial = $data['codpratimonial'];
            $descripcion = $data['Descripcion'];
            $foto = $data['foto'];
        }
    } else {
        header("location: lista_equipos.php");
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
    <title>Eliminar Equipo</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <h2>¿Está seguro de eliminar el siguiente equipo?</h2>
            <p>Tipo de Equipo: <span><?php echo $tipoequipo; ?></span></p>
            <p>Marca: <span><?php echo $marca; ?></span></p>
            <p>Modelo: <span><?php echo $modelo; ?></span></p>
            <p>Serie: <span><?php echo $serie; ?></span></p>
            <p>Código Patrimonial: <span><?php echo $codpratimonial; ?></span></p>
            <p>Descripción: <span><?php echo $descripcion; ?></span></p>
            <p>Foto:</p>
            <img src="img/uploads/<?php echo $foto; ?>" alt="<?php echo $tipoequipo; ?>" width="150px">

            <form method="post" action="">
                <input type="hidden" name="id_equipo" value="<?php echo $codequipo; ?>">
                <a href="lista_equipos.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
