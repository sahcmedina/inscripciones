<?php
session_start();

if (isset($_POST["id_upd"]))    { $id= $_POST["id_upd"];            } else { $id= '';	    	}
if (isset($_POST["dep"]))       { $dep= $_POST["dep"];    		    } else { $dep= '';  		}
if (isset($_POST["usu_log"]))   { $usu_log= $_POST["usu_log"]; 		} else { $usu_log= '';  	}
if (isset($_POST["usu"]))       { $usu= $_POST["usu"]; 	    	    } else { $usu= '';  		}
		
// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $dep=='' OR $usu_log=='' OR $usu==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Validacion
if($c1== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION['var_id']= $id;	       $_SESSION['var_usu_log']= $usu_log;	     	
	$_SESSION['var_dep']= $dep;	       $_SESSION['var_usu']= $usu;	   
	?> <script type="text/javascript"> window.location="./funciones/mod2_depositos_tecnicos_upd.php"; </script><?php		
}
?>