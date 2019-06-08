<?php
include("funciones.php");

$cod = $_GET['a'];
$nombre = $_GET['b'];
$version = $_GET['c'];
$fecha = $_GET['d'];
$organi = $_GET['e'];
$rol = $_GET['f'];
$desarr = $_GET['g'];
$categ = $_GET['h'];
$comen = $_GET['i'];
$json = array();

if (empty($cod))
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

			$consulta = "update Grupo set nombre = '" . $nombre . "', version = '" . $version . "', fecha = '" . $fecha . "', organizacion = '" . $organi . "', 
			rol = '" . $rol . "', desarrollador = " . $desarr . ", categoria = " . $categ . ", comentario = '" . $comen . "' where Id = " . $cod . ";";
			$resultado = mysqli_query($conexion, $consulta);

			if (!$resultado)
				echo makeError("No4");
			else
				echo makeError("Si");
			mysqli_close($conexion);
		}
	}
}
