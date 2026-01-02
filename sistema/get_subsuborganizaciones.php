<?php
include('../conexion.php');
$suborganizacion_id = $_GET['suborganizacion_id'];
$query = mysqli_query($conection, "SELECT id, nombre FROM SubSuborganizaciones WHERE suborganizacion_id = $suborganizacion_id ORDER BY nombre ASC");
$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($result);
mysqli_close($conection);
?>
