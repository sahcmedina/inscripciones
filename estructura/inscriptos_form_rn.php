<?php 
session_start();

if (isset($_POST['chek']))      { $arr_prod= $_POST['chek']; 	}    else { $arr_prod= '';     }
if (isset($_POST['c_v']))       { $c_v= $_POST['c_v']; 		    }    else { $c_v= '';      	   }
if (isset($_POST['prov']))     	{ $prov= $_POST['prov']; 		}    else { $prov= '';         }
if (isset($_POST['emp']))     	{ $emp= $_POST['emp']; 		    }    else { $emp= '';          }
if (isset($_POST['cuit']))     	{ $cuit= $_POST['cuit']; 		}    else { $cuit= '';         }
if (isset($_POST['resp']))     	{ $resp= $_POST['resp']; 		}    else { $resp= '';         }
if (isset($_POST['tel']))     	{ $tel= $_POST['tel']; 		    }    else { $tel= '';          }
if (isset($_POST['email']))     { $email= $_POST['email']; 		}    else { $email= '';        }
if (isset($_POST['id']))        { $id= $_POST['id']; 		    }    else { $id= '';           }

// Control: datos faltantes
$op = 'ok';
if($id=='' OR $c_v=='' OR $prov=='' OR $emp=='' OR $cuit=='' OR $resp=='' OR $tel=='' OR $email=='')	$op= 'dats_f';

// Control: # productos elegidos
if(count($arr_prod)== 0)	$op= 'prod_f';

switch($op){

	case 'dats_f':
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Faltaron datos, por favor intente de nuevo.';  		break;

	case 'prod_f':
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Debe elegir productos, por favor intente de nuevo.';  break;
			
	case 'ok':
			include_once('../_sis/funciones/mod3_ronda_neg.php');		$RN = new RondaNegocios();

			// add inscrip
			$id_inscrip= 0;
			$add       = $RN->add_inscrip($id, $emp, $cuit, $resp, $tel, $c_v, $prov, $email);
			$id_inscrip= $RN->get_last_id_inscrip();

			// add productos
			for($i=0 ; $i<count($arr_prod) ; $i++){
				$prod    = $arr_prod[$i];
				$add_prod= $RN->add_inscrip_prod($id_inscrip, $prod);
			}

			if($id_inscrip!= 0){	$a_ico= 'success';    $a_tit= 'Inscripción realizada';	 $a_sub= 'Nos comunicaremos vía email.';	 										}
			else{			        $a_ico= 'error';      $a_tit= 'Error';	                 $a_sub= 'Faltaron datos, por favor intente de nuevo.'; }
			break;

	default:
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Ocurrió un error, por favor intente de nuevo.';  		break;
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

// retorno
?><script type="text/javascript"> window.location="../index.php"  </script>