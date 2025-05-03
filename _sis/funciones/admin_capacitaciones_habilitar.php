<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('capacitaciones.php');	$Cap = new Capacitaciones();

if (isset($_POST["id_curso"])) { $id = $_POST["id_curso"];   } else { $id = '';     }
if (isset($_POST["estado"]))   { $estado = $_POST["estado"]; } else { $estado = ''; }
 
                            $op= 1;
if($id=='' OR $estado=='')  $op= 0;

switch ($op){
    case 1 : 
            if($estado == 'nor')    $est= 0;
            if($estado == 'hab')    $est= 1;
            if($estado == 'des')    $est= 2;
            $mdf = $Cap->mdf_estado_formInscripcion($id, $est);
            if($mdf){
                $_SESSION['var_retorno_']= 'curso_mdfEstadoForm_ok';		$_SESSION['msj_retorno_']= '';  
            }else{
                $_SESSION['var_retorno_']= 'curso_mdfEstadoForm_er';		$_SESSION['msj_retorno_']= 'No se pudo cambiar el estado del Formulario de Inscripción, intente de nuevo.';  
            }            
            break;
    case 0 : 
            $_SESSION['var_retorno_']= 'curso_mdfEstadoForm_er';		    $_SESSION['msj_retorno_']= 'Faltaron datos. Intente de nuevo.';         
            break;
    default:
            break; 
}
// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones_habilitacion.php"; </script>