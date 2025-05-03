<?php 
session_start();
if (isset($_POST["colaborador"]))    { $colaborador = $_POST["colaborador"];    } else { $colaborador = ''; }
				
if($colaborador == '')	$opcion= 'er';
else					$opcion= 'ok';

switch($opcion){
	
	case 'er':	$_SESSION['var_retorno_']= 'permisoAOtrasFunc_add_ok';	$_SESSION['msj_retorno_']= '';
				break;
	
	case 'ok':	require_once('/personal.php');					$Pers = new Personal();	
				require_once('/notificacionesGral.php');		$NotifGral= new NotificacionesGral();	
				$id_user = $Pers->get_idUser($colaborador);
				$add     = $NotifGral->add_permiso_a_notificar($id_user);
				if($add){
					$_SESSION['var_retorno_']= 'permisoAOtrasFunc_add_ok';	$_SESSION['msj_retorno_']= '';
				}else{
					$_SESSION['var_retorno_']= 'permisoAOtrasFunc_add_er';	$_SESSION['msj_retorno_']= 'Por favor, intente de nuevo.';
				}
	            break;
}				
		
?> <script type="text/javascript"> window.location="../_admin_usuarios.php";</script> <?php