<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('comite.php');	$C = new Comite();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))  { $id  = $_POST["id"];  } else { $id  = ''; }
if (isset($_POST["url"])) { $url = $_POST["url"]; } else { $url = ''; } //foto vieja

$del = $C->del_integrante($id);
if($del){
	$img = "../images/comite/".$url;
	unlink($img);
	$_SESSION['var_retorno_']= 'del_co_ok';  $_SESSION['msj_retorno_']= 'El Integrante se Actualizó Correctamente.';
}else{
	$_SESSION['var_retorno_']= 'del_co_er'; $_SESSION['msj_retorno_']= 'No se pudo actualizar los datos.';
}

?>
<script type="text/javascript"> window.location="../_web_comite.php"; </script>
