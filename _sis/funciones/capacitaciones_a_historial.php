<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('capacitaciones.php');	$Cap = new Capacitaciones();

if (isset($_POST["id"]))      	{ $id       = $_POST["id"];      	} else { $id= ''; 		}

			$opcion = 'ok';
if($id=='')	$opcion = 'er';

switch($opcion){
	case 'er': 	
				$_SESSION['var_retorno_']= 'capAHistorico_add_er';	$_SESSION['msj_retorno_']= 'Intente nuevamente. No pueden faltar datos.';
				break;

	case 'ok': 	
				$upd = $Cap->upd_a_historico($id);
				if($upd){	$_SESSION['var_retorno_']= 'capAHistorico_add_ok';	$_SESSION['msj_retorno_']= '';										}
				else{		$_SESSION['var_retorno_']= 'capAHistorico_add_er';	$_SESSION['msj_retorno_']= 'Error en DB, intente nuevamente.';		}
				break;
}

// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones.php"; </script>