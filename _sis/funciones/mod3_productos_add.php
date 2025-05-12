<?php
session_start();

if (isset($_SESSION["var_user"])) 		{ $user=$_SESSION["var_user"];      } else {  $user= '';   	}
if (isset($_SESSION["var_nom"])) 		{ $nom=$_SESSION["var_nom"];        } else {  $nom= '';   	}
	
                            $opc= 'ok';
if($user=='' OR $nom=='')   $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod3_productos.php');	$Productos = new Productos();
                $add = $Productos->add($user, $nom);
                if($add){	$a_ico= 'success';    $a_tit= 'Registro Agregado';	 $a_sub= '';				    }
                else{		$a_ico= 'error';      $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo';	}
				break;

	case 'er':
                $a_ico= 'error';    $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo, faltan datos';					
                break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_prod.php"; </script>