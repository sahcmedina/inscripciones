<?php
session_start();
include('usuario.php');	$U = new Usuario();				
error_reporting(E_ALL ^ E_NOTICE);

$btn     = $_REQUEST['btn'];
$username= $_REQUEST['usuario'];
$pass    = $_REQUEST['pass']; 
echo 'En USUARIO: '.$btn.'-'.$username.'-'.$pass;die();die();

if($btn == 'Ingresar'){ 

	$opcion  = 'ok';
	if($username=='' OR $pass==''){	$opcion = 'er1'; }
	else{
		$existe  = $U->existe( $username, $pass); 

		//echo 'LLEGUE ACA: '.$existe; die();

		if($existe == 'si') 		$opcion = 'ok'; 
		else            			$opcion = 'er2';
	}
	// echo 'LLEGUE ACA: '.$existe.'-'.$opcion; die();die();
	switch($opcion){
		case 'ok':  $U->conectar( $username, $pass); 
					break;
					
		case 'er1': $_SESSION['var_retorno_']= 'ingreso_user_er';		
					$_SESSION['msj_retorno_']= 'Faltaron datos, por favor intente nuevamente.';	
					header("Location: ../login.php");	die();
					break;	
					
		case 'er2': $_SESSION['var_retorno_']= 'ingreso_user_er';		
					$_SESSION['msj_retorno_']= 'Usuario o Contraseña incorrecta, por favor intente nuevamente o haga clic en RECUPERAR.';	
					header("Location: ../login.php");	die();
					break;			
	}

}else{
	
	if($btn == 'Concursar'){ 
		header("Location: ./../_usuario_concursante_crear.php");	die();

	}else{	
		$_SESSION['var_retorno_']= 'ingreso_user_er';		
		$_SESSION['msj_retorno_']= 'Ocurrio un error, por favor intente nuevamente.';	
		//header("Location: ../login.php");	
		header("Location: ./../../index.php");	die();
		die();
	}
}
?>