<?php
session_start();

if (isset($_POST["cod"]))  { $codigo= $_POST["cod"];        } else { $codigo= '';    	 }
if (isset($_POST["nom"]))  { $nombre= $_POST["nom"];        } else { $nombre= ''; 	     }
if (isset($_POST["min"]))  { $cant_min= $_POST["min"];      } else { $cant_min= '';      }
if (isset($_POST["uni"]))  { $unidad_medida= $_POST["uni"]; } else { $unidad_medida= ''; }
if (isset($_POST["scra"])) { $cant_scrap= $_POST["scra"];   } else { $cant_scrap= '';    }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($codigo=='' OR $nombre=='' OR $cant_min=='' OR $unidad_medida=='' OR $cant_scrap==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
$c2= 'ok';	$er2= '';
if($c1== 'ok'){
	include("mod2_materiales.php"); $Mat = new Materiales();
	$existe = $Mat->tf_existe_codigo($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_codigo']        = $codigo;
	$_SESSION['var_nombre']        = $nombre;
	$_SESSION['var_cant_min']      = $cant_min;
	$_SESSION['var_unidad_medida'] = $unidad_medida;
	$_SESSION['var_min_scrap']     = $cant_scrap;
	?> <script type="text/javascript"> window.location="./funciones/mod2_materiales_add.php"; </script><?php
}
?>