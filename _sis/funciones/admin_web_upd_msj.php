<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('web.php');	$Web = new Web();


if (isset($_POST["descripcion"]))     { $msj = $_POST["descripcion"];     } else { $msj = ''; }

                  $opcion ='ok';
if($msj == '')    $opcion ='er'; 

switch ($opcion){
    case 'er':  $_SESSION['var_retorno_']= 'upd_web_er';		$_SESSION['msj_retorno_']= 'Falta ingresar una breve descripción para mostrar';
                break;  

    case 'ok':
        $upd= $Web->upd_($msj);
        if($upd){     $_SESSION['var_retorno_']= 'upd_web_ok';		$_SESSION['msj_retorno_']= '';                                          }
        else{         $_SESSION['var_retorno_']= 'upd_web_er';		$_SESSION['msj_retorno_']= 'No se pudo actualizar. Intente mas tarde';  }
    break;
}

// retorno
?><script type="text/javascript"> window.location="../_admin_web.php"; </script>