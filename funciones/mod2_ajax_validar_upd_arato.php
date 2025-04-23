<?php
session_start();
include("mod2_aratos.php"); $A = new Aratos();

if (isset($_POST["id"]))        { $id= $_POST["id"];                } else { $id= '';	    	}
if (isset($_POST["cod"]))       { $codigo= $_POST["cod"];           } else { $codigo= '';		}
if (isset($_POST["cod_ant"]))   { $codigo_ant= $_POST["cod_ant"];   } else { $codigo_ant= '';	}
if (isset($_POST["depo_"]))       { $dep= $_POST["depo_"];    		} else { $dep= '';  		}
if (isset($_POST["usuario"]))   { $user= $_POST["usuario"]; 		} else { $user= '';  		}
if (isset($_POST["nom"]))       { $nom= $_POST["nom"]; 	    	    } else { $nom= '';  		}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $codigo=='' OR $codigo_ant=='' OR $dep=='' OR $user=='' OR $nom==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
$c2= 'ok';	$er2= '';
if($codigo != $codigo_ant){
	$existe = $A->tf_existe($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_cod']= $codigo;	   $_SESSION['var_id']= $id;	     $_SESSION['var_user']= $user;	
	$_SESSION['var_dep']= $dep;	       $_SESSION['var_nom']= $nom;	   
	?> <script type="text/javascript"> window.location="./funciones/mod2_aratos_upd.php"; </script><?php		
}
?>