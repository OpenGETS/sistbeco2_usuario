<?php
/*
// CONEXIÓN
$servidor  ="localhost"; 
$usuario   ="root";  
$clave     =""; 
$basedatos ="sistemaweb05052017"; 
$conexion = mysqli_connect($servidor, $usuario, $clave) or die(mysqli_error());

mysqli_select_db($basedatos, $conexion) or die(mysqli_error());

if(!$conexion){
	echo 'No hay conexión a la base de datos';
}
?>
*/

$enlace = mysql_connect("localhost", "root", "", "sistemaweb05052017");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "Error de depuración: " . mysql_connect_errno() . PHP_EOL;
    echo "Error de depuración: " . mysql_connect_error() . PHP_EOL;
    exit;
}


//echo "Éxito: Se realizó una conexión apropiada a MySQL!" . PHP_EOL;
//echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL .'<br/><br/>';

?>