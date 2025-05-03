<?php
	error_reporting(E_ALL ^ E_NOTICE);
	include('usuario_desconectar.php');
	$U= new UsuarioDesc();
	$U->desconectar();  
?>