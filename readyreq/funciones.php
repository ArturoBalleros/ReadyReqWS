<?php
function encrypt($string)
{
  $claveEncriptada = "";
  $cont = 0;
  $valoresAleatorios = ['a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'j', 'J', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9']; 
  for ($i = 0; $i < strlen($string); $i++) {
    $claveEncriptada .= substr($string, $i, 1);
    $cont++;
    for ($j = 0; $j < $cont; $j++)
        $claveEncriptada .= $valoresAleatorios[mt_rand(0, count($valoresAleatorios) - 1)];    
  }
  return $claveEncriptada;
}

function decrypt($string)
{
  $pass = "";
  for ($i = 0; $i <= strlen($string); $i++) {
    $pass .= substr($string, $i, 1);
    for ($j = 1; $j <= strlen($pass); $j++)
      $i++;
  }
  return $pass;
}

function connect($hostname_localhost, $username_localhost, $password_localhost, $database_localhost, $port_localhost)
{
  $enlace = mysqli_connect($hostname_localhost, $username_localhost, $password_localhost, $database_localhost, $port_localhost);
  if (!$enlace)
    return "No";
  else {
    mysqli_set_charset($enlace, "utf8");
    return $enlace;
  }
}

function writeConf($hostname_localhost, $username_localhost, $password_localhost, $database_localhost, $port_localhost)
{
  $nombre_archivo = "param_conn";
  file_exists($nombre_archivo);
  if ($archivo = fopen($nombre_archivo, "w+")) {
    fwrite($archivo, $hostname_localhost . "\n");
    fwrite($archivo, $username_localhost . "\n");
    fwrite($archivo, encrypt($password_localhost) . "\n");
    fwrite($archivo, $database_localhost . "\n");
    fwrite($archivo, $port_localhost . "\n");
    fclose($archivo);
    return "Si";
  } else {
    return "No";
  }
}

function readConf()
{
    $file = fopen("param_conn", "r"); 
    $contentFile = array();
    $cont = 0;
    while(!feof($file))
    {
        array_push($contentFile, fgets($file));
        $contentFile[$cont] = substr($contentFile[$cont], 0, strlen($contentFile[$cont])-1);
        $cont++;
    }
    fclose($file);
    return $contentFile;
}

function makeError($numError)
{
  $resulta["a"] = $numError;
  $json['Resul'][] = $resulta;
  return json_encode($json);
}

function querySQL($id, $mode, $flagTab, $flagReq)
{
  if ($flagReq == 0) { //tab q no sean requisitos
    if ($mode == 2) { //objetivos
      if ($flagTab == 1) { //autores
        return "Select Id,Nombre from Grupo where Id not IN (select IdAutor from ObjAuto where idObj = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 2) { //fuentes
        return "Select Id,Nombre from Grupo where Id not IN (select IdFuen from ObjFuen where idObj = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 3) { //objetivos
        return "Select Id,Nombre from Objetivos where Id not IN (select idSubobj from ObjSubobj where idObj = " . $id . ") and Id <> " . $id . " Order By Categoria Desc, Nombre;";
      }
    }
    if ($mode == 3) { //Actores
      if ($flagTab == 1) { //autores
        return "Select Id,Nombre from Grupo where Id not IN (select IdAutor from ActAuto where idAct = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 2) { //fuentes
        return "Select Id,Nombre from Grupo where Id not IN (select IdFuen from ActFuen where idAct = " . $id . ") Order By Categoria Desc, Nombre;";
      }
    }
    if ($mode == 4) { //reqfun
      if ($flagTab == 1) { //autores
        return "Select Id,Nombre from Grupo where Id not IN (select IdAutor from ReqAuto where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 2) { //fuentes
        return "Select Id,Nombre from Grupo where Id not IN (select IdFuen from ReqFuen where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 3) { //objetivos
        return "Select Id,Nombre from Objetivos where Id not IN (select idObj from ReqObj where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 5) { //Actores
        return "Select Id,Nombre from Actores where Id not IN (select IdAct from ReqAct where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
    }
    if ($mode == 5) { //reqnfun
      if ($flagTab == 1) { //autores
        return "Select Id,Nombre from Grupo where Id not IN (select IdAutor from ReqNAuto where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 2) { //fuentes
        return "Select Id,Nombre from Grupo where Id not IN (select IdFuen from ReqNFuen where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 3) { //objetivos
        return "Select Id,Nombre from Objetivos where Id not IN (select idObj from ReqNObj where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
    }
    if ($mode == 6) { //reqinfo
      if ($flagTab == 1) { //autores
        return "Select Id,Nombre from Grupo where Id not IN (select IdAutor from ReqIAuto where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 2) { //fuentes
        return "Select Id,Nombre from Grupo where Id not IN (select IdFuen from ReqIFuen where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
      if ($flagTab == 3) { //objetivos
        return "Select Id,Nombre from Objetivos where Id not IN (select idObj from ReqIObj where idReq = " . $id . ") Order By Categoria Desc, Nombre;";
      }
    }
  }
  //ej 1 y 4 devuel los requisitos NO funcionales de un requisito funcional dependiendo el id
  if ($flagReq == 1) { //reqnfun
    if ($mode == 4) { //reqfun
      return "Select Id,Nombre from ReqNFunc where Id not IN (select IdReqr from ReqReqR where idReq = " . $id . " and TipoReq = 2) Order By Categoria Desc, Nombre;";
    }
    if ($mode == 5) { //reqnfun
      return "Select Id,Nombre from ReqNFunc where Id not IN (select IdReqr from ReqNReqR where idReq = " . $id . " and TipoReq = 2) and Id <> " . $id . " Order By Categoria Desc, Nombre;";
    }
    if ($mode == 6) { //reqinfo
      return "Select Id,Nombre from ReqNFunc where Id not IN (select IdReqr from ReqIReqR where idReq = " . $id . " and TipoReq = 2) Order By Categoria Desc, Nombre;";
    }
  }
  if ($flagReq == 2) { //reqinfo
    if ($mode == 4) { //reqfun
      return "Select Id,Nombre from ReqInfo where Id not IN (select IdReqr from ReqReqR where idReq = " . $id . " and TipoReq = 1) Order By Categoria Desc, Nombre;";
    }
    if ($mode == 5) { //reqnfun
      return "Select Id,Nombre from ReqInfo where Id not IN (select IdReqr from ReqNReqR where idReq = " . $id . " and TipoReq = 1) Order By Categoria Desc, Nombre;";
    }
    if ($mode == 6) { //reqinfo
      return "Select Id,Nombre from ReqInfo where Id not IN (select IdReqr from ReqIReqR where idReq = " . $id . " and TipoReq = 1) and Id <> " . $id . " Order By Categoria Desc, Nombre;";
    }
  }
  if ($flagReq == 3) { //reqfun
    if ($mode == 4) { //reqfun
      return "Select Id,Nombre from ReqFun where Id not IN (select IdReqr from ReqReqR where idReq = " . $id . " and TipoReq = 3) and Id <> " . $id . " Order By Categoria Desc, Nombre;";
    }
    if ($mode == 5) { //reqnfun
      return "Select Id,Nombre from ReqFun where Id not IN (select IdReqr from ReqNReqR where idReq = " . $id . " and TipoReq = 3) Order By Categoria Desc, Nombre;";
    }
    if ($mode == 6) { //reqinfo
      return "Select Id,Nombre from ReqFun where Id not IN (select IdReqr from ReqIReqR where idReq = " . $id . " and TipoReq = 3) Order By Categoria Desc, Nombre;";
    }
  }
}
