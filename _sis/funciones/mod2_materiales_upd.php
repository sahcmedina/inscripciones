<?php
session_start();
date_default_timezone_set('America/Argentina/San_Juan');	
if (isset($_SESSION["var_id1"])) 		    {$id            = $_SESSION["var_id1"];}            else {$id ='';}
if (isset($_SESSION["var_codigo1"])) 		{$codigo_nuevo  = $_SESSION["var_codigo1"];}        else {$codigo_nuevo ='';}
if (isset($_SESSION["var_codigo2"])) 		{$codigo_viejo  = $_SESSION["var_codigo2"];}        else {$codigo_viejo ='';}
if (isset($_SESSION["var_nombre1"]))        {$nombre        = $_SESSION["var_nombre1"];}        else {$nombre ='';}
if (isset($_SESSION["var_cant_min1"]))      {$cant_min      = $_SESSION["var_cant_min1"];}      else {$cant_min ='';}
if (isset($_SESSION["var_unidad_medida1"])) {$unidad_medida = $_SESSION["var_unidad_medida1"];} else {$unidad_medida ='';}
if (isset($_SESSION["var_min_scrap1"]))     {$cant_scrap    = $_SESSION["var_min_scrap1"];}     else {$cant_scrap ='';}
if (isset($_SESSION["var_f_create1"]))      {$f_create      = $_SESSION["var_f_create1"];}      else {$f_create ='';}


// echo 'DESPUES ACA: '.$id.' - '.$codigo_nuevo.' - '.$codigo_viejo.' - '.$nombre.' - '.$cant_min.' - '.$unidad_medida.' - '.$cant_scrap.' - '.$f_create; die();

$opc= 'ok';
if($codigo_nuevo=='' OR $codigo_viejo=='' OR $nombre=='' OR $cant_min=='' OR $unidad_medida=='' OR $cant_scrap=='')  $opc= 'er';

// vuelvo a chequear si el codigo esta o no
include_once('./mod2_materiales.php');	$Mat = new Materiales();
$msj= ' ';
if($codigo_nuevo == $codigo_viejo){
	$codigo= $codigo_viejo; // no actualiza el código.
}else{
	$codigo= $codigo_nuevo; // si actualizo el codigo entonces verfico que no sea repetido
	$existe = $Mat->tf_existe_codigo($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. '; $msj = 'existe'; }
}

switch($opc){

	case 'ok':	
        $f_update = date("Y-m-d H:i:s");
		$upd_mat = $Mat->upd_material($id, $codigo, $nombre, $cant_min, $unidad_medida, $cant_scrap, $f_create, $f_update);
        if($upd_mat){	$a_ico= 'success'; $a_tit= 'Registro Actualizado';	$a_sub= '';							}
        else{			$a_ico= 'error';   $a_tit= 'Error al Actualizar';   $a_sub= 'Intente de nuevo.';		}
		break;

	case 'er':
		$a_ico= 'error';   $a_tit= 'Error al Actualizar';
		if($msj == 'existe'){  $a_sub= 'Codigo Repetido.'; } else { $a_sub= 'Intente nuevamente, faltan datos.'; }
		break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_materiales.php"; </script>
