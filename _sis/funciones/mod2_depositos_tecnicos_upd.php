<?php
session_start();

if (isset($_SESSION["var_id"])) 		{ $id= $_SESSION["var_id"];     	    } else {  $id= '';   	}
if (isset($_SESSION["var_dep"])) 		{ $dep= $_SESSION["var_dep"];     	    } else {  $dep= '';   	}
if (isset($_SESSION["var_usu_log"]))    { $usu_log= $_SESSION["var_usu_log"];   } else {  $usu_log= ''; }
if (isset($_SESSION["var_usu"])) 		{ $usu= $_SESSION["var_usu"];           } else {  $usu= '';   	}
	
                                                        $opc= 'ok';
if($id=='' OR $dep=='' OR $usu_log=='' OR $usu=='' )    $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod2_depositos_tecnicos.php');	$DepT = new Depositos_tecnicos();
                $upd = $DepT->upd($id, $dep, $usu, $usu_log);
                if($upd){	$a_ico= 'success';  $a_tit= 'Registro Actualizado';	 $a_sub= '';					}
                else{		$a_ico= 'error';    $a_tit= 'Error al Actualizar';	 $a_sub= 'Intente de nuevo';	}
				break;

	case 'er':
				$a_ico= 'error';    $a_tit= 'Error al Actualizar';	 $a_sub= 'Intente nuevamente, faltan datos.';
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_tecnicos.php"; </script>