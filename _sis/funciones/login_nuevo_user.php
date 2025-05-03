<?php
session_start();
include('usuario.php');	$U = new Usuario();				
error_reporting(E_ALL ^ E_NOTICE);

$user = $_REQUEST['user'];
$pass = $_REQUEST['pass']; 
$dni  = $_REQUEST['dni']; 
$anio = $_REQUEST['anio']; 
// echo 'ACA: '.$user.'-'.$pass.'-'.$dni;die();

										$opc= 'ok';
if($user=='' OR $pass=='' OR $dni=='') 	$opc= 'er';

if($opc == 'ok'){

	// creo el usuario	(tipo Concursante)
	$perfil    = 2; 
	$next_user = $U->add_usuario_concursante($dni, $user, $pass);					
	$add_perf  = $U->add_perfil_asociado($next_user, $perfil);	
	$U->conectar( $user, $pass);

}else{

	// vuelve a la pagina anterior
	$_SESSION['user_creado_dni'] = $dni;
	$_SESSION['user_creado_anio']= $anio;
	$_SESSION['var_retorno_']    = 'pass_user_er';		
	$_SESSION['msj_retorno_']    = 'Debe ingresar contraseña.';	
	header("Location: ../_usuario_concursante_crear_next.php");	die();	
}
?>