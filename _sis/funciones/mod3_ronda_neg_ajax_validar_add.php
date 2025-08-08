<?php
session_start();
include_once('mod3_ronda_neg.php');       $RondaNeg  = new RondaNegocios();

if (isset($_POST["usu"]))       	{ $user= $_POST["usu"];     			} else { $user= '';  		}
if (isset($_POST["nom"]))       	{ $nom= $_POST["nom"];      			} else { $nom= '';   		}
if (isset($_POST["lug"]))       	{ $lug= $_POST["lug"];      			} else { $lug= '';   		}
if (isset($_POST["f1"]))        	{ $f1= $_POST["f1"];      				} else { $f1= '';   		}
if (isset($_POST["f2"]))        	{ $f2= $_POST["f2"];      				} else { $f2= '';   		}
if (isset($_POST["hs"]))        	{ $hs= $_POST["hs"];      				} else { $hs= '';   		}
if (isset($_POST["f_insc_dsd"]))    { $f_insc_dsd= $_POST["f_insc_dsd"];    } else { $f_insc_dsd= '';   }
if (isset($_POST["f_insc_hst"]))    { $f_insc_hst= $_POST["f_insc_hst"];    } else { $f_insc_hst= '';   }

$chek = $_POST["chek"] ?? [];	// llega como string
if (!is_array($chek) && !empty($chek)) {
    $chek = explode(',', $chek);
}

// Control 1: Faltan datos?
$c1= 'ok';	$er1= '';
if($user=='' OR $nom=='' OR $lug=='' OR $f1=='' OR $hs=='' OR $f_insc_dsd=='' OR $f_insc_hst==''){	
	$c1 = 'er';	
	$er1= 'Faltan datos( '; 
	if($user=='')			$er1.=' Usuario,';
	if($nom=='')			$er1.=' Nombre,';
	if($lug=='')			$er1.=' Lugar,';
	if($f1=='')  			$er1.=' 1° Fecha,';
	if($hs=='')  			$er1.=' Hs,';
	if($f_insc_dsd=='')  	$er1.=' Inscripcion desde,';
	if($f_insc_hst=='')  	$er1.=' Inscripcion hasta';
	$er1.='), ';
}

// Control 2: El nombre existe?
$c2= 'ok';	$er2= '';
$existe = $RondaNeg->tf_existe_nombre($nom);
if($existe){ $c2= 'er';  $er2= 'Repite nombre. ';	}

// Control 3: >1 productos elegidos?
$c3= 'ok';	$er3= '';
if(is_array($chek)){
	if(count($chek)<1){ $c3= 'er';  $er3= 'Debe elegir al menos 1 producto. ';	}
}else{                  $c3= 'er';  $er3= 'Debe elegir al menos 1 producto. ';  }

// Validacion
if($c1== 'er' OR $c2== 'er' OR $c3== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2.$er3." </label></center>"; 
}else{
	$_SESSION['var_user']= $user;	     $_SESSION['var_nom']= $nom;	                 $_SESSION['var_lug']= $lug;
	$_SESSION['var_f1']= $f1;	         $_SESSION['var_f_insc_dsd']= $f_insc_dsd;	     $_SESSION['var_f_insc_hst']= $f_insc_hst;
	$_SESSION['var_chek']= $chek;        $_SESSION['var_hs']= $hs;                       $_SESSION['var_f2']= $f2;	
	?> <script type="text/javascript"> window.location="./funciones/mod3_ronda_neg_add.php"; </script><?php		
}?>