
<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("location: ./");
}
include('../conexion.php');
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

        $imgProducto = 'img_producto.png';

        if ($nombre_foto !== '') {
            $destino = 'img/uploads/';
            $img_nombre = 'img_' . md5(date('d-m-Y H:m:s'));
            $imgProducto = $img_nombre . '.jpg';
            $src = $destino . $imgProducto;
        }
        $query_insert = mysqli_query($conection, "INSERT INTO equipo(tipoequipo, organizacion, suborganizacion, subsuborganizacion, marca, modelo, codpratimonial, serie, descripcion, usuario_id, foto) VALUES('$tipoequipo','$organizacion','$suborganizacion','$subsuborganizacion','$marca', '$modelo','$codpratimonial','$serieEquipo','$descripcion','$usuario_id','$imgProducto')");
        if ($query_insert) {
            if ($nombre_foto !== '') {
                move_uploaded_file($url_temp, $src);
            }
            $alert = '<p class="msg_save">Producto guardado correctamente.</p>';
        } else {
            $alert = '<p class="msg_error">Error al guardar el producto.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <link rel="stylesheet" type="text/css" href="css/form_style.css">
    <title>Registro de Equipos</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-cubes"></i> Registro de Equipos Informaticos</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="combo_box">
                    <label for="tipoequipo">Tipo de Equipo</label>
                    <?php
                    $query_tipoequipo = mysqli_query($conection, "SELECT codequipo, Equipo FROM tipoequipo WHERE estatus = 1 ORDER BY codequipo ASC");
                    $result_tipoequipo = mysqli_num_rows($query_tipoequipo);
                    ?>
                    <select name="tipoequipo" id="tipoequipo">
                    <?php
                        if ($result_tipoequipo > 0) {
                            while($tipoequipo = mysqli_fetch_array($query_tipoequipo)){
                    ?>
                        <option value="<?php echo $tipoequipo['codequipo']; ?>"><?php echo $tipoequipo['Equipo']; ?></option>
                    <?php
                            }
                        }
                    ?>
                    </select>
                </div>

                <div class="combo_box">
                    <label for="organizacion">Organización</label>
                    <select name="organizacion" id="organizacion">
                        <option value="">Seleccionar organización</option>
                        <?php
                        $query_organizacion = mysqli_query($conection, "SELECT id, nombre FROM Organizaciones WHERE estatus = 1 ORDER BY nombre ASC");
                        while ($org = mysqli_fetch_assoc($query_organizacion)) {
                            echo '<option value="'.$org['id'].'">'.$org['nombre'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="combo_box">
                    <label for="suborganizacion">Suborganización</label>
                    <select name="suborganizacion" id="suborganizacion">
                        <option value="">Seleccionar suborganización</option>
                    </select>
                </div>
                <div class="combo_box">
                    <label for="subsuborganizacion">Sub-Suborganización</label>
                    <select name="subsuborganizacion" id="subsuborganizacion">
                        <option value="">Seleccionar sub-suborganización</option>
                    </select>
                </div>
                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" placeholder="Marca del equipo">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" placeholder="Modelo del equipo">
                <label for="patri">Código Patrimonial</label>
                <input type="text" name="patri" id="patri" placeholder="Código patrimonial">
                <label for="serie">Serie del Equipo</label>
                <input type="text" name="serie" id="serie" placeholder="Serie del Equipo">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Equipo">

                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>
                <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Guardar Producto</button>
            </form>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
    <script src="js/combo_boxes.js"></script>
</body>
</html>
