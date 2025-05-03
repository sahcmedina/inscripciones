<?php
session_start();
include("./mod2_materiales.php"); $Mat = new Materiales();


if (isset($_POST["id1"]))   { $id            = $_POST["id1"];   } else { $id= '';    	 }
if (isset($_POST["cod1"]))  { $codigo_nuevo  = $_POST["cod1"];  } else { $codigo_nuevo= '';    	 }
if (isset($_POST["cod2"]))  { $codigo_viejo  = $_POST["cod2"];  } else { $codigo_viejo= '';    	 }
if (isset($_POST["nom1"]))  { $nombre        = $_POST["nom1"];  } else { $nombre= ''; 	     }
if (isset($_POST["min1"]))  { $cant_min      = $_POST["min1"];  } else { $cant_min= '';      }
if (isset($_POST["uni1"]))  { $unidad_medida = $_POST["uni1"];  } else { $unidad_medida= ''; }
if (isset($_POST["scra1"])) { $cant_scrap    = $_POST["scra1"]; } else { $cant_scrap= '';    }
if (isset($_POST["fcre1"])) { $f_create      = $_POST["fcre1"]; } else { $f_create= '';    }
// echo 'ESTOY ACA: '.$id.'-'.$codigo_nuevo.'-'.$codigo_viejo.'-'.$nombre.'-'.$cant_min.'-'.$unidad_medida.'-'.$cant_scrap.'-'.$f_create; die();

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($codigo_nuevo=='' OR $codigo_viejo=='' OR $nombre=='' OR $cant_min=='' OR $unidad_medida=='' OR $cant_scrap==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

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
	$_SESSION["var_nombre1"]        = $nombre;
	$_SESSION["var_cant_min1"]      = $cant_min;
	$_SESSION["var_unidad_medida1"] = $unidad_medida;
	$_SESSION["var_min_scrap1"]     = $cant_scrap;
	$_SESSION["var_f_create1"]      = $f_create;
	?> <script type="text/javascript"> window.location="./funciones/mod2_materiales_upd.php"; </script><?php
}
?>