<?php
session_start();

if (isset($_SESSION["var_codigo"])) 	 {$codigo      = $_SESSION["var_codigo"];     } else {$codigo ='';     }
if (isset($_SESSION["var_descripcion"])) {$descripcion = $_SESSION["var_descripcion"];} else {$descripcion ='';}
if (isset($_SESSION["var_patente"]))     {$patente     = $_SESSION["var_patente"];    } else {$patente ='';    }
if (isset($_SESSION["var_obs"]))         {$obs         = $_SESSION["var_obs"];        } else {$obs ='';        }
if (isset($_SESSION["var_dep"]))         {$dep         = $_SESSION["var_dep"];        } else {$dep ='';        }

$opc= 'ok';
if($codigo=='' OR $descripcion=='' OR $patente=='' OR $obs=='' OR $dep=='')  $opc= 'er';

//vuelvo a chequear si el codigo esta o no
include_once('./mod2_moviles.php');	$Mov = new Moviles();
$msj= ' ';
$existe_codigo = $Mov->tf_existe_codigo($codigo);
if($existe_codigo) {$msj = 'existe'; $opc= 'er'; }

switch($opc){

	case 'ok':	
        date_default_timezone_set('America/Argentina/San_Juan');
 		$f_create = date("Y-m-d H:i:s");
 		$f_update = '';
 		$add_mov  = $Mov->add_movil($codigo, $descripcion, $patente, $f_create, $f_update, $obs, $dep);
         if($add_mov){	$a_ico= 'success';   $a_tit= 'Registro Agregado';	 $a_sub= '';					}
         else{		    $a_ico= 'error';     $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo.';	}
 		break;

 	case 'er':
		 $a_ico= 'error';    $a_tit= 'Error al Agregar';	     
 		if($msj == 'existe'){ $a_sub= 'Codigo Repetido.'; } else { $a_sub= 'Intente de nuevo, faltan datos.'; }
 		break;
 }
 $_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_moviles.php"; </script>
