<?php
session_start();

if (isset($_SESSION["var_cod"])) 		{ $cod= $_SESSION["var_cod"];     	} else {  $cod= '';   	}
if (isset($_SESSION["var_dep"])) 		{ $dep= $_SESSION["var_dep"];       } else {  $dep= '';   	}
if (isset($_SESSION["var_user"])) 		{ $user=$_SESSION["var_user"];      } else {  $user= '';   	}
if (isset($_SESSION["var_nom"])) 		{ $nom=$_SESSION["var_nom"];        } else {  $nom= '';   	}
	
                                                    $opc= 'ok';
if($cod=='' OR $dep=='' OR $user=='' OR $nom=='')   $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod2_aratos.php');	$Aratos = new Aratos();
                $add = $Aratos->add($cod, $dep, $user, $nom);
                if($add){	$a_ico= 'success';    $a_tit= 'Registro Agregado';	 $a_sub= '';				    }
                else{		$a_ico= 'error';      $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo';	}
				break;

	case 'er':
                $a_ico= 'error';    $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo, faltan datos';					
                break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_aratos.php"; </script>