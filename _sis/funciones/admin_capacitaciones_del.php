<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('capacitaciones.php');	$Cap = new Capacitaciones();

if (isset($_POST["id"]))      { $id       = $_POST["id"];      } else { $id      = ''; }
if (isset($_POST["usuario"])) { $usuario  = $_POST["usuario"]; } else { $usuario = ''; }

// borrar el registro de la capacitacion
$op =0;
$del_cap = $Cap->del_curso($id);        // borrar el curso
$del_req = $Cap->del_requisitos($id);   // borrar los requisitos

if(!$del_cap){ $op =1;} // error en la eliminacion del registro de la tabla capacitaciones
if(!$del_req){ $op =2;} // error en la eliminacion del registro de la tabla capacitaciones_requisitos

switch ($op){
    case 0: $_SESSION['var_retorno_']= 'curso_del_ok';		$_SESSION['msj_retorno_']= 'El Curso se Eliminó'; break;
    case 1: $_SESSION['var_retorno_']= 'curso_del_er';		$_SESSION['msj_retorno_']= 'El Curso No se pudo Eliminar'; break;
    case 2: $_SESSION['var_retorno_']= 'curso_del_er';		$_SESSION['msj_retorno_']= 'El Curso No se pudo Eliminar'; break;
}
// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones.php"; </script>