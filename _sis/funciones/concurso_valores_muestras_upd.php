<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('concurso_int.php');	$Con_int = new Concurso_int();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))               { $id               = $_POST["id"];               } else { $id               = ''; }
if (isset($_POST['fecha']))            { $fecha            = $_POST['fecha'];            } else { $fecha            = ''; }
if (isset($_POST['valor_nac']))        { $valor_nac        = $_POST['valor_nac'];        } else { $valor_nac        = ''; }
if (isset($_POST['valor_int']))        { $valor_int        = $_POST['valor_int'];        } else { $valor_int        = ''; }
if (isset($_POST['valor_int_aduana'])) { $valor_int_aduana = $_POST['valor_int_aduana']; } else { $valor_int_aduana = ''; }

// verifico los datos
$falta='';	
if($fecha=='' )             {$falta.= 'Falta Ingresar una fecha. \n';}	
if($valor_nac=='' )         {$falta.= 'Falta Ingresar valor para el concurso nacional. \n';}
if($valor_int=='')          {$falta.= 'Falta Ingresar valor para el concurso internacional. \n';}
if($valor_int_aduana== '' ) {$falta.= 'Falta Ingresar valor para gastos de aduana. \n';}

if($falta==''){
	$upd  = $Con_int->upd_valores($id, $fecha, $valor_nac, $valor_int, $valor_int_aduana);
	if($upd){ $op= 'ok'; }
	else    { $op= 'er'; }
}else{ $op= 'fa';} 



switch($op){
	case 'er': $_SESSION['var_retorno_']= 'upd_valor_er'; $_SESSION['msj_retorno_']= 'Error al actualizar los valores.'; 	        break;
	case 'ok': $_SESSION['var_retorno_']= 'upd_valor_ok'; $_SESSION['msj_retorno_']= 'Se actualizaron los valores correctamente.'; break;
	case 'fa': $_SESSION['var_retorno_']= 'upd_valor_er'; $_SESSION['msj_retorno_']= 'Error. Faltan datos: '.falta; 	        break;
}
?>
<script type="text/javascript"> window.location="../_web_concurso_internacional_valores.php"; </script>
