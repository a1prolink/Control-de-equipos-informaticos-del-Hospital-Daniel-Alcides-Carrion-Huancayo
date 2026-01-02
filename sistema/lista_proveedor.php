<?php
session_start();
include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Lista de Proveedores</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1><i class="far fa-list-alt"></i> Lista de Proveedores</h1>
        <a href="registro_proveedor.php" class="btn_new btn_newProducto"><i class="fas fa-plus"></i> Registrar Proveedor</a>

        <form action="buscar_proveedor.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
        </form>

        <div class="containerTable">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Equipo</th>
                    <th>Proveedor</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
                <?php
                // Paginador
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM proveedores WHERE estatus = 1");
                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['total_registro'];
                $por_pagina = 5;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);

                $query = mysqli_query($conection, "SELECT p.codproveedor,te.Equipo as tipoequipo,p.proveedor, p.contacto,p.telefono,p.direccion FROM proveedores p INNER JOIN tipoequipo te ON p.tipodeequipo = te.codequipo
                                                   WHERE p.estatus = 1 ORDER BY p.codproveedor ASC
                                                  LIMIT $desde, $por_pagina");
                $result = mysqli_num_rows($query);
                mysqli_close($conection);

                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo $data['codproveedor']; ?></td>
                    <td><?php echo $data['tipoequipo']; ?></td>
                    <td><?php echo $data['proveedor']; ?></td>
                    <td><?php echo $data['contacto']; ?></td>
                    <td><?php echo $data['telefono']; ?></td>
                    <td><?php echo $data['direccion']; ?></td>
                    <td>
                        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                        <a class="link_edit" href="editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>"><i class="far fa-edit"></i> Editar</a>
                        |
                         <a class="link_delete" href="eliminar_confirmar_proveedor.php?id=<?php echo $data['codproveedor']; ?>"><i class="far fa-edit"></i> Eliminar</a>
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
    <?php include "includes/footer.php"; ?>
</body>
</html>