<?php
session_start();

if (isset($_SESSION["var_id_user"]))   { $id_user = $_SESSION["var_id_user"];   } else {  $id_user = ''; }
if (isset($_SESSION["var_id"])) 	   { $id = $_SESSION["var_id"];     	    } else {  $id = '';      }
if (isset($_SESSION["var_estado"]))    { $estado = $_SESSION["var_estado"];     } else {  $estado= '';   }

$opc= 'ok';
if($id=='' OR $estado=='' OR $id_user=='') {$opc= 'er';}

switch($opc){

    case 'ok':	
        include_once('./mod3_ronda_neg.php');	$RN = new RondaNegocios();
        date_default_timezone_set('America/Argentina/San_Juan');
        $f_update = date("Y-m-d H:i:s"); 
        $upd      = $RN->upd_estado($id, $estado, $f_update, $id_user);
        if($upd){	$a_tit= 'Estado actualizado';	          $a_sub= '';		             $a_ico= 'success';		}
        else{		$a_tit= 'Error al actualizar Estado';	  $a_sub= 'Intente de nuevo';	 $a_ico= 'error';       }
	    break;

    case 'er':
        $a_tit= 'Error al actualizar.';	$a_sub= 'Faltan datos, intente de nuevo';  $a_ico= 'error';
	    break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_neg_admin.php"; </script>