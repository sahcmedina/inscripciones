<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('capacitaciones.php');	$Cap = new Capacitaciones();


if (isset($_POST["id_curso"]))     { $id_curso     = $_POST["id_curso"];     } else { $id_curso     = ''; }
if (isset($_POST["usuario"]))      { $usuario      = $_POST["usuario"];      } else { $usuario      = ''; }
//if (isset($_POST["web_nombre"]))   { $web_nombre   = $_POST["web_nombre"];   } else { $web_nombre   = ''; }
if (isset($_POST["web_descrip"]))  { $web_descrip  = $_POST["web_descrip"];  } else { $web_descrip  = ''; }
if (isset($_POST["web_duracion"])) { $web_duracion = $_POST["web_duracion"]; } else { $web_duracion = ''; }

$opcion='ok';

//if($web_nombre == '')   { $opcion ='falta_nombre'; };
if($web_descrip == '')  { $opcion ='falta_descrip'; };
if($web_duracion == '') { $opcion ='falta_duracion'; };

switch ($opcion){
    // case 'falta_nombre': $_SESSION['var_retorno_']= 'curso_upd_web_er';		$_SESSION['msj_retorno_']= 'Falta ingresar un nombre para mostrar';
    // break;
    case 'falta_descrip': $_SESSION['var_retorno_']= 'curso_upd_web_er';		$_SESSION['msj_retorno_']= 'Falta ingresar una breve descripcón para mostrar';
    break;    
    case 'falta_duracion': $_SESSION['var_retorno_']= 'curso_upd_web_er';		$_SESSION['msj_retorno_']= 'Falta ingresar la duracion para mostrar';
    break;

    case 'ok':
        $upd= $Cap->upd_datos_curso_mostrar_web($id_curso, $usuario, $web_descrip, $web_duracion);
        if($upd){
            $_SESSION['var_retorno_']= 'curso_upd_web_ok';		$_SESSION['msj_retorno_']= 'El Curso se Actualizó Satisfactoriamente';
        }else{
            $_SESSION['var_retorno_']= 'curso_upd_web_er';		$_SESSION['msj_retorno_']= 'No se pudo actualizar. Intente mas tarde';
        }
    break;
}

// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones.php"; </script>