<?php
session_start();
include("mod2_materiales.php"); $Mat = new Materiales();

if (isset($_POST["cod"]))  { $codigo      = $_POST["cod"]; } else { $codigo      = ''; }
if (isset($_POST["des"]))  { $descripcion = $_POST["des"]; } else { $descripcion = ''; }
if (isset($_POST["pat"]))  { $patente     = $_POST["pat"]; } else { $patente     = ''; }
if (isset($_POST["obs"]))  { $obs         = $_POST["obs"]; } else { $obs     = '';     }
if (isset($_POST["dep"]))  { $dep         = $_POST["dep"]; } else { $dep     = '';     }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($codigo=='' OR $descripcion=='' OR $patente=='' OR $obs=='' OR $dep==''){$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
$c2= 'ok';	$er2= '';
$existe = $Mat->tf_existe_codigo($codigo);
if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_codigo']        = $codigo;
	$_SESSION['var_descripcion']   = $descripcion;
	$_SESSION['var_patente']       = $patente;
	$_SESSION['var_obs']           = $obs;
	$_SESSION['var_dep']           = $dep;
	?> <script type="text/javascript"> window.location="./funciones/mod2_moviles_add.php"; </script><?php
}
?>