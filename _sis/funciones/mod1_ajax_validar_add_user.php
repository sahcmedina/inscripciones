<?php
session_start();
include('usuario.php');	$U = new Usuario();

if (isset($_POST["nom"]))       { $nom= $_POST["nom"];   	} else { $nom= '';		}
if (isset($_POST["dni"]))     	{ $dni= $_POST["dni"];      } else { $dni= '';   	}
if (isset($_POST["per"]))       { $perf= $_POST["per"];     } else { $perf= '';  	}
if (isset($_POST["id_cli"]))    { $id_cli= $_POST["id_cli"];} else { $id_cli= '';   }
if (isset($_POST["email"]))     { $email= $_POST["email"];  } else { $email= '';   	}
if (isset($_POST["usu"]))       { $usu= $_POST["usu"];      } else { $usu= '';   	}
if (isset($_POST["ape"]))       { $ape= $_POST["ape"];      } else { $ape= '';   	}
if (isset($_POST["tel"]))       { $tel= $_POST["tel"];      } else { $tel= '';   	}
if (isset($_POST["pas"]))       { $pas= $_POST["pas"];      } else { $pas= '';   	}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($nom=='' OR $ape=='' OR $dni=='' OR $tel=='' OR $email=='' OR $pas=='' OR $perf=='' OR $usu=='' OR $id_cli=='') {	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El Login existe?
$c2= 'ok';	$er2= '';
$existe = $U->tf_repite_login($usu);	
if($existe){ $c2= 'er';  $er2= 'Repite Login. ';	}

// Control: El DNI existe?
$c3= 'ok';	$er3= '';
$existe3 = $U->tf_repite_dni($dni);	
if($existe3){ $c3= 'er';  $er3= 'Repite DNI. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er' OR $c3== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1. $er2. $er3." </label></center>"; 

}else{
	$_SESSION['var_nom']= $nom;	       $_SESSION['var_dni']= $dni;	     $_SESSION['var_perf']= $perf;	     $_SESSION['var_id_cli']= $id_cli;
	$_SESSION['var_email']= $email;	   $_SESSION['var_usu']= $usu;	     $_SESSION['var_ape']= $ape;	     $_SESSION['var_tel']= $tel;
	$_SESSION['var_pas']= $pas;
	?> <script type="text/javascript"> window.location="./funciones/mod1_user_add.php"; </script><?php		
}
?>