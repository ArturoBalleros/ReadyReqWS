<?php
/*
 * Autor: Arturo Balleros Albillo
 */
include("funciones.php");

$nombre = $_GET['a'];
$version = $_GET['b'];
$fecha = $_GET['c'];
$organi = $_GET['d'];
$rol = $_GET['e'];
$desarr = $_GET['f'];
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

		$conexion = connect($hostname_localhost, $username_localhost, decrypt($password_localhost), $database_localhost, $port_localhost);
		if ($conexion == "No")
			echo makeError("No3");
		else {
			$consulta = "insert into Grupo (nombre,version,fecha,organizacion,rol,desarrollador,categoria,comentario) 
		values ('" . $nombre . "'," . $version . ",'" . $fecha . "','" . $organi . "','" . $rol . "'," . $desarr . "," . $categ . ",'" . $comen . "');";
			$resultado = mysqli_query($conexion, $consulta);
			if (!$resultado)
				echo makeError("No4");
			else
				echo makeError("Si");
			mysqli_close($conexion);
		}
	}
}
