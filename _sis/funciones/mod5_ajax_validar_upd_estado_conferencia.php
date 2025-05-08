<?php
session_start();

if (isset($_POST["idusr"])) { $id_user      = $_POST["idusr"]; } else { $id_user      = '';	}
if (isset($_POST["id"]))    { $id           = $_POST["id"];    } else { $id           = '';	}
if (isset($_POST["state"])) { $estado_actual= $_POST["state"]; } else { $estado_actual= ''; }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $estado_actual=='' OR $id_user=='' ){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Validacion
if($c1== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	if($estado_actual==1){ $estado_nuevo =2; } else { $estado_nuevo =1; }
	$_SESSION['var_id']= $id;	$_SESSION['var_estado_nuevo']= $estado_nuevo;	$_SESSION['var_id_user']= $id_user;
	?> <script type="text/javascript"> window.location="./funciones/mod5_conferencia_upd_estado.php"; </script><?php		
}
?>