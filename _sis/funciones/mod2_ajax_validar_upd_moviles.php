<?php
session_start();
include("./mod2_materiales.php"); $Mat = new Materiales();


if (isset($_POST["id1"]))   { $id           = $_POST["id1"];   } else { $id= '';    	         }
if (isset($_POST["cod1"]))  { $codigo_nuevo = $_POST["cod1"];  } else { $codigo_nuevo= '';    	 }
if (isset($_POST["cod2"]))  { $codigo_viejo = $_POST["cod2"];  } else { $codigo_viejo= '';    	 }
if (isset($_POST["des1"]))  { $descripcion  = $_POST["des1"];  } else { $descripcion= ''; 	     }
if (isset($_POST["pat1"]))  { $patente      = $_POST["pat1"];  } else { $patente= '';            }
if (isset($_POST["fcre1"])) { $f_create     = $_POST["fcre1"]; } else { $f_create= '';           }
if (isset($_POST["obs"]))   { $obs          = $_POST["obs"];   } else { $obs= '';                }
if (isset($_POST["dep"]))   { $dep          = $_POST["dep"];   } else { $dep= '';                }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($codigo_nuevo=='' OR $codigo_viejo=='' OR $descripcion=='' OR $patente=='' OR $dep==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
$c2= 'ok';	$er2= '';
if($codigo_nuevo == $codigo_viejo){
	$codigo= $codigo_viejo; // no actualiza el código.
}else{
	$codigo= $codigo_nuevo; // si actualizo el codigo entonces verfico que no sea repetido
	$existe = $Mat->tf_existe_codigo($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION["var_id1"]        	= $id;
	$_SESSION["var_codigo1"]        = $codigo_nuevo;
	$_SESSION["var_codigo2"]        = $codigo_viejo;
	$_SESSION["var_descripcion1"]   = $descripcion;
	$_SESSION["var_patente1"]       = $patente;
	$_SESSION["var_f_create1"]      = $f_create;
	$_SESSION["var_obs"]            = $obs;
	$_SESSION["var_dep"]            = $dep;
	?> <script type="text/javascript"> window.location="./funciones/mod2_moviles_upd.php"; </script><?php
}
?>