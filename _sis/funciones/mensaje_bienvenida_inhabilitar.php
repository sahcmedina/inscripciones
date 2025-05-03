<?php
include('./mensaje_bienvenida.php');
session_start();	

// recibo datos
$id = $_GET["id"];

// elimino
$MB = new MensajeBienvenida();
$MB->upd_inhab_msj($id);
	
// mensaje de confirmacion			
$_SESSION['var_retorno_']= 'msj_inhab_ok';
$_SESSION['msj_retorno_']= '';	

// retorno
?> <script type="text/javascript"> window.location="../_admin_mensaje_bienvenida.php"; </script>