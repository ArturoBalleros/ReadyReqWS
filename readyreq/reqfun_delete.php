<?php
Include ("funciones.php");

$cod = $_GET['a'];

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
			$consulta="Delete from ReqAct where IdReq = " . $cod . ";";
			$resultado=mysqli_query($conexion,$consulta);
			if (!$resultado) 
				echo makeError("No4");
			else{
				$consulta="Delete from ReqAuto where IdReq = " . $cod . ";";
				$resultado=mysqli_query($conexion,$consulta);
				if (!$resultado) 
					echo makeError("No4");
				else{
					$consulta="Delete from ReqFuen where IdReq = " . $cod . ";";
					$resultado=mysqli_query($conexion,$consulta);
					if (!$resultado) 
						echo makeError("No4");
					else{
						$consulta="Delete from ReqObj where IdReq = " . $cod . ";";
						$resultado=mysqli_query($conexion,$consulta);
						if (!$resultado) 
							echo makeError("No4");
						else{
							$consulta="Delete from ReqSecNor where IdReq = " . $cod . ";";
							$resultado=mysqli_query($conexion,$consulta);
							if (!$resultado) 
								echo makeError("No4");
							else{
								$consulta="Delete from ReqSecExc where IdReq = " . $cod . ";";
								$resultado=mysqli_query($conexion,$consulta);
								if (!$resultado) 
									echo makeError("No4");
								else{
									$consulta="Delete from ReqNReqR where TipoReq = 3 and IdReqR = " . $cod . ";";
									$resultado=mysqli_query($conexion,$consulta);
									if (!$resultado) 
										echo makeError("No4");
									else{
										$consulta="Delete from ReqIReqR where TipoReq = 3 and IdReqR = " . $cod . ";";
										$resultado=mysqli_query($conexion,$consulta);
										if (!$resultado) 
											echo makeError("No4");
										else{
											$consulta="Delete from ReqReqR where IdReq = " . $cod . ";";
											$resultado=mysqli_query($conexion,$consulta);
											if (!$resultado) 
												echo makeError("No4");
											else{
												$consulta="Delete from ReqFun where Id = " . $cod . ";";
												$resultado=mysqli_query($conexion,$consulta);
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
			mysqli_close($conexion);
		}
	}
}
?>