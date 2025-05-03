<?php
session_start();
include_once('./mod2_proveedores.php');	$Prov = new Proveedores();

if (isset($_POST["nombre"])) { $nom= $_POST["nombre"];      } else { $nom         = ''; }
if (isset($_POST["obs"]))    { $obser= $_POST["obs"]; } else { $obser = ''; }
if (isset($_POST["usu"]))    { $user= $_POST["usu"];        } else { $user        = ''; }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($nom=='' OR $user=='' OR $obser==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El nombre existe?
$c2= 'ok';	$er2= '';
$existe = $Prov->tf_existe_nombre($nom);
if($existe){ $c2= 'er';  $er2= 'Repite nombre. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_nombre']= $nom; $_SESSION['var_user']= $user; $_SESSION['var_obser']= $obser;
	?> <script type="text/javascript"> window.location="./funciones/mod2_proveedores_add.php"; </script><?php		
}
?>