<?php
/*
 * Autor: Arturo Balleros Albillo
 */
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

		$conexion = connect($hostname_localhost, $username_localhost, decrypt($password_localhost), $database_localhost, $port_localhost);

		if ($conexion == "No")
			echo makeError("No3");
		else {

			$consulta = "Select * from Objetivos where Id = '" . $param . "';";
			$resultado = mysqli_query($conexion, $consulta);

			if (!$resultado)
				echo makeError("No4");
			else {
				while ($registro = mysqli_fetch_array($resultado))
					$json['Resul'][] = $registro;

				$consulta = "Select g.Id as Id, g.Nombre as Nombre from Grupo g, ObjAuto oa where g.Id = oa.IdAutor and oa.IdObj = " . $param . " Order By Categoria Desc, Nombre;";
				$resultado = mysqli_query($conexion, $consulta);

				if (!$resultado)
					echo makeError("No4");
				else {
					while ($registro = mysqli_fetch_array($resultado))
						$json['Resul2'][] = $registro;

					$consulta = "Select g.Id as Id, g.Nombre as Nombre from Grupo g, ObjFuen obf where g.Id = obf.IdFuen and obf.IdObj = " . $param . " Order By Categoria Desc, Nombre;";
					$resultado = mysqli_query($conexion, $consulta);

					if (!$resultado)
						echo makeError("No4");
					else {
						while ($registro = mysqli_fetch_array($resultado))
							$json['Resul3'][] = $registro;

						$consulta = "Select o.Id as Id, o.Nombre as Nombre from Objetivos o, ObjSubobj os where o.Id = os.IdSubObj and os.IdObj = " . $param . " Order By Categoria Desc, Nombre;";
						$resultado = mysqli_query($conexion, $consulta);

						if (!$resultado)
							echo makeError("No4");
						else {
							while ($registro = mysqli_fetch_array($resultado))
								$json['Resul4'][] = $registro;
						}
					}
				}
			}
			mysqli_close($conexion);
			if (empty($json))
				echo makeError("No5");
			else
				echo json_encode($json);
		}
	}
}
