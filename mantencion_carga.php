<?php
/* Error reporting 

include("funciones_sftp.php");

// definir algunas variables
$ftp_user_name = 'beco';
$ftp_user_pass ='4be#40co';
$ftp_server ='172.16.7.7';

$local_file1 = '/infoemx/dumps/carga_infoemx_sal_dir_' . date('Ydm',strtotime("now")) . '.txt';
$local_file2 = '/infoemx/dumps/carga_infoemx_sal_fih_' . date('Ydm',strtotime("now")) . '.txt';
$local_file3 = '/infoemx/dumps/carga_infoemx_sal_mae_' . date('Ydm',strtotime("now")) . '.txt';
$local_file4 = '/infoemx/dumps/login_accesos_' . date('Ydm',strtotime("now")) . '.txt';
$local_file5 = '/infoemx/dumps/login_usuarios_' . date('Ydm',strtotime("now")) . '.txt';

$server_file1 = '/infoemx/dumps/carga_infoemx_sal_dir_' . date('Ydm',strtotime("now")) . '.txt';
$server_file2 = '/infoemx/dumps/carga_infoemx_sal_fih_' . date('Ydm',strtotime("now")) . '.txt';
$server_file3 = '/infoemx/dumps/carga_infoemx_sal_mae_' . date('Ydm',strtotime("now")) . '.txt';
$server_file4 = '/infoemx/dumps/login_accesos_' . date('Ydm',strtotime("now")) . '.txt';
$server_file5 = '/infoemx/dumps/login_usuarios_' . date('Ydm',strtotime("now")) . '.txt';

//ir a buscar la carga de hoy
get_files_beco($ftp_server, $ftp_user_name, $ftp_user_pass, 
	$server_file1, $server_file2, $server_file3, $server_file4, $server_file5,
	$local_file1, $local_file2, $local_file3, $local_file4, $local_file5);*/


//$ip_usuario = strip_tags($_POST["ip"]);
//$fecha_usuario = strip_tags($_POST["fecha"]);

$fecha_usuario = '20170817';

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
date_default_timezone_set('America/Santiago');
header('Content-type: application/vnd.ms-excel');//esta es la principal
header("Content-Disposition: attachment; filename=log_mantencion_carga.xls");
header("Pragma: no-cache");
header("Expires: 0");

/*require 'PHPExcel.php';
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
*/

/*
$log = "log.txt";
$time = time();
$fecha = date("d-m-Y H:i:s", $time);
file_put_contents($log,"Hora de Inicio ".$fecha);*/

/*$connect = mysqli_connect('localhost','auditordb','Auditor_2016');
mysqli_select_db($connect,'auditordb');

if(!$connect){
    echo 'no me pude conectar';
}*/

$host = '127.0.0.1';	
$user = 'root';	
$pass = '';
$log = '';	

$mysqli = new mysqli($host,$user,$pass);
$mysqli->select_db('normalizacion_beco_web');

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

/*
$diaActual = date('Ymd');
$inicioMes = date('Ym').'01';

$fechas = compact('diaActual','inicioMes');*/

//$fecha_usuario = '20170802';

/*Buscamos archivos en el directorio Entradas*/

	/* INFOEMX SAL DIR */

	$path = "/var/www/html/sistbeco2_usuario/infoemx/dumps";

	//$archivos = scandir($path);
	$archivos = scandir($path);

	if(!empty($archivos)){

		//echo date('Y-m-d_H:m:i')." existen archivos en el direcotrio\n";
		
		$log .= date('Y-m-d_H:m:i')."INFO: Se ha validado que exista un archivo en el directorio.\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado que exista un archivo en el directorio.\n";
		
		$cargas = array_diff($archivos, array('.', '..'));
		
		foreach ($cargas as $carga) {

			if($carga == 'carga_infoemx_sal_dir_'.$fecha_usuario.'.txt'){

				$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";	

				$query = "TRUNCATE TABLE carga_infoemx_sal_dir";

				$mysqli->query($query);

				$query = "LOAD DATA LOCAL INFILE '".$path."/carga_infoemx_sal_dir_".$fecha_usuario.".txt' INTO TABLE carga_infoemx_sal_dir FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'";

				$mysqli->query($query);

				$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

				rename($path."/".$carga, 'procesados/'.$carga);

				$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";					
			}

			if($carga == 'carga_infoemx_sal_fih_'.$fecha_usuario.'.txt'){

				$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";	

				$query = "TRUNCATE TABLE carga_infoemx_sal_fih";

				$mysqli->query($query);		

				$query = "LOAD DATA LOCAL INFILE '".$path."/carga_infoemx_sal_fih_".$fecha_usuario.".txt' INTO TABLE carga_infoemx_sal_fih FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'";

				$mysqli->query($query);

				$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

				rename($path."/".$carga, 'procesados/'.$carga);

				$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";	
			}

			if($carga == 'carga_infoemx_sal_mae_'.$fecha_usuario.'.txt'){

				$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el 
				archivo ".$carga." a la base de datos.\n";			

				$query = "TRUNCATE TABLE carga_infoemx_sal_mae";

				$mysqli->query($query);

				$query = "LOAD DATA LOCAL INFILE '".$path."/carga_infoemx_sal_mae_".$fecha_usuario.".txt' INTO TABLE carga_infoemx_sal_mae FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'";

				$mysqli->query($query);

				$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

				rename($path."/".$carga, 'procesados/'.$carga);

				$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";	
			}

			if($carga == 'login_accesos_'.$fecha_usuario.'.txt'){

				$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el 
				archivo ".$carga." a la base de datos.\n";		

				$query = "TRUNCATE TABLE login_accesos";

				$mysqli->query($query);	

				$query = "LOAD DATA LOCAL INFILE '".$path."/login_accesos_".$fecha_usuario.".txt' INTO TABLE login_accesos FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'";

				$mysqli->query($query);

				$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

				rename($path."/".$carga, 'procesados/'.$carga);

				$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";	
			}

			if($carga == 'login_usuarios_'.$fecha_usuario.'.txt'){

				$log .= date('Y-m-d_H:m:i')." INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				$log .= date('Y-m-d_H:m:i')." INFO: Comenzará a cargarse el archivo ".$carga." a la base de datos.\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha validado exitosamente el archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Comenzará a cargarse el 
				archivo ".$carga." a la base de datos.\n";		

				$query = "TRUNCATE TABLE login_usuarios";

				$mysqli->query($query);		

				$query = "LOAD DATA LOCAL INFILE '".$path."/login_usuarios_".$fecha_usuario.".txt' INTO TABLE login_usuarios FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'";

				$mysqli->query($query);

				$log .= date('Y-m-d_H:m:i')."INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se ha cargado la base exitosamente, de acuerdo al archivo ".$carga.".\n";

				rename($path."/".$carga, 'procesados/'.$carga);

				$log .= date('Y-m-d_H:m:i')."INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";
				echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: Se movio el archivo de la carpeta dumps a la de [procesados].\n";	
			}
			
		}

	}

	else {

		$log .= date('Y-m-d_H:m:i')."INFO: No existen archivos en el directorio de [procesados].\n";
		echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: No existen archivos en el directorio de [procesados].\n";
		//exit();
	}

	echo 'HORA: '.date('Y-m-d_H:m:i').", INFO: PROCESO TERMINADO CON ÉXITO.\n";

/*
$log = "log.txt";
$time = time();
$fecha = date("d-m-Y H:i:s", $time);
file_put_contents($log,"Hora de Termino ".$fecha);*/
