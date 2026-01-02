<?php
session_start();
include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Lista de Equipos</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1><i class="far fa-list-alt"></i> Lista de Equipos</h1>
        <a href="registro_equipos.php" class="btn_new btn_newProducto"><i class="fas fa-plus"></i> Registrar Equipo</a>
        <form action="buscar_equipos.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
        </form>
         <div>
             <h5>Buscar por Fecha</h5>
             <form action="buscar_equipo_fecha.php" method="get" class="form_search_date">
             <label>De: </label>
             <input type="date" name="fecha_de" id="fecha_de" required>
             <label> A </label>
             <input type="date" name="fecha_a" id="fecha_a" required>
             <button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
        </form>
        </div>
       <div class="containerTable">
    <table>
        <tr>
            <th>ID</th>
            <th>Equipo</th>
            <th>Organización</th>
            <th>Suborganización</th>
            <th>SubSuborganación</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>CodPatrimonio</th>
            <th>Serie</th>
            <th>Descripción</th>
            <th>Foto</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM equipo WHERE estatus = 1");
        $result_register = mysqli_fetch_array($sql_registe);
        $total_registro = $result_register['total_registro'];
        $por_pagina = 6;
        if (empty($_GET['pagina'])) {
            $pagina = 1;
        } else {
            $pagina = $_GET['pagina'];
        }

        $desde = ($pagina - 1) * $por_pagina;
        $total_paginas = ceil($total_registro / $por_pagina);

        $query = mysqli_query($conection, "SELECT e.codequipos AS codequipo, te.Equipo AS tipoequipo, o.nombre AS organizacion, so.nombre AS suborganizacion, sso.nombre AS subsuborganizacion, e.marca, e.modelo, e.serie, e.codpratimonial, e.Descripcion, e.foto FROM equipo e INNER JOIN tipoequipo te ON e.tipoequipo = te.codequipo LEFT JOIN organizaciones o ON e.organizacion = o.id LEFT JOIN suborganizaciones so ON e.suborganizacion = so.id LEFT JOIN subsuborganizaciones sso ON e.subsuborganizacion = sso.id WHERE e.estatus = 1 ORDER BY e.codequipos ASC LIMIT $desde, $por_pagina");
        $result = mysqli_num_rows($query);
        mysqli_close($conection);
        if($result > 0){
            while($data = mysqli_fetch_array($query)){
                $foto = ($data['foto'] != 'img_producto.png') ? 'img/uploads/' . $data['foto'] : 'img/' . $data['foto'];
        ?>
        <tr class="row<?php echo $data['codequipo']; ?>">
            <td><?php echo $data['codequipo']; ?></td>
            <td><?php echo $data['tipoequipo']; ?></td>
            <td><?php echo $data['organizacion']; ?></td>
            <td><?php echo $data['suborganizacion']; ?></td>
            <td><?php echo $data['subsuborganizacion']; ?></td>
            <td><?php echo $data['marca']; ?></td>
            <td><?php echo $data['modelo']; ?></td>
            <td><?php echo $data['codpratimonial']; ?></td>
            <td><?php echo $data['serie']; ?></td>
            <td><?php echo $data['Descripcion']; ?></td>
            <td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data['tipoequipo']; ?>"></td>
            <td>
                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                <a class="link_edit" href="editar_equipos.php?id=<?php echo $data['codequipo']; ?>"><i class="far fa-edit"></i> Editar</a>
                |
                <a class="link_delete" href="eliminar_confirmar_equipos.php?id=<?php echo $data['codequipo']; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
                <?php } ?>
            </td>
        </tr>
        <?php
            }
        }
        ?>
    </table>
</div>


        <div class="paginador">
            <ul>
            <?php
                if ($pagina != 1) {
            ?>
                <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
                <li><a href="?pagina=<?php echo $pagina - 1; ?>"><<</a></li>
            <?php
                }
                for ($i = 1; $i <= $total_paginas; $i++) {
                    if ($i == $pagina) {
                        echo '<li class="pageSelected">' . $i . '</li>';
                    } else {
                        echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($pagina != $total_paginas) {
            ?>
                <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas; ?>">>>|</a></li>
            <?php } ?>
            </ul>
        </div>
    </section>
