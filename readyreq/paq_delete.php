<?php
include("funciones.php");

$cod = $_GET['a'];

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
			$consulta = "update ReqFun set Paquete = 1 where Paquete = " . $cod . ";";
			$resultado = mysqli_query($conexion, $consulta);
			if (!$resultado)
				echo makeError("No4");
			else {
				$consulta = "delete from Paquetes where Id = " . $cod . ";";
				$resultado = mysqli_query($conexion, $consulta);
				if (!$resultado)
					echo makeError("No4");
				else
					echo makeError("Si");
			}
			mysqli_close($conexion);
		}
	}
}
