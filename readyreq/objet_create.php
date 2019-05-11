<?php
include("funciones.php");

$nombre = $_GET['a'];
$descrip = $_GET['b'];
$prior = $_GET['c'];
$urgen = $_GET['d'];
$estab = $_GET['e'];
$estad = $_GET['f'];
$categ = $_GET['g'];
$comen = $_GET['h'];

if (empty($nombre))
	echo makeError("No1");
else {
	$param_conn = readConf();
	if ($param_conn == "No")
		echo makeError("No2");
	else {
		$hostname_localhost = $param_conn[0];
		$username_localhost = $param_conn[1];
		$password_localhost = $param_conn[2];
		$database_localhost = $param_conn[3];
		$port_localhost = intval($param_conn[4]);

		$conexion = connect($hostname_localhost, $username_localhost, decrypt($password_localhost, "readyreqreadyreq"), $database_localhost, $port_localhost);
		if ($conexion == "No")
			echo makeError("No3");
		else {
			$consulta = "insert into objetivos (nombre,descripcion,prioridad,urgencia,estabilidad,estado,categoria,comentario) 
		values ('" . $nombre . "','" . $descrip . "'," . $prior . "," . $urgen . "," . $estab . "," . $estad . "," . $categ . ",'" . $comen . "');";
			$resultado = mysqli_query($conexion, $consulta);
			if (!$resultado)
				echo makeError("No4");
			else
				echo makeError("Si");
			mysqli_close($conexion);
		}
	}
}
