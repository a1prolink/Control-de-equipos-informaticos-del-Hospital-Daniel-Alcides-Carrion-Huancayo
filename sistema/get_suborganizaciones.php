<?php
include('../conexion.php');
$organizacion_id = $_GET['organizacion_id'];
$query = mysqli_query($conection, "SELECT id, nombre FROM Suborganizaciones WHERE organizacion_id = $organizacion_id");
$result = array();
while ($row = mysqli_fetch_assoc($query)) {
    $result[] = $row;
}
echo json_encode($result);
?>
