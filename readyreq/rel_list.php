<?php
include("funciones.php");

$mode = $_GET['a'];
$flagTab = $_GET['b'];
$id = $_GET['c'];
$json = array();

if (empty($mode) || empty($flagTab) || empty($id))
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

			if ($flagTab == 4) { //que me de la lista de requisitos

				$consulta = querySQL($id, $mode, $flagTab, 1); //reqnfun
				$resultado = mysqli_query($conexion, $consulta);

				if (!$resultado)
					echo makeError("No4");
				else {
					while ($registro = mysqli_fetch_array($resultado)) {
						$resulta["Id"] = $registro[0];
						$resulta["Tipo"] = 2;
						$resulta["Nombre"] = $registro[1];
						$json['Resul'][] = $resulta;
					}
					$consulta = querySQL($id, $mode, $flagTab, 2); //ReqInfo
					$resultado = mysqli_query($conexion, $consulta);

					if (!$resultado)
						echo makeError("No4");
					else {
						while ($registro = mysqli_fetch_array($resultado)) {
							$resulta["Id"] = $registro[0];
							$resulta["Tipo"] = 1;
							$resulta["Nombre"] = $registro[1];
							$json['Resul'][] = $resulta;
						}
						$consulta = querySQL($id, $mode, $flagTab, 3); //reqfun
						$resultado = mysqli_query($conexion, $consulta);

						if (!$resultado)
							echo makeError("No4");
						else {
							while ($registro = mysqli_fetch_array($resultado)) {
								$resulta["Id"] = $registro[0];
								$resulta["Tipo"] = 3;
								$resulta["Nombre"] = $registro[1];
								$json['Resul'][] = $resulta;
							}
						}
					}
				}
			} else { //para que me de lista de lo que sea menos de requisitos

				$consulta = querySQL($id, $mode, $flagTab, 0);
				$resultado = mysqli_query($conexion, $consulta);

				if (!$resultado)
					echo makeError("No4");
				else
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
