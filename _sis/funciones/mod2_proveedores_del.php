<?php
session_start();

if (isset($_SESSION["var_id"]))  { $id= $_SESSION["var_id"];     } else {  $id= '';   	}

				$opc= 'ok';
if($id=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod2_proveedores.php');	$Prov = new Proveedores();
				$del = $Prov->del($id);
				if($del){	$a_ico= 'success';     $a_tit= 'Registro Borrado';	   $a_sub= '';					}
				else{		$a_ico= 'error';       $a_tit= 'Error al Borrar';	   $a_sub= 'Intente de nuevo.';	}
				break;

	case 'er':
				$a_ico= 'error';     $a_tit= 'Error al Borrar';	 $a_sub= 'Intente de nuevo, faltan datos.';
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_proveedores.php"; </script>