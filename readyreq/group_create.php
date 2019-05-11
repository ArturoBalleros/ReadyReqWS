<?php
include("funciones.php");

$nombre = $_GET['a'];
$organi = $_GET['b'];
$rol = $_GET['c'];
$desarr = $_GET['d'];
$categ = $_GET['e'];
$comen = $_GET['f'];

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
			$consulta = "insert into grupo (nombre,organizacion,rol,desarrollador,categoria,comentario) 
		values ('" . $nombre . "','" . $organi . "','" . $rol . "'," . $desarr . "," . $categ . ",'" . $comen . "');";
			$resultado = mysqli_query($conexion, $consulta);
			if (!$resultado)
				echo makeError("No4");
			else
				echo makeError("Si");
			mysqli_close($conexion);
		}
	}
}
