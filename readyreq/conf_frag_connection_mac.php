<?php
include("funciones.php");

if (!empty($_GET['a']) && !empty($_GET['b']) && !empty($_GET['c']) && !empty($_GET['d']) && !empty($_GET['e'])) {

	$hostname_localhost = $_GET['a'];
	$username_localhost = $_GET['b'];
	$password_localhost = $_GET['c'];
	$database_localhost = $_GET['d'];
	$port_localhost = $_GET['e'];

	$conexion = connect($hostname_localhost, $username_localhost, decrypt_mac($password_localhost), $database_localhost, $port_localhost);

	if ($conexion == "No")
		echo makeError("No2");
	else {
		mysqli_close($conexion);
		if (writeConf($hostname_localhost, $username_localhost, decrypt_mac($password_localhost), $database_localhost, $port_localhost) == "No") {
			echo makeError("No3");
			exit;
		}
		echo makeError("Si");
	}
} else
	echo makeError("No1");
