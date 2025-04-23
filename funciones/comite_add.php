<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('comite.php');	$Com = new Comite();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST['usuario']))     				{ $usu= $_POST['usuario'];      				} else { $usu= '';    			}
if (isset($_POST['add_ape']))     				{ $ape= $_POST['add_ape'];    					} else { $ape= ''; 				}
if (isset($_POST['add_nom']))     				{ $nom= $_POST['add_nom'];       				} else { $nom= '';    			}
if (isset($_POST['add_dnd_participa_es']))     	{ $dnd_part_es= $_POST['add_dnd_participa_es']; } else { $dnd_part_es= '';    	}
if (isset($_POST['add_dnd_participa_in'])) 		{ $dnd_part_in= $_POST['add_dnd_participa_in']; } else { $dnd_part_in= '';    	}
if (isset($_POST['add_representa_es'])) 		{ $repres_es= $_POST['add_representa_es'];    	} else { $repres_es= '';    	}
if (isset($_POST['add_representa_in']))   		{ $repres_in= $_POST['add_representa_in'];      } else { $repres_in= '';    	}
$url = $_FILES['url']['name'];
// echo '  ACA: '.$id.'-'.$url.'-'.$ape.'-'.$nom; die();

// Control de datos
$op = 'ok';		
if($usu=='' OR $ape=='' OR $nom=='' OR $url=='' OR $dnd_part_es=='' OR $dnd_part_in=='' OR $repres_es=='' OR $repres_in=='' )	$op = 'er';

$url_ = 'sin_img';
$f_   = date("Y-m-d H:i:s"); 
$add  = $Com->add($ape, $nom, $url_, $dnd_part_es, $dnd_part_in, $repres_es, $repres_in, $f_, $usu);

if($add){
	$ult_id   = $Com->get_ultimo_id_insert();

	// recien ahora trabajo la imagen porque no puedo armar el nombre de la img hasta que no tenga el id
	$nom_archivo= new SplFileInfo($url); 
	$extension  = $nom_archivo->getExtension(); 
	$str_nombre = $ult_id.'.'.$extension;
	$directorio = "../images/comite/".$str_nombre; 
	move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
	$add_img= $Com->upd_imagen($ult_id, $str_nombre);

	if($add_img){	$op= 'ok';						}
	else{			$op= 'err_subir_persona_img';	}

}else{				$op= 'err_subir_persona';		}

switch ($op){
	case 'err_subir_persona':  		$_SESSION['var_retorno_']= 'add_persCom_er'; $_SESSION['msj_retorno_']= 'Error en DB al subir datos de persona.'; 	break;
	case 'err_subir_persona_img':  	$_SESSION['var_retorno_']= 'add_persCom_er'; $_SESSION['msj_retorno_']= 'Error en DB al subir la imagen.'; 			break;
	case 'ok': 						$_SESSION['var_retorno_']= 'add_persCom_ok'; $_SESSION['msj_retorno_']= ''; 										break;
}

// retorno
?><script type="text/javascript"> window.location="../_web_comite.php"; </script>