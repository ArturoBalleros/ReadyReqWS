<?php
Include ("funciones.php");

$cod = $_GET['a'];
$nombre = $_GET['b'];
$descrip = $_GET['c'];
$paquet = $_GET['d'];
$precond = $_GET['e'];
$postcond = $_GET['f'];
$prior = $_GET['g'];
$urgen = $_GET['h'];
$estab = $_GET['i'];
$estad = $_GET['j'];
$categ = $_GET['k'];
$comen = $_GET['l'];
$json = array();

if(empty($cod))
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

			$consulta="update reqfun set nombre = '" . $nombre . "', descripcion = '" . $descrip . "', paquete = " . $paquet . ", precond = '" . $precond . "', 
			postcond = '" . $postcond . "', prioridad = " . $prior . ", urgencia = " . $urgen . ", estabilidad = " . $estab . ",
			estado = " . $estad . ", categoria = " . $categ . ", comentario = '" . $comen . "' where Id = " . $cod . ";";
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