<?php
session_start();
include("mod4_sectores.php"); $Sectores = new Sectores();

if (isset($_POST["usu"]))       { $user= $_POST["usu"];     } else { $user= '';  }
if (isset($_POST["nom"]))       { $nom= $_POST["nom"];      } else { $nom= '';   }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($user=='' OR $nom==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El nombre existe?
$c2= 'ok';	$er2= '';
$existe = $Sectores->tf_existe_nombre($nom);
if($existe){ $c2= 'er';  $er2= 'Repite nombre. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_user']= $user;	     $_SESSION['var_nom']= $nom;
	?> <script type="text/javascript"> window.location="./funciones/mod4_sectores_add.php"; </script><?php		
}
?>