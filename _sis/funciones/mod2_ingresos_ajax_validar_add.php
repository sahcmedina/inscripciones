<?php
session_start();

if (isset($_POST["dep"]))     { $dep= $_POST["dep"];         } else { $dep= '';    	    }
if (isset($_POST["prov"]))    { $prov= $_POST["prov"];       } else { $prov= ''; 	    }
if (isset($_POST["user"]))    { $fk_user= $_POST["user"];    } else { $fk_user= ''; 	}

if (isset($_POST["fk_depo"])) { $fk_depo= $_POST["fk_depo"]; } else { $fk_depo= ''; 	}

if (isset($_POST["cant_1"]))  { $cant_1= $_POST["cant_1"];   } else { $cant_1= '';      }
if (isset($_POST["cod_1"]))   { $cod_1= $_POST["cod_1"];     } else { $cod_1= '';       }
if (isset($_POST["trat_1"]))  { $trat_1= $_POST["trat_1"];   } else { $trat_1= '';      }
if (isset($_POST["ara_1"]))   { $ara_1= $_POST["ara_1"];     } else { $ara_1= '';       }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($dep=='' OR $prov=='' OR $cant_1=='' OR $cod_1=='' OR $trat_1==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El 1° Material esta completo?
$c2= 'ok';	$er2= '';
if($c1== 'ok'){
	if($cant_1 > 0){ 
		if($cod_1 == 0 ){ $c2= 'er';  $er2.= '(M1) Elija Código. ';		}
		else $_SESSION['v_mat1'] = 'si';
	}else{
		$c2= 'er';  $er2.= '(M1) Cantidad. '; 
	}
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['v_dep']= $dep;	      $_SESSION['v_prov'] = $prov; 		$_SESSION['v_user'] = $fk_user;   $_SESSION['v_fk_depo']= $fk_depo;
	$_SESSION['v_cant_1']= $cant_1;   $_SESSION['v_cod_1']= $cod_1; 	$_SESSION['v_trat_1']= $trat_1;   $_SESSION['v_ara_1']= $ara_1;             
	?> <script type="text/javascript"> window.location="./funciones/mod2_ingresos_add.php"; </script><?php
}
?>