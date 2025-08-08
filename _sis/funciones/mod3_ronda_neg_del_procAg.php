<?php
session_start();

if (isset($_SESSION["var_id"])){ $id= $_SESSION["var_id"];   } else {  $id= ''; }

				$opc= 'ok';
if($id=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	include_once('./mod3_rn_agenda.php');	 $RondAg = new RN_Agenda();
				$arr    = array();
				$arr    = $RondAg->gets_config($id);
				$del_v1 = true;	
				$del_v2 = true;	
				if($arr[0]['dia1'] == 1){ $del_v1 = $RondAg->aux_delVista($arr[0]['view1']); }
				if($arr[0]['dia2'] == 1){ $del_v2 = $RondAg->aux_delVista($arr[0]['view2']); }	 						
				$del_c  = $RondAg->del_config($id);			

				if($del_c && $del_v1 && $del_v2){	
					$a_ico= 'success';  $a_tit= 'Proceso borrado';	   $a_sub= '';		                        }
				else{		
					if(!$del_v1){ $a_ico= 'error';    $a_tit= 'Error al borrar Vista';	         $a_sub= $msj.'Intente de nuevo.';		}
					if(!$del_v2){ $a_ico= 'error';    $a_tit= 'Error al borrar Vista';	         $a_sub= $msj.'Intente de nuevo.';		}
					if(!$del_c) { $a_ico= 'error';    $a_tit= 'Error al borrar Configuracion';	 $a_sub= $msj.'Intente de nuevo.';		}
				}
				break;

	case 'er':	$a_ico= 'error';    $a_tit= 'Error al borrar Proceso';	 $a_sub= 'Intente de nuevo, faltan datos.';
				break;
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script>