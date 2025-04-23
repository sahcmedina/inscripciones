<?php
session_start();

if (isset($_SESSION["var_cod"])) 		{ $cod= $_SESSION["var_cod"];     	} else {  $cod= '';   	}
if (isset($_SESSION["var_prov"])) 		{ $prov= $_SESSION["var_prov"];     } else {  $prov= '';   	}
if (isset($_SESSION["var_dir"])) 		{ $dir= $_SESSION["var_dir"];     	} else {  $dir= '';   	}
if (isset($_SESSION["var_tel"])) 		{ $tel= $_SESSION["var_tel"];     	} else {  $tel= '';   	}
if (isset($_SESSION["var_user"])) 		{ $user= $_SESSION["var_user"];     } else {  $user= '';   	}
	
                                                                $opc= 'ok';
if($cod=='' OR $prov=='' OR $dir=='' OR $tel=='' OR $user=='')  $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod2_depositos.php');	$Dep = new Depositos();
                $add = $Dep->add_deposito($cod, $prov, $dir, $tel, $user);
                if($add){	$a_tit= 'Registro Agregado';	$a_sub= '';		                 $a_ico= 'success';		}
                else{		$a_tit= 'Error al Agregar';	    $a_sub= 'Intente de nuevo';		 $a_ico= 'error';	    }
				break;

	case 'er':
				$a_tit= 'Error al Agregar';	  $a_sub= 'Intente nuevamente, faltan datos.';   $a_ico= 'error';	
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_.php"; </script>