<?php
session_start();
include_once('mod3_productos.php');	$Productos = new Productos();

if (isset($_POST["id"]))        { $id= $_POST["id"];                } else { $id= '';	    	}
if (isset($_POST["usuario"]))   { $user= $_POST["usuario"]; 		} else { $user= '';  		}
if (isset($_POST["nom"]))       { $nom= $_POST["nom"]; 	    	    } else { $nom= '';  		}
if (isset($_POST["nomant"]))    { $nom_ant= $_POST["nomant"]; 	    } else { $nom_ant= '';  	}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $user=='' OR $nom=='' OR $nom_ant==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El nombre existe?
$c2= 'ok';	$er2= '';
if($nom != $nom_ant){
	$existe = $Productos->tf_existe_nombre($nom);
	if($existe){ $c2= 'er';  $er2= 'Repite nombre. ';	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_id']= $id;	       $_SESSION['var_user']= $user;	     $_SESSION['var_nom']= $nom;	   
	?> <script type="text/javascript"> window.location="./funciones/mod3_productos_upd.php"; </script><?php		
}
?>