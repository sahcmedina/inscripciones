<?php
session_start();

if (isset($_SESSION["var_id_e"])) { $id_e= $_SESSION["var_id_e"]; } else { $id_e= ''; }
if (isset($_SESSION["var_id_c"])) { $id_c= $_SESSION["var_id_c"]; } else { $id_c= ''; }

//echo 'ID EVENTO: '.$id_e.' ID conferencia: '.$id_c; die();

							$opc= 'ok';
if($id_e=='' OR $id_c=='')  $opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod5_conferencias.php'); 	$Con = new Conferencias();
				$del_e = $Con->del_evento($id_e);
				$del_c = $Con->del_conferencia($id_c);
				if($del_e AND $del_c ){	$a_tit= 'Registro borrado';	$a_sub= '';		             $a_ico= 'success';			}
				else{					$a_tit= 'Error al borrar';	$a_sub= 'Intente de nuevo';	 $a_ico= 'error';			}
				break;

	case 'er':
		        $a_tit= 'Error al borrar';	$a_sub= 'Faltan datos, intente de nuevo'; $a_ico= 'error';	
				break;
}
	
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_conf_conferencias.php"; </script>