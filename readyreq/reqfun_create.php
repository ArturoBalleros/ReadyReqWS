<?php
Include ("funciones.php");

$nombre = $_GET['a'];
$descrip = $_GET['b'];
$paquet = $_GET['c'];
$precond = $_GET['d'];
$postcond = $_GET['e'];
$compl = $_GET['f'];
$prior = $_GET['g'];
$urgen = $_GET['h'];
$estab = $_GET['i'];
$estad = $_GET['j'];
$categ = $_GET['k'];
$comen = $_GET['l'];


if(empty($nombre))
	echo makeError("No1");
else{
	$param_conn = readConf();
	if ($param_conn == "No")
		echo makeError("No2");
	else{
		$hostname_localhost=$param_conn[0];
		$username_localhost=$param_conn[1];
		$password_localhost=$param_conn[2];
		$database_localhost=$param_conn[3];
		$port_localhost=intval($param_conn[4]);	

		$conexion = connect($hostname_localhost,$username_localhost,decrypt($password_localhost,"readyreqreadyreq"),$database_localhost,$port_localhost);
		if ($conexion == "No") 
			echo makeError("No3");
		else{
			$consulta="insert into reqfun (nombre,descripcion,paquete,precond,postcond,complejidad,prioridad,urgencia,estabilidad,estado,categoria,comentario) 
			values ('" . $nombre . "','" . $descrip . "'," . $paquet . ",'" . $precond . "','" . $postcond . "'," . $compl . "," . $prior . "," . $urgen . "," . $estab . "," . $estad . "," . $categ . ",'" . $comen . "');";		
			$resultado=mysqli_query($conexion,$consulta);
			if (!$resultado) 
				echo makeError("No4");
			else
				echo makeError("Si");
			mysqli_close($conexion);
		}
	}
}
?>