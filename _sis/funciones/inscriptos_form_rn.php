<?php 
session_start();
// date_default_timezone_set('America/Argentina/San_Juan');
// include('carrusel_index.php');	$CI = new Carrusel_Index();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST['empresa']))   { $emp= $_POST['empresa']; 		}    else { $emp= '';      	}
if (isset($_POST['cuit']))     	{ $cuit= $_POST['cuit']; 		}    else { $cuit= '';      }
if (isset($_POST['persona']))   { $per= $_POST['persona']; 		}    else { $per= '';      	}
if (isset($_POST['tel']))     	{ $tel= $_POST['tel']; 			}    else { $tel= '';      	}
if (isset($_POST['participa'])) { $parti= $_POST['participa']; 	}    else { $parti= '';     }
if (isset($_POST['pais']))     	{ $pais= $_POST['pais']; 		}    else { $pais= '';      }
if (isset($_POST['email']))     { $email= $_POST['email']; 		}    else { $email= '';     }
$arr_prod_elegidos = $_POST["chek"];

echo 'ACA: '.$emp.'-'.$cuit;die();die();

// Control: datos faltantes
$op = 'ok';
if($emp=='' OR $cuit=='' OR $per=='' OR $tel=='' OR $parti=='' OR $pais=='' OR $email=='')	$op= 'dats_f';

// Control: # productos elegidos
if(count($arr_prod_elegidos)== 0)	$op= 'prod_f';

switch($op){

	case 'dats_f':
			$_SESSION['var_retorno_']= 'add_er'; 		 	$_SESSION['msj_retorno_']= 'Faltaron datos, por favor intente de nuevo.'; 	 		break;

	case 'prod_f':
			$_SESSION['var_retorno_']= 'add_er'; 		 	$_SESSION['msj_retorno_']= 'Debe elegir productos, por favor intente de nuevo.'; 	 break;

	case 'ok':
			include_once('ronda_inscriptos.php');	$RI = new RondaInscriptos();
			$id= $RI->add_inscrip($emp, $cuit, $per, $tel, $parti, $pais, $email);
			for($i=0 ; $i<count($arr_prod_elegidos) ; $i++){
				$prod= $arr_prod_elegidos[$i];
				$add_= $RI->add_prod($id, $prod, $parti);
			}
			if($id!= 0){	$_SESSION['var_retorno_']= 'add_ok'; 	$_SESSION['msj_retorno_']= ''; 	 												}
			else{			$_SESSION['var_retorno_']= 'add_er'; 	$_SESSION['msj_retorno_']= 'Faltaron datos, por favor intente de nuevo.'; 	 	}
			break;

	default:
			break;
}

// retorno
?><script type="text/javascript"> window.location="../ronda_negocios_inscrip.php"; </script>