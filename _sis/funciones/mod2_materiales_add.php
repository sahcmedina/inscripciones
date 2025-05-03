<?php
session_start();

if (isset($_SESSION["var_codigo"])) 		{$codigo        = $_SESSION["var_codigo"];}        else {$codigo ='';}
if (isset($_SESSION["var_nombre"]))         {$nombre        = $_SESSION["var_nombre"];}        else {$nombre ='';}
if (isset($_SESSION["var_cant_min"]))       {$cant_min      = $_SESSION["var_cant_min"];}      else {$cant_min ='';}
if (isset($_SESSION["var_unidad_medida"]))  {$unidad_medida = $_SESSION["var_unidad_medida"];} else {$unidad_medida ='';}
if (isset($_SESSION["var_min_scrap"]))      {$cant_scrap    = $_SESSION["var_min_scrap"];}     else {$cant_scarp ='';}

$opc= 'ok';
if($codigo=='' OR $nombre=='' OR $cant_min=='' OR $unidad_medida=='' OR $cant_scrap=='')  $opc= 'er';

//vuelvo a chequear si el codigo esta o no
if($opc== 'ok'){
	include_once('./mod2_materiales.php');	$Mat = new Materiales();
	$msj= ' ';
	$existe_codigo = $Mat->tf_existe_codigo($codigo);
	if($existe_codigo) {$msj = 'existe'; $opc= 'er'; }
}

switch($opc){

	case 'ok':	
        date_default_timezone_set('America/Argentina/San_Juan');
 		$f_create = date("Y-m-d H:i:s");
 		$f_update = '';
 		$add_mat = $Mat->add_material($codigo, $nombre, $cant_min, $unidad_medida, $cant_scrap, $f_create, $f_update);
         if($add_mat){	$a_tit= 'Registro Agregado';	$a_sub= '';		                 $a_ico= 'success';			}
         else{			$a_tit= 'Error al Agregar';	    $a_sub= 'Intente de nuevo';		 $a_ico= 'error';			}
 		break;

 	case 'er':
		$a_tit= 'Error al Agregar';	$a_ico= 'error';
		if($msj == 'existe'){  $a_sub= 'Codigo Repetido';			             } 
		else {                 $a_sub= 'Intente nuevamente, faltan datos';		 }
 		break;
 }
 $_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_materiales.php"; </script>
