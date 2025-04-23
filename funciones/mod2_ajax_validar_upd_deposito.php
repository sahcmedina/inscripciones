<?php
session_start();

if (isset($_POST["id"]))        { $id= $_POST["id"];                } else { $id= '';	    	}
if (isset($_POST["cod"]))       { $codigo= $_POST["cod"];           } else { $codigo= '';		}
if (isset($_POST["cod_ant"]))   { $codigo_ant= $_POST["cod_ant"];   } else { $codigo_ant= '';	}
if (isset($_POST["prov"]))      { $prov= $_POST["prov"];    		} else { $prov= '';  		}
if (isset($_POST["dir"]))     	{ $dir= $_POST["dir"];      		} else { $dir= '';  		}
if (isset($_POST["tel"]))     	{ $tel= $_POST["tel"];      		} else { $tel= '';   		}
if (isset($_POST["usuario"]))   { $user= $_POST["usuario"]; 		} else { $user= '';  		}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $codigo=='' OR $codigo_ant=='' OR $prov=='' OR $dir=='' OR $tel=='' OR $user==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El codigo existe?
include_once("./mod2_depositos.php"); $Dep = new Depositos();
$c2= 'ok';	$er2= '';
if($codigo != $codigo_ant){
	$existe = $Dep->tf_existe_dep($codigo);
	if($existe){ $c2= 'er';  $er2= 'Repite código. ';	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_cod']= $codigo;	   $_SESSION['var_dir']= $dir;	     $_SESSION['var_user']= $user;	
	$_SESSION['var_prov']= $prov;	   $_SESSION['var_tel']= $tel;	     $_SESSION['var_id']= $id;
	?> <script type="text/javascript"> window.location="./funciones/mod2_depositos_upd.php"; </script><?php		
}
?>