<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('contactos.php');	$C = new Contacto();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))   { $id   = $_POST["id"];   } else { $id   = ''; }
if (isset($_POST["foto"])) { $foto = $_POST["foto"]; } else { $foto = ''; } 

$del = $C->del_contacto($id);
if($del){
	$img = "../images/contacto/".$foto;
	unlink($img);
	$_SESSION['var_retorno_']= 'del_con_ok';  $_SESSION['msj_retorno_']= 'El Contacto se Eliminó satisfactoriamente.';
}else{
	$_SESSION['var_retorno_']= 'del_con_er'; $_SESSION['msj_retorno_']= 'No se pudo eliminar el Contacto.';
}

?>
<script type="text/javascript"> window.location="../_web_contactos.php"; </script>
