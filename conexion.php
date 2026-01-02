<?php
$host ='localhost';
$user = 'root';
$password='E2uqZt7KD0POw';
$db = 'mantenimiento';
$conection=@mysqli_connect($host,$user,$password,$db);

if(!$conection){
	echo "Error en la conexion";
}else{
	echo "";
}
?>