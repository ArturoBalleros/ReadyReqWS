<?php
function decrypt_android($sStr, $sKey)
{
  $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $sKey, base64_decode($sStr), MCRYPT_MODE_ECB);
  $dec_s = strlen($decrypted);
  $padding = ord($decrypted[$dec_s - 1]);
  $decrypted = substr($decrypted, 0, -$padding);
  return $decrypted;
}

function decrypt_mac($string)
{
  $pass = "";
  for ($i = 0; $i <= strlen($string); $i++) {
    $pass .= substr($string, $i, 1);
    for ($j = 1; $j <= strlen($pass); $j++)
      $i++;
  }
  return $pass;
}

//Encriptar dentro del propio php
//http://quicklick.es/encriptar-y-desencriptar-en-php/
function encrypt($string)
{
  $key = "readyreqreadyreq";
  return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
}

function decrypt($string)
{
  $key = "readyreqreadyreq";
  return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
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
  $nombre_archivo = "param_conn";
  if (file_exists($nombre_archivo)) {
    $contentFile = file_get_contents($nombre_archivo);
    $contentArray = spliti("\n", $contentFile, 5);
    return $contentArray;
  } else {
    return "No";
  }
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
    if ($mode == 3) { //actores
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
      if ($flagTab == 5) { //actores
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
