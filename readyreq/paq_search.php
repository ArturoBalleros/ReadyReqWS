<?php
include("funciones.php");

$param = $_GET['a'];
$json = array();

if (empty($param))
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

			$consulta = "Select * from Paquetes where Id = '" . $param . "';";
			$resultado = mysqli_query($conexion, $consulta);

			if (!$resultado)
				echo makeError("No4");
			else {
				while ($registro = mysqli_fetch_array($resultado))
					$json['Resul'][] = $registro;
			}
			mysqli_close($conexion);
			if (empty($json))
				echo makeError("No5");
			else
				echo json_encode($json);
		}
	}
}
