<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("location: ./");
}
include('../conexion.php');

if (empty($_GET['id'])) {
    header('Location: lista_equipo.php');
}
$id_equipo = $_GET['id'];

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['tipoequipo']) || empty($_POST['organizacion']) || empty($_POST['suborganizacion']) || empty($_POST['subsuborganizacion']) || empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['patri']) || empty($_POST['serie']) || empty($_POST['descripcion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $tipoequipo = $_POST['tipoequipo'];
        $organizacion = $_POST['organizacion'];
        $suborganizacion = $_POST['suborganizacion'];
        $subsuborganizacion = $_POST['subsuborganizacion'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $codpratimonial = $_POST['patri'];
        $serieEquipo = $_POST['serie'];
        $descripcion = $_POST['descripcion'];
        $usuario_id = $_SESSION['idUser'];

        $foto = $_FILES['foto'];
        $nombre_foto = $foto['name'];
        $type = $foto['type'];
        $url_temp = $foto['tmp_name'];

        $imgProducto = $_POST['foto_actual'];
        $foto_remove = $_POST['foto_remove'];

        if ($nombre_foto != '') {
            $destino = 'img/uploads/';
            $img_nombre = 'img_' . md5(date('d-m-Y H:m:s'));
            $imgProducto = $img_nombre . '.jpg';
            $src = $destino . $imgProducto;
        } else {
            if ($_POST['foto_actual'] != $_POST['foto_remove']) {
                $imgProducto = 'img_producto.png';
            }
        }

        $query_update = mysqli_query($conection, "UPDATE equipo SET tipoequipo = '$tipoequipo', organizacion = '$organizacion', suborganizacion = '$suborganizacion', subsuborganizacion = '$subsuborganizacion', marca = '$marca', modelo = '$modelo', codpratimonial = '$codpratimonial', serie = '$serieEquipo', descripcion = '$descripcion', usuario_id = '$usuario_id', foto = '$imgProducto' WHERE codequipos = $id_equipo");

        if ($query_update) {
            if (($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove'])) {
                unlink('img/uploads/' . $_POST['foto_actual']);
            }
            if ($nombre_foto != '') {
                move_uploaded_file($url_temp, $src);
            }
            $alert = '<p class="msg_save">Equipo actualizado correctamente.</p>';
        } else {
            $alert = '<p class="msg_error">Error al actualizar el equipo.</p>';
        }
    }
}

$query = mysqli_query($conection, "SELECT e.codequipos, e.tipoequipo, e.organizacion, e.suborganizacion, e.subsuborganizacion, e.marca, e.modelo, e.codpratimonial, e.serie, e.descripcion, e.foto, te.Equipo as tipoEquipoNombre, o.nombre as organizacionNombre, so.nombre as suborganizacionNombre, sso.nombre as subsuborganizacionNombre FROM equipo e INNER JOIN tipoequipo te ON e.tipoequipo = te.codequipo INNER JOIN organizaciones o ON e.organizacion = o.id LEFT JOIN suborganizaciones so ON e.suborganizacion = so.id LEFT JOIN subsuborganizaciones sso ON e.subsuborganizacion = sso.id WHERE e.codequipos = $id_equipo");
$result = mysqli_num_rows($query);

if ($result == 0) {
    header('Location: lista_equipo.php');
} else {
    $data = mysqli_fetch_array($query);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <link rel="stylesheet" type="text/css" href="css/form_style.css">
    <title>Editar Equipo</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Editar Equipo</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $data['codequipos']; ?>">
                <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $data['foto']; ?>">
                <input type="hidden" name="foto_remove" id="foto_remove" value="<?php echo $data['foto']; ?>">

                <div class="combo_box">
                    <label for="tipoequipo">Tipo de Equipo</label>
                    <?php
                    $query_tipoequipo = mysqli_query($conection, "SELECT codequipo, Equipo FROM tipoequipo WHERE estatus = 1 ORDER BY codequipo ASC");
                    $result_tipoequipo = mysqli_num_rows($query_tipoequipo);
                    ?>
                    <select name="tipoequipo" id="tipoequipo">
                        <?php
                        if ($result_tipoequipo > 0) {
                            while ($tipoequipo = mysqli_fetch_array($query_tipoequipo)) {
                                $selected = ($tipoequipo['codequipo'] == $data['tipoequipo']) ? 'selected' : '';
                                echo "<option value='{$tipoequipo['codequipo']}' $selected>{$tipoequipo['Equipo']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="combo_box">
                    <label for="organizacion">Organización</label>
                    <select name="organizacion" id="organizacion">
                        <?php
                        $query_organizacion = mysqli_query($conection, "SELECT id, nombre FROM Organizaciones WHERE estatus = 1 ORDER BY nombre ASC");
                        while ($org = mysqli_fetch_assoc($query_organizacion)) {
                            $selected = ($org['id'] == $data['organizacion']) ? 'selected' : '';
                            echo "<option value='{$org['id']}' $selected>{$org['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="combo_box">
                    <label for="suborganizacion">Suborganización</label>
                    <select name="suborganizacion" id="suborganizacion">
                        <option value="<?php echo $data['suborganizacion']; ?>"><?php echo $data['suborganizacionNombre']; ?></option>
                    </select>
                </div>

                <div class="combo_box">
                    <label for="subsuborganizacion">Sub-Suborganización</label>
                    <select name="subsuborganizacion" id="subsuborganizacion">
                        <option value="<?php echo $data['subsuborganizacion']; ?>"><?php echo $data['subsuborganizacionNombre']; ?></option>
                    </select>
                </div>

                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" placeholder="Marca del equipo" value="<?php echo $data['marca']; ?>">

                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" placeholder="Modelo del equipo" value="<?php echo $data['modelo']; ?>">

                <label for="patri">Código Patrimonial</label>
                <input type="text" name="patri" id="patri" placeholder="Código patrimonial" value="<?php echo $data['codpratimonial']; ?>">

                <label for="serie">Serie del Equipo</label>
                <input type="text" name="serie" id="serie" placeholder="Serie del Equipo" value="<?php echo $data['serie']; ?>">

                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Equipo" value="<?php echo $data['descripcion']; ?>">

                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto <?php echo ($data['foto'] != 'img_producto.png') ? '' : 'notBlock'; ?>">X</span>
                        <label for="foto"></label>
                        <img id="img" src="img/uploads/<?php echo $data['foto']; ?>">
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>

                <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Guardar Cambios</button>
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
    <script src="js/combo_boxes.js"></script>
</body>
</html>
