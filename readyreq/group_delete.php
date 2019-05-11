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

		$conexion = connect($hostname_localhost, $username_localhost, decrypt($password_localhost, "readyreqreadyreq"), $database_localhost, $port_localhost);

		if ($conexion == "No")
			echo makeError("No3");
		else {
			$consulta = "Delete from ReqNFuen where IdFuen = " . $cod . ";";
			$resultado = mysqli_query($conexion, $consulta);
			if (!$resultado)
				echo makeError("No4");
			else {
				$consulta = "Delete from ReqNAuto where IdAutor = " . $cod . ";";
				$resultado = mysqli_query($conexion, $consulta);
				if (!$resultado)
					echo makeError("No4");
				else {
					$consulta = "Delete from ReqIFuen where IdFuen = " . $cod . ";";
					$resultado = mysqli_query($conexion, $consulta);
					if (!$resultado)
						echo makeError("No4");
					else {
						$consulta = "Delete from ReqIAuto where IdAutor = " . $cod . ";";
						$resultado = mysqli_query($conexion, $consulta);
						if (!$resultado)
							echo makeError("No4");
						else {
							$consulta = "Delete from ReqFuen where IdFuen = " . $cod . ";";
							$resultado = mysqli_query($conexion, $consulta);
							if (!$resultado)
								echo makeError("No4");
							else {
								$consulta = "Delete from ReqAuto where IdAutor = " . $cod . ";";
								$resultado = mysqli_query($conexion, $consulta);
								if (!$resultado)
									echo makeError("No4");
								else {
									$consulta = "Delete from ActFuen where IdFuen = " . $cod . ";";
									$resultado = mysqli_query($conexion, $consulta);
									if (!$resultado)
										echo makeError("No4");
									else {
										$consulta = "Delete from ActAuto where IdAutor = " . $cod . ";";
										$resultado = mysqli_query($conexion, $consulta);
										if (!$resultado)
											echo makeError("No4");
										else {
											$consulta = "Delete from ObjFuen where IdFuen = " . $cod . ";";
											$resultado = mysqli_query($conexion, $consulta);
											if (!$resultado)
												echo makeError("No4");
											else {
												$consulta = "Delete from ObjAuto where IdAutor = " . $cod . ";";
												$resultado = mysqli_query($conexion, $consulta);
												if (!$resultado)
													echo makeError("No4");
												else {
													$consulta = "delete from grupo where Id = " . $cod . ";";
													$resultado = mysqli_query($conexion, $consulta);
													if (!$resultado)
														echo makeError("No4");
													else
														echo makeError("Si");
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			mysqli_close($conexion);
		}
	}
}
