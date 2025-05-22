<?php
session_start();

if (isset($_SESSION["var_hs"])) 		{ $hs=$_SESSION["var_hs"];              } else {  $hs= '';   	    }
if (isset($_SESSION["var_user"])) 		{ $user=$_SESSION["var_user"];          } else {  $user= '';   	    }
if (isset($_SESSION["var_duracion"]))   { $duracion=$_SESSION["var_duracion"];  } else {  $duracion= '';   	}
if (isset($_SESSION["var_x_dia"])) 		{ $x_dia=$_SESSION["var_x_dia"];        } else {  $x_dia= '';   	}

$opc= 'ok';
if($hs=='' OR $user=='' OR $duracion=='' OR $x_dia=='')   $opc= 'er';

switch($opc){

	case 'ok':	
                include_once('./mod3_ronda_neg.php');       $RondaNeg= new RondaNegocios();
                $upd = $RondaNeg->upd_param($hs, $duracion, $x_dia, $user);
                if($upd){	$a_ico= 'success';    $a_tit= 'Parametros actualizados';	 $a_sub= '';				    }
                else{		$a_ico= 'error';      $a_tit= 'Error al Actualizar';	     $a_sub= 'Intente de nuevo';	}
				break;

	case 'er':
                $a_ico= 'error';    $a_tit= 'Error al Actualizar';	 $a_sub= 'Intente de nuevo, faltan datos';					
                break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script>