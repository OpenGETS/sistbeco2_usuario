<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Santiago');
header('Content-type: application/vnd.ms-excel');//esta es la principal
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");


$host = 'localhost';	
$user = 'root';	
$pass = '';

$mysqli = new mysqli($host,$user,$pass);
$mysqli->select_db('sistemaweb05052017');

if(mysqli_connect_errno())
{
		$log .= date('Y-m-d_H:m:i')."INFO: No se pudo establecer la conexión con el servidor, ERROR: ".mysqli_connect_errno().".\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: No se pudo establecer la conexión con el servidor, ERROR: ".mysqli_connect_errno().".\n";
		exit();
}
else 
{
		$log .= date('Y-m-d_H:m:i')."INFO: Conexión establecida con éxito.\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Conexión establecida con éxito.\n";
}

/*Buscamos archivos en el directorio Entradas*/

	$path = "/var/www/html/sistbeco2_usuario/infoemx/USUARIOS";

	$archivos = scandir($path);

	if(!empty($archivos)){

		//echo date('Y-m-d_H:m:i')." existen archivos en el direcotrio\n";
		
		$log .= date('Y-m-d_H:m:i')."INFO: Se ha validado que exista un archivo en el directorio.\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado que exista un archivo en el directorio.\n";
		
		$cargas = array_diff($archivos, array('.', '..'));

		
		foreach ($cargas as $carga) {
			
			//echo date('Y-m-d_H:m:i')." se va a cargar archivo ".$carga."\n";

			$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
			$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
			echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
			echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";

			$mysqli->query('TRUNCATE TABLE TMP_LOGIN_USUARIOS');

			$log .= date('Y-m-d_H:m:i')."INFO: Se ha truncado la tabla TMP_LOGIN_USUARIOS.\n";
			echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha truncado la tabla TMP_LOGIN_USUARIOS.\n";

			$query = "LOAD DATA LOCAL INFILE '" . $path."/".$carga . "' INTO TABLE TMP_LOGIN_USUARIOS FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' (id_usuario, nombre_usuario, email_usuario, user_usuario, pass_usuario, activo_usuario, fk_id_acceso, rndkey_usuario, expira_usuario, imei, expira_sesion, token, fechaCreacion, pass_temporal, fk_centrog_id, fk_zona_id) SET fechaCreacion = NOW();";

			$mysqli->query($query);

			print_r($mysqli);

			$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
			echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

			rename($path.'/PROCESADOS/'.date('Y-m-d_H:m:i').'_'.$carga);

			$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta USUARIOS a la de PROCESADOS, de acuerdo al total de registros ".$casos[0].".\n";
			echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta USUARIOS a la de PROCESADOS, de acuerdo al total de registros ".$casos[0].".\n";

			
		}

	}

	else {

		$log .= date('Y-m-d_H:m:i')."INFO: No existen archivos en el directorio de USUARIOS.\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: No existen archivos en el directorio de USUARIOS.\n";
		//exit();
	}