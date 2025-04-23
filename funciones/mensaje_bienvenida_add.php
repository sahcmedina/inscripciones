<?php
include('/mensaje_bienvenida.php');	
session_start();

// recibo datos
if (isset($_POST["tipo"]))    { $tipo   = $_POST["tipo"];   } else {  $tipo   = ''; }
if (isset($_POST["user"]))    { $user   = $_POST["user"];   } else {  $user   = ''; }
if (isset($_POST["titulo"]))  { $titulo = $_POST["titulo"]; } else {  $titulo = ''; }
if (isset($_POST["descrip"])) { $descrip= $_POST["descrip"];} else {  $descrip= ''; }

// verificaciones
if($tipo!='' && $user!='' && $titulo!='' && $descrip!='')	$estado= 'ok';
else													    $estado= 'faltan_datos';

// ejecuto
switch($estado){
	case 'ok':
			$_SESSION['var_retorno_']= 'msj_add_ok';
			$_SESSION['msj_retorno_']= '';
			
			$MB   = new MensajeBienvenida();
			
			// si existe mensaje habilitado para ese tipo, se debe inhabilitar antes de agregarlo
			$MB->upd_inhab_tipo($tipo);
			
			$MB->add($tipo, $user, $titulo, $descrip);
			break;
		
	case 'faltan_datos':
			$_SESSION['var_retorno_']= 'msj_add_er';
			$_SESSION['msj_retorno_']= 'Por favor complete todos los campos.';	
			break;
}

// retorno
?> <script type="text/javascript"> window.location="../_admin_mensaje_bienvenida.php"; </script>