<?php

	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	
	
	## VERIFICACION DE COOKIE ####################################################################################
	include('./funciones/_cripto.php'); 	
	$Cripto = new Cripto();	
	$login  = $_SESSION['sesion_UserId']; 
	
	if( isset($_COOKIE['sisMinProd_UserId']) )   $cookieActiva = true;	else	$cookieActiva = false;	
	$cookieStorage = $Cripto->encrypt_decrypt('decrypt',$_COOKIE['sisMinProd_UserId']);
	if($cookieStorage == $login)			     $cookieEsLogin= true;	else	$cookieEsLogin= false;	
	
	if ( !$cookieActiva OR !$cookieEsLogin){
		header("location:./funciones/logout.php");	
		exit();
	}
	
	
	## MSJ BIENVENIDA: ############################################################################################
	require_once('./funciones/usuario.php');
	require_once('./funciones/mensaje_bienvenida.php');		
	$Msj_bienvenida= new MensajeBienvenida();
	$U             = new Usuario();	
	
	$msj    = '';
	$arr_msj= array();
	$datos  = array();
	$tipo   = $U->get_tipo_user( $login);	
	switch($tipo){
		
		case '1': 	$tipo_user= 'admin'; 		
				  	// datos
				  	$datos      = $U->gets_datos_persona($login);	
				  	$perfil_user= $datos[0]['fk_perfil'];
					$dni        = $datos[0]['dni'];
					$user_id    = $datos[0]['id'];
					// mensaje
					$arr_msj= $Msj_bienvenida->gets_msj_user(1);
					$msj    = utf8_encode($arr_msj[0]['mensaje']);
					$titulo = utf8_encode($arr_msj[0]['titulo']);					
					// empresa
					$empresa_logueada   = $U->get_nombre_empresa($login);	
					$id_empresa_logueada= $U->get_id_empresa($login);	
				  	break;
	}	
	
	
	## FOOTER & VERSIONADO #######################################################################################
	require_once('./funciones/versionado.php');
	$Vers  = new Versionado();
	$footer= $Vers->get_version();