<?php
session_start();
date_default_timezone_set('America/Argentina/San_Juan');	
if (isset($_SESSION["var_id1"])) 		  {$id           = $_SESSION["var_id1"];         } else {$id           ='';}
if (isset($_SESSION["var_codigo1"])) 	  {$codigo_nuevo = $_SESSION["var_codigo1"];     } else {$codigo_nuevo ='';}
if (isset($_SESSION["var_codigo2"])) 	  {$codigo_viejo = $_SESSION["var_codigo2"];     } else {$codigo_viejo ='';}
if (isset($_SESSION["var_descripcion1"])) {$descripcion  = $_SESSION["var_descripcion1"];} else {$descripcion  ='';}
if (isset($_SESSION["var_patente1"]))     {$patente      = $_SESSION["var_patente1"];    } else {$patente      ='';}
if (isset($_SESSION["var_f_create1"]))    {$f_create     = $_SESSION["var_f_create1"];   } else {$f_create     ='';}
if (isset($_SESSION["var_obs"]))          {$obs          = $_SESSION["var_obs"];         } else {$obs          ='';}
if (isset($_SESSION["var_dep"]))          {$dep          = $_SESSION["var_dep"];         } else {$dep          ='';}

$opc= 'ok';
if($codigo_nuevo=='' OR $codigo_viejo=='' OR $descripcion=='' OR $patente=='' OR $dep=='')  $opc= 'er';

// vuelvo a chequear si el codigo esta o no
include_once('./mod2_moviles.php');	$Mov = new Moviles();
$msj= ' ';
if($codigo_nuevo == $codigo_viejo){
	$codigo= $codigo_viejo; // no actualiza el código.
}else{
	$codigo= $codigo_nuevo; // si actualizo el codigo entonces verfico que no sea repetido
	$existe = $Mov->tf_existe_codigo($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. '; $msj = 'existe'; }
}

switch($opc){

	case 'ok':	
        list($fecha, $hora)= explode(" ", $f_create);
		list($d, $m, $a)   = explode("/", $fecha);
		$f_create = $a.'-'.$m.'-'.$d.' '.$hora;
		$f_update = date("Y-m-d H:i:s");
		$upd_mat  = $Mov->upd_movil($id, $codigo, $descripcion, $patente, $f_create, $f_update, $obs, $dep);
        if($upd_mat){	$a_ico= 'success';   $a_tit= 'Registro Actualizado';	 $a_sub= '';     				}
        else{			$a_ico= 'error';     $a_tit= 'Error al Actualizar';	     $a_sub= 'Intente de nuevo.';	}
		break;

	case 'er':
		$a_ico= 'error';     $a_tit= 'Error al Actualizar';	     
		if($msj == 'existe'){ $a_sub= 'Codigo Repetido.'; } else { $a_sub= 'Intente de nuevo.'; }
		break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_moviles.php"; </script>
