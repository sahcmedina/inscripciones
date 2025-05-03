<?php
include('./mensaje_bienvenida.php');
session_start();	

// recibo datos
$id  = $_GET["id"];

$MB  = new MensajeBienvenida();
$tipo= $MB->get_tipo($id);
$MB->upd_inhab_tipo($tipo);
$MB->upd_hab_msj($id);
	
// mensaje de confirmacion			
$_SESSION['var_retorno_']= 'msj_hab_ok';
$_SESSION['msj_retorno_']= '';	

// retorno
?> <script type="text/javascript"> window.location="../_admin_mensaje_bienvenida.php"; </script>