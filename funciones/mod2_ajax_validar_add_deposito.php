<?php
session_start();
include("mod2_depositos.php"); $Dep = new Depositos();

if (isset($_POST["cod"]))       { $codigo= $_POST["cod"];   } else { $codigo= '';}
if (isset($_POST["prov"]))     	{ $prov= $_POST["prov"];    } else { $prov= '';  }
if (isset($_POST["dir"]))     	{ $dir= $_POST["dir"];      } else { $dir= '';   }
if (isset($_POST["tel"]))     	{ $tel= $_POST["tel"];      } else { $tel= '';   }
if (isset($_POST["usuario"]))   { $user= $_POST["usuario"]; } else { $user= '';  }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($codigo=='' OR $prov=='' OR $dir=='' OR $tel=='' OR $user==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
$c2= 'ok';	$er2= '';
$existe = $Dep->tf_existe_dep($codigo);
if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_cod']= $codigo;	   $_SESSION['var_dir']= $dir;	     $_SESSION['var_user']= $user;	
	$_SESSION['var_prov']= $prov;	   $_SESSION['var_tel']= $tel;	
	?> <script type="text/javascript"> window.location="./funciones/mod2_depositos_add.php"; </script><?php		
}
?>