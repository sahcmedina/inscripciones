<?php
session_start();

if (isset($_SESSION["var_id"])) 		{ $id= $_SESSION["var_id"];     	} else {  $id= '';   	}

				$opc= 'ok';
if($id=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod3_ronda_neg.php');	 $RondaNeg  = new RondaNegocios();

				$del_evento= $RondaNeg->del_evento($id);				
				$del_prod  = $RondaNeg->del_prod($id);				
				$del_ronda = $RondaNeg->del_ronda($id);	
					

				if($del_evento && $del_prod && $del_ronda){	$a_ico= 'success';  $a_tit= 'Registro borrado';	 $a_sub= '';		}
				else{		
					if(!$del_evento)	$msj='Evento (web), ';
					if(!$del_prod)	    $msj='Productos, ';
					if(!$del_ronda)	    $msj='Ronda';
					$a_ico= 'error';    $a_tit= 'Error al borrar';	 $a_sub= $msj.' Comuniquese con el Administrador del sistema.';		}
				break;

	case 'er':
				$a_ico= 'error';    $a_tit= 'Error al borrar';	 $a_sub= 'Intente de nuevo, faltan datos.';
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_admin.php"; </script>