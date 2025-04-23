<?php
session_start();

if (isset($_SESSION["var_id"])) 		 {$id          = $_SESSION["var_id"];		   }   else {$id          ='';	}
if (isset($_SESSION["var_nombre"])) 	 {$nombre      = $_SESSION["var_nombre"];	   }   else {$nombre      ='';	}
if (isset($_SESSION["var_observacion"])) {$observacion = $_SESSION["var_observacion"]; }   else {$observacion ='';	}
if (isset($_SESSION["var_usuario"])) 	 {$usuario     = $_SESSION["var_usuario"];	   }   else {$usuario     ='';	}

$opc= 'ok';
if($id=='' OR $nombre=='' OR $usuario=='' OR $observacion=='' )  $opc= 'er';

switch($opc){
	
	case 'ok':			
		include_once('./mod2_proveedores.php');	$Prov = new Proveedores();
		$upd = $Prov->upd($id, $nombre, $observacion, $usuario);
        if($upd){	$a_ico= 'success';   $a_tit= 'Registro Actualizado';	 $a_sub= '';					}
        else{		$a_ico= 'error';     $a_tit= 'Error al Actualizar';	     $a_sub= 'Intente de nuevo.';	}
		break;

	case 'er':
		$a_ico= 'error';     $a_tit= 'Error al Actualizar';	     $a_sub= 'Intente nuevamente, faltan datos.';
		break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_proveedores.php"; </script>
