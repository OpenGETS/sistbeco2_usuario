<?php 
include "conexion.php";

// ENTRADA POR POST DE LOS VALORES
$flat = strip_tags($_POST["lat"]);
$flon= strip_tags($_POST["lon"]);
$comuna = strip_tags($_POST["comuna"]);
$ip = strip_tags($_POST["ip_from"]);

// CASO 1: QUE VENGAN TODOS LOS VALORES
if(!empty($flat) && !empty($flon) && !empty($comuna)){

  $query = "CALL spConsultaSector('$flat','$flon','$comuna')";

  $result = mysqli_query($enlace,$query);
  $line = mysqli_fetch_array($result);
  $json = array('SECTOR'=>$line['SECTOR']);
  echo json_encode($json);

  // LIBERA LOS RESULTADOS
  mysqli_free_result($result);

  // CERRAR CONEXIÓN
  mysqli_close($link);

}else{ 
 echo '{"SECTOR" : "-1"}';  
}

?>