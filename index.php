<?php
$alert ='';
session_start();
if(!empty($_SESSION['active']))
{
   header('location:sistema/');
}else{
     if(!empty($_POST))
     {
        if(empty($_POST['Usuario']) || empty($_POST['clave']))
        {
              $alert = 'Ingrese su usuario y su clave';
        }else{
              require_once "conexion.php";
              $user = mysqli_real_escape_string($conection,$_POST['Usuario']);
              $pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));
             $query = mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.idrol, r.rol
                                  FROM usuarios u
                                  INNER JOIN rol r ON u.rol = r.idrol
                                  WHERE u.usuario = '$user' AND u.clave = '$pass'");
             mysqli_close($conection);
             $result = mysqli_num_rows($query);
             if($result > 0)
             {
                 $data = mysqli_fetch_array($query);
                 $_SESSION['active'] = true;
                 $_SESSION['idUser'] = $data['idusuario'];
                 $_SESSION['nombre'] = $data['nombre'];
                 $_SESSION['email'] = $data['correo'];
                 $_SESSION['user'] = $data['usuarios'];
                 $_SESSION['rol'] = $data['idrol'];
                 $_SESSION['rol_name'] = $data['rol'];
                 header('location:sistema/');
            }else{
                 $alert = "El usuario o la clave son incorrectos";
                 session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Login | Sistema Preventivo y de Manteminiento de Equipo Informaticos del Hospital Carrión </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <section id="container">
        <form action="" method="post">
            <h3>Iniciar Sesion</h3>
            <img src="img/login1.png" alt="Login">

            <input type="text" name="Usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class="alert"><?php echo isset($alert)? $alert: ''; ?></div>
            <input type="submit" value="INGRESAR">
        </form>
    </section>
</body>
</html>