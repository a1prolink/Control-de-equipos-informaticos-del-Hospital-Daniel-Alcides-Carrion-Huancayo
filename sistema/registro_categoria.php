<?php
session_start();
include "../conexion.php";
if (!empty($_POST))
{
	$alert = '';
	if(empty($_POST['Equipo']))
	{
       $alert = '<p class ="msg_error">Todos los campos son obligatorios.</p>';
	}else{
	   $nombre     = $_POST['Equipo'];
       $usuario_id = $_SESSION['idUser'];
        $result = 0;
        {
            $query_insert = mysqli_query($conection,"INSERT INTO tipoequipo(Equipo,usuario_id) VALUES('$nombre','$usuario_id')");

             if ($query_insert) {
        		$alert = '<p class ="msg_save">Categoria creado con exito.</p>';
        	}else{
                $alert = '<p class ="msg_save">Error al crear el Categoria.</p>';
        	}
        }
    }
    mysqli_close($conection);
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Registro de Categoria</title>
</head>
<body>
    <?php include "includes/header.php";?>
	<section id="container">

		<div class="form_register">
        <h1><i class="fas fa-user-plus"></i> Registro de Categorias</h1>
		<hr>
		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
		<form action="" method="post">
			    <label for="nombre">Nombre de Categoria</label>
			    <input type="text" name="Equipo" id="Equipo" placeholder="Nombre Completo">
			    <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Crear Categoria</button>
         </form>
		</div>
	</section>
    <?php include "includes/footer.php";?>
</body>
</html>