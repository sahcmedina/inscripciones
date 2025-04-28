<?php
session_start();

if (isset($_SESSION["var_user"])) 		{ $user=$_SESSION["var_user"];      } else {  $user= '';   	}
if (isset($_SESSION["var_nom"])) 		{ $nom=$_SESSION["var_nom"];        } else {  $nom= '';   	}
if (isset($_SESSION["var_id"])) 		{ $id=$_SESSION["var_id"];          } else {  $id= '';   	}
	
                                       $opc= 'ok';
if($user=='' OR $nom=='' OR $id=='')   $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod3_productos.php');	$Productos = new Productos();
                $upd = $Productos->upd($id, $user, $nom);
                if($upd){	$a_ico= 'success';    $a_tit= 'Registro Actualizado';	 $a_sub= '';				    }
                else{		$a_ico= 'error';      $a_tit= 'Error al Actualizar';	 $a_sub= 'Intente de nuevo';	}
				break;

	case 'er':
                $a_ico= 'error';    $a_tit= 'Error al Actualizar';	 $a_sub= 'Intente de nuevo, faltan datos';					
                break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_admin.php"; </script>