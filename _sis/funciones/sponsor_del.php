<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('sponsor.php');	$S = new Sponsor();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))     { $id     = $_POST["id"];     } else { $id     = ''; }
if (isset($_POST["imagen"])) { $imagen = $_POST["imagen"]; } else { $imagen = ''; } //foto vieja

$del = $S->del_sponsor($id);
if($del){
	$img = "../images/sponsor/".$imagen;
	unlink($img);
	$_SESSION['var_retorno_']= 'del_sp_ok';  $_SESSION['msj_retorno_']= 'El Sponsor se Eliminó satisfactoriamente.';
}else{
	$_SESSION['var_retorno_']= 'del_sp_er'; $_SESSION['msj_retorno_']= 'No se pudo eliminar el Sponsor.';
}

?>
<script type="text/javascript"> window.location="../_web_sponsor.php"; </script>
