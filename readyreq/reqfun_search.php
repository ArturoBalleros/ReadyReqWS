<?php
Include ("funciones.php");

$param = $_GET['a'];
$json = array();

if(empty($param))
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

			$consulta="Select * from reqfun where Id = '" . $param . "';";
			$resultado=mysqli_query($conexion,$consulta);

			if (!$resultado) 
				echo makeError("No4");
			else{
				while($registro=mysqli_fetch_array($resultado))
					$json['Resul'][]=$registro;	

				$consulta="Select g.Id as Id, g.Nombre as Nombre from Grupo g, ReqAuto r where g.Id = r.IdAutor and r.IdReq = " . $param . " Order By Categoria Desc, Nombre;";
				$resultado=mysqli_query($conexion,$consulta);

				if (!$resultado) 
					echo makeError("No4");
				else{
					while($registro=mysqli_fetch_array($resultado))
						$json['Resul2'][]=$registro;		

					$consulta="Select g.Id as Id, g.Nombre as Nombre from Grupo g, ReqFuen r where g.Id = r.IdFuen and r.IdReq = " . $param . " Order By Categoria Desc, Nombre;";
					$resultado=mysqli_query($conexion,$consulta);

					if (!$resultado) 
						echo makeError("No4");
					else{
						while($registro=mysqli_fetch_array($resultado))
							$json['Resul3'][]=$registro;	

						$consulta="Select o.Id as Id, o.Nombre as Nombre from Objetivos o, ReqObj r where o.Id = r.IdObj and r.IdReq = " . $param . " Order By Categoria Desc, Nombre;";
						$resultado=mysqli_query($conexion,$consulta);

						if (!$resultado) 
							echo makeError("No4");
						else{
							while($registro=mysqli_fetch_array($resultado))
								$json['Resul4'][]=$registro;	

							$consulta="Select a.Id as Id, a.Nombre as Nombre from Actores a, ReqAct r where a.Id = r.IdAct and r.IdReq = " . $param . " Order By Categoria Desc, Nombre;";
							$resultado=mysqli_query($conexion,$consulta);

							if (!$resultado) 
								echo makeError("No4");
							else{
								while($registro=mysqli_fetch_array($resultado))
									$json['Resul5'][]=$registro;	

								$consulta="Select rn.Id as Id, r.TipoReq as Tipo, rn.Nombre as Nombre from ReqInfo rn, ReqReqR r where rn.Id = r.IdReqr and r.IdReq = " . $param . " and r.TipoReq = 1 Order By Categoria Desc, Nombre;";
								$resultado=mysqli_query($conexion,$consulta);

								if (!$resultado) 
									echo makeError("No4");
								else{
									while($registro=mysqli_fetch_array($resultado))
										$json['Resul6'][]=$registro;	

									$consulta="Select rn.Id as Id, r.TipoReq as Tipo, rn.Nombre as Nombre from ReqNFunc rn, ReqReqR r where rn.Id = r.IdReqr and r.IdReq = " . $param . " and r.TipoReq = 2 Order By Categoria Desc, Nombre;";
									$resultado=mysqli_query($conexion,$consulta);

									if (!$resultado) 
										echo makeError("No4");
									else{
										while($registro=mysqli_fetch_array($resultado))
											$json['Resul6'][]=$registro;

										$consulta="Select rn.Id as Id, r.TipoReq as Tipo, rn.Nombre as Nombre from ReqFun rn, ReqReqR r where rn.Id = r.IdReqr and r.IdReq = " . $param . " and r.TipoReq = 3 Order By Categoria Desc, Nombre;";
										$resultado=mysqli_query($conexion,$consulta);

										if (!$resultado) 
											echo makeError("No4");
										else{
											while($registro=mysqli_fetch_array($resultado))
												$json['Resul6'][]=$registro;

											$consulta="Select Descrip from ReqSecNor where IdReq = " . $param . ";";
											$resultado=mysqli_query($conexion,$consulta);

											if (!$resultado) 
												echo makeError("No4");
											else{
												while($registro=mysqli_fetch_array($resultado))
													$json['Resul7'][]=$registro;	

												$consulta="Select Descrip from ReqSecExc where IdReq = " . $param . ";";
												$resultado=mysqli_query($conexion,$consulta);

												if (!$resultado) 
													echo makeError("No4");
												else{
													while($registro=mysqli_fetch_array($resultado))
														$json['Resul8'][]=$registro;	

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
			if (empty( $json))
				echo makeError("No5");
			else
				echo json_encode($json);
		}
	}
}
?>