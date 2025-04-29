<?php
session_start();

if (isset($_SESSION["var_id"])) 		{ $id= $_SESSION["var_id"];     	} else {  $id= '';   	}

				$opc= 'ok';
if($id=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod4_sectores.php');	$Sectores = new Sectores();
				$del = $Sectores->del($id);
				if($del){	$a_ico= 'success';  $a_tit= 'Registro borrado';	 $a_sub= '';						}
				else{		$a_ico= 'error';    $a_tit= 'Error al borrar';	 $a_sub= 'Intente de nuevo.';		}
				break;

	case 'er':
				$a_ico= 'error';    $a_tit= 'Error al borrar';	 $a_sub= 'Intente de nuevo, faltan datos.';
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_inv_sectores.php"; </script>