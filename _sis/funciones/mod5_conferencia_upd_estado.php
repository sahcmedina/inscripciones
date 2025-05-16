<?php
session_start();

if (isset($_SESSION["var_id_user"])) 	  { $id_user      = $_SESSION["var_id_user"];      } else {  $id_user     = ''; }
if (isset($_SESSION["var_id"])) 		  { $id           = $_SESSION["var_id"];     	   } else {  $id          = ''; }
if (isset($_SESSION["var_estado_nuevo"])) { $estado_nuevo = $_SESSION["var_estado_nuevo"]; } else {  $estado_nuevo= ''; }

//echo 'ACA-'.$id_user.'-'.$id.'-'.$estado_nuevo; die();

$opc= 'ok';
if($id=='' OR $estado_nuevo=='' OR $id_user=='') {$opc= 'er';}

switch($opc){
    case 'ok':	
        include_once('mod5_conferencias.php');	$Con = new Conferencias();
        date_default_timezone_set('America/Argentina/San_Juan');
        $f_update = date("Y-m-d H:i:s"); 
        $upd = $Con->upd_cambia_estado($id, $estado_nuevo, $f_update, $id_user);
        if($upd){	$a_tit= 'Registro actualizado';	  $a_sub= '';		             $a_ico= 'success';		}
        else{		$a_tit= 'Error al actualizar';	  $a_sub= 'Intente de nuevo';	 $a_ico= 'error';       }
	break;
    case 'er':
        $a_tit= 'Error al actualizar.';	$a_sub= 'Faltan datos, intente de nuevo';  $a_ico= 'error';
	break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_conf_conferencias.php"; </script>