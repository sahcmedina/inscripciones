<?php
session_start();

if (isset($_SESSION["var_nombre"])) { $nombre      = $_SESSION["var_nombre"]; } else { $nombre= '';  }
if (isset($_SESSION["var_obser"]))  { $observacion = $_SESSION["var_obser"];  } else { $observacion= '';  }
if (isset($_SESSION["var_user"])) 	{ $user        = $_SESSION["var_user"];   } else { $user= '';   	}
	
                                                    $opc= 'ok';
if($nombre=='' OR $user=='' OR $observacion=='')    $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod2_proveedores.php');	$Prov = new Proveedores();
                $add = $Prov->add($nombre, $observacion, $user);
                if($add){	$a_ico= 'success';   $a_tit= 'Registro Agregado';	 $a_sub= '';					}
                else{		$a_ico= 'error';     $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo.';	}
				break;

	case 'er':
                $a_ico= 'error';     $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo, faltan datos.';
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_proveedores.php"; </script>