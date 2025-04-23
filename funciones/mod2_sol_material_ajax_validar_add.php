<?php
session_start();
$tabla = '';
$id    = '';

if (isset($_POST["cod_mat"]))     		{ $cod_mat= $_POST["cod_mat"];  			} else { $cod_mat= '';    	    }
if (isset($_POST["usuario"]))    		{ $usu= $_POST["usuario"];       	    	} else { $usu= ''; 	        	}
if (isset($_POST["depo_logueado"]))    	{ $depo_logueado= $_POST["depo_logueado"]; 	} else { $depo_logueado= ''; 	}
if (isset($_POST["movil"])) 			{ $movil= $_POST["movil"]; 					} else { $movil= ''; 			}
if (isset($_POST["cant"]))  			{ $cant= $_POST["cant"];  					} else { $cant= '';     		}
if (isset($_POST["destino"]))   		{ $destino= $_POST["destino"];     			} else { $destino= '';       	}
if (isset($_POST["origen"]))  			{ $origen= $_POST["origen"];   				} else { $origen= '';      		}

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($cod_mat=='' OR $usu=='' OR $depo_logueado=='' OR $movil=='' OR $cant=='' OR $destino=='' OR $origen==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: Separo el Origen
$c2= 'ok';	$er2= '';
if($c1 != 'er'){
	list($tabla, $id) = explode('-', $origen);
	if($tabla=='' OR $id==''){	$c2= 'er';	$er2= 'Faltan datos. '; }
}

// Validacion
if($c1== 'er' OR $c2== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2." </label></center>"; 

}else{
	$_SESSION['v_cod_mat']= $cod_mat;	    	 		$_SESSION['v_usu'] = $usu; 			 		$_SESSION['v_depo_logueado'] = $depo_logueado; 
	$_SESSION['v_movil']= $movil;						$_SESSION['v_cant']= $cant;				 	$_SESSION['v_destino']= $destino;
	$_SESSION['v_tabla']= $tabla; 	                	$_SESSION['v_id']= $id;             
	?> <script type="text/javascript"> window.location="./funciones/mod2_sol_material_add.php"; </script><?php
}
?>