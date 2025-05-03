<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('sponsor.php');	$S = new Sponsor();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))          { $id      = $_POST["id"];         } else { $id      = ''; }
if (isset($_POST["mostrar_web"])) { $mostrar = $_POST["mostrar_web"];} else { $mostrar = ''; }

// verifico los datos
switch ($mostrar){
	case 0: $mostrar_web=1; $mensaje='Ahora el Sponsor se Muestra en la web';   break;
	case 1: $mostrar_web=0; $mensaje='Se dejo de mostrar el Sponsor en la web'; break;
}

$mostrar_ = $S->view_sponsor_en_la_web($id, $mostrar_web);
if($mostrar_){
	$_SESSION['var_retorno_']= 'view_sp_ok';  $_SESSION['msj_retorno_']= $mensaje;
}else{
	$_SESSION['var_retorno_']= 'view_sp_er'; $_SESSION['msj_retorno_']= 'No se pudo cambiar el valor.';
}

?>
<script type="text/javascript"> window.location="../_web_sponsor.php"; </script>
