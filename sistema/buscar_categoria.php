<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
    exit;
}

include "../conexion.php";

$busqueda = strtolower($_REQUEST['busqueda']);
if (empty($busqueda)) {
    header("location: lista_categoria.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Lista de Categorías</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1>Lista de Categorías</h1>
        <a href="registro_categoria.php" class="btn_new">Crear Categoría</a>

        <form action="buscar_categoria.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>
        <div class="containerTable">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                <?php
                // Paginador
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM tipoequipo
                                                        WHERE ( codequipo LIKE '%$busqueda%' OR
                                                                Equipo LIKE '%$busqueda%' )
                                                        AND estatus = 1");
                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['total_registro'];

                $por_pagina = 20;

                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);

                $query = mysqli_query($conection, "SELECT codequipo, Equipo FROM tipoequipo
                                                  WHERE ( codequipo LIKE '%$busqueda%' OR
                                                          Equipo LIKE '%$busqueda%' )
                                                  AND estatus = 1
                                                  ORDER BY codequipo ASC
                                                  LIMIT $desde, $por_pagina");
                $result = mysqli_num_rows($query);
                mysqli_close($conection);
                if ($result > 0) {
                    while ($data = mysqli_fetch_array($query)) {
                ?>
                        <tr>
                            <td><?php echo $data["codequipo"]; ?></td>
                            <td><?php echo $data["Equipo"]; ?></td>
                            <td>
                                <a class="link_edit" href="editar_categoria.php?id=<?php echo $data["codequipo"]; ?>">Editar</a>
                                |
                                <a class="link_delete" href="eliminar_confirmar_categoria.php?id=<?php echo $data["codequipo"]; ?>">Eliminar</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
        <?php
        if ($total_registro != 0) {
        ?>
            <div class="paginador">
                <ul>
                    <?php
                    if ($pagina != 1) {
                    ?>
                        <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
                        <li><a href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina) {
                            echo '<li class="pageSelected">' . $i . '</li>';
                        } else {
                            echo '<li><a href="?pagina=' . $i . '&busqueda=' . $busqueda . '">' . $i . '</a></li>';
                        }
                    }
                    if ($pagina != $total_paginas) {
                    ?>
                        <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
                        <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>>|</a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>
