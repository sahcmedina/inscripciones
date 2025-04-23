<?php
session_start();

if (isset($_POST["id"]))  		{ $id  = $_POST["id"];   		} else { $id= '';    	 }
if (isset($_POST["nombre"]))  	{ $nombre= $_POST["nombre"];  	} else { $nombre= '';    }
if (isset($_POST["obs"]))  	{ $observacion= $_POST["obs"];  	} else { $observacion= '';    }
if (isset($_POST["usuario"]))  	{ $usuario= $_POST["usuario"];	} else { $usuario= '';   }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $nombre=='' OR $usuario=='' OR $observacion=='' ){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Validacion
if($c1== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION["var_id"]           = $id;
	$_SESSION["var_nombre"]       = $nombre;
	$_SESSION["var_observacion"]  = $observacion;
	$_SESSION["var_usuario"]      = $usuario;
	?> <script type="text/javascript"> window.location="./funciones/mod2_proveedores_upd.php"; </script><?php
}
?>