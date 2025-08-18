<?php
session_start();

if (isset($_POST["hs"]))        { $hs= $_POST["hs"];                } else { $hs= '';	    	}
if (isset($_POST["usuario"]))   { $user= $_POST["usuario"]; 		} else { $user= '';  		}
if (isset($_POST["duracion"]))  { $duracion= $_POST["duracion"]; 	} else { $duracion= '';     }
if (isset($_POST["x_dia"]))     { $x_dia= $_POST["x_dia"]; 	        } else { $x_dia= '';     	}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($hs=='' OR $user=='' OR $duracion=='' OR $x_dia==''){	$c1= 'er';	$er1= '- Faltan datos. '; }

// Control: # reuniones >1?
$c2= 'ok';	$er2= '';
if($x_dia<1 OR $x_dia>15){	$c2= 'er';	$er2= '- Cant. x día debe estar entre 1 y 15. '; }

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['var_hs']= $hs;	       $_SESSION['var_user']= $user;	     $_SESSION['var_duracion']= $duracion;	   	 $_SESSION['var_x_dia']= $x_dia;
	?> <script type="text/javascript"> window.location="./funciones/mod3_rn_agenda_param_upd.php"; </script><?php		
}
?>