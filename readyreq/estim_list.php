<?php
include("funciones.php");
$json = array();

$param_conn = readConf();

if ($param_conn == "No")
	echo makeError("No1");
else {
	$hostname_localhost = $param_conn[0];
	$username_localhost = $param_conn[1];
	$password_localhost = $param_conn[2];
	$database_localhost = $param_conn[3];
	$port_localhost = intval($param_conn[4]);

	$conexion = connect($hostname_localhost, $username_localhost, decrypt($password_localhost), $database_localhost, $port_localhost);

	if ($conexion == "No")
		echo makeError("No2");
	else {
		//Estimaciones
		$consulta = "Select * from Estim;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//UUCPSim
		$consulta = "SELECT 'UUCPSim' as NomEst, count(*) as ValEst FROM ReqFun where Complejidad = 1;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//UUCPMed
		$consulta = "SELECT 'UUCPMed' as NomEst, count(*) as ValEst FROM ReqFun where Complejidad = 2;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//UUCPMax
		$consulta = "SELECT 'UUCPMax' as NomEst, count(*) as ValEst FROM ReqFun where Complejidad = 3;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//AWSim
		$consulta = "SELECT 'AWSim' as NomEst, count(*) as ValEst FROM Actores where Complejidad = 1;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//AWMed
		$consulta = "SELECT 'AWMed' as NomEst, count(*) as ValEst FROM Actores where Complejidad = 2;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		//AWMax
		$consulta = "SELECT 'AWMax' as NomEst, count(*) as ValEst FROM Actores where Complejidad = 3;";
		$resultado = mysqli_query($conexion, $consulta);
		if (!$resultado)
			echo makeError("No3");
		else {
			while ($registro = mysqli_fetch_array($resultado))
				$json['Resul'][] = $registro;
		}

		mysqli_close($conexion);
		if (empty($json))
			echo makeError("No4");
		else
			echo json_encode($json);
	}
}
