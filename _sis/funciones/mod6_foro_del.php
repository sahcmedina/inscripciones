<?php
session_start();

if (isset($_SESSION["var_id_e"])) { $id_e= $_SESSION["var_id_e"]; } else { $id_e= ''; }
if (isset($_SESSION["var_id_f"])) { $id_f= $_SESSION["var_id_f"]; } else { $id_f= ''; }

							$opc= 'ok';
if($id_e=='' OR $id_f=='')  $opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod6_foros.php'); 	$For = new Foros();
				$del_e = $For->del_evento($id_e);
				$del_f = $For->del_foro($id_f);
				if($del_e AND $del_f ){	$a_tit= 'Registro borrado';	$a_sub= '';		             $a_ico= 'success';			}
				else{					$a_tit= 'Error al borrar';	$a_sub= 'Intente de nuevo';	 $a_ico= 'error';			}
				break;

	case 'er':
		        $a_tit= 'Error al borrar';	$a_sub= 'Faltan datos, intente de nuevo'; $a_ico= 'error';	
				break;
}
	
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_foros_.php"; </script>