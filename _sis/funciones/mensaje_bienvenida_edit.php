<?php	
session_start();

// recibo datos
if (isset($_POST["id"]))      { $id    = $_POST["id"];     } else {  $id    = ''; }
if (isset($_POST["msj"]))     { $msj   = $_POST["msj"];    } else {  $msj   = ''; }
if (isset($_POST["titulo"]))  { $titulo= $_POST["titulo"]; } else {  $titulo= ''; }
if (isset($_POST["user"]))    { $user  = $_POST["user"];   } else {  $user  = ''; }

// verificaciones
if($id!='' && $msj!='' && $titulo!='' && $user!='')	$estado= 'ok';
else									            $estado= 'faltan_datos';

// ejecuto
switch($estado){
	case 'ok':
			include('/mensaje_bienvenida.php');	
			$MB  = new MensajeBienvenida();
			
			$upd = $MB->upd($id, $titulo, utf8_decode($msj));
			if($upd){
				include('/trace.php');	
				$Trace= new Trace();
				$Trace->add_abm('M','Upd de Mensaje de Bienvenida','71',$id,$user);	
				
				$_SESSION['var_retorno_']= 'msj_edit_ok';
				$_SESSION['msj_retorno_']= '';
			}else{
				$_SESSION['var_retorno_']= 'msj_edit_er';
				$_SESSION['msj_retorno_']= 'Por favor intente nuevamente.';	
			}
			break;
		
	case 'faltan_datos':
			$_SESSION['var_retorno_']= 'msj_edit_er';
			$_SESSION['msj_retorno_']= 'Por favor complete todos los campos.';	
			break;
}

// retorno
?> <script type="text/javascript"> window.location="../_admin_mensaje_bienvenida.php"; </script>