<?php include "conexion.php"; 

// ENTRADA POR POST DE LOS VALORES
$ip_usuario = strip_tags($_POST["ip"]);
$fecha_usuario = strip_tags($_POST["fecha"]);
$registros_usuario = strip_tags($_POST["registros"]);

if($_SERVER["HTTP_X_FORWARDED_FOR"]) {
     // El usuario navega a través de un proxy
     $ip_proxy = $_SERVER["REMOTE_ADDR"]; // ip proxy
     $ip_maquina = $_SERVER["HTTP_X_FORWARDED_FOR"]; // ip de la maquina
} else {
     $ip_maquina = $_SERVER["REMOTE_ADDR"]; // No se navega por proxy
}

if(!empty($ip_maquina)){

  if(!empty($fecha_usuario) && !empty($registros_usuario)){

    $query = "CALL spAgregarRegistroUserWS('$fecha_usuario', '$registros_usuario', '$ip_proxy', '$ip_maquina')";
    $result = mysql_query($query);

    if($result){

      echo '{"RESULTADO" : "OK"}';

      // LIBERA LOS RESULTADOS
      mysql_free_result($result);

      // CERRAR CONEXIÓN
      mysql_close($link);
    }
    else{
      echo '{"RESULTADO" : "ERROR 01"}';  
    }

  }else{ 
   echo '{"SECTOR" : "ERROR 02"}';  
  }
}else{
  echo '{"RESULTADO" : "ERROR 03"}';  
}

?>