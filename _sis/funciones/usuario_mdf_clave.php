<?php 
session_start();
include ('./usuario.php');	$U = new Usuario();

// recibo datos
$id    = $_POST["id"];
$clave = $_POST["clave"];

// actualizo
$upd= $U->upd_pass($clave, $id);

if($upd){   $a_ico= 'success';    $a_tit= 'Contraseña Actualizada';	         $a_sub= '';                  }
else{       $a_ico= 'error';      $a_tit= 'Error al Actualizar';	         $a_sub= 'Intente de nuevo.'; }
		
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>