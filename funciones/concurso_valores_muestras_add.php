<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('concurso_int.php');	$Con_int = new Concurso_int();

//------------------ RECIBO LOS DATOS PARA AGREGAR NUEVO REGISTRO ----------------------------
if (isset($_POST['fecha']))            { $fecha            = $_POST['fecha'];            } else { $fecha            = ''; }
if (isset($_POST['valor_nac']))        { $valor_nac        = $_POST['valor_nac'];        } else { $valor_nac        = ''; }
if (isset($_POST['valor_int']))        { $valor_int        = $_POST['valor_int'];        } else { $valor_int        = ''; }
if (isset($_POST['valor_int_aduana'])) { $valor_int_aduana = $_POST['valor_int_aduana']; } else { $valor_int_aduana = ''; }

// Control de datos
$falta='';	
if($fecha=='' )             {$falta.= 'Falta Ingresar una fecha. \n';}	
if($valor_nac=='' )         {$falta.= 'Falta Ingresar valor para el concurso nacional. \n';}
if($valor_int=='')          {$falta.= 'Falta Ingresar valor para el concurso internacional. \n';}
if($valor_int_aduana== '' ) {$falta.= 'Falta Ingresar valor para gastos de aduana. \n';}

if($falta==''){
	$add  = $Con_int->add_valores($fecha, $valor_nac, $valor_int, $valor_int_aduana);
	if($add){ $op= 'ok'; }
	else    { $op= 'er'; }
}else{ $op= 'fa';} 

switch ($op){
	case 'er': $_SESSION['var_retorno_']= 'add_valor_er'; $_SESSION['msj_retorno_']= 'Error al grabar los valores.'; 	        break;
	case 'ok': $_SESSION['var_retorno_']= 'add_valor_ok'; $_SESSION['msj_retorno_']= 'Se agregaron los valores correctamente.'; break;
	case 'fa': $_SESSION['var_retorno_']= 'add_valor_er'; $_SESSION['msj_retorno_']= 'Error. Faltan datos: '.falta; 	        break;
}

// retorno
?><script type="text/javascript"> window.location="../_web_concurso_internacional_valores.php"; </script>