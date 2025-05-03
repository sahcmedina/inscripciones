<?php
session_start();
include("comite.php"); $Com = new Comite();

if (isset($_POST["usu"]))     		{ $usu= $_POST["usu"];      				} else { $usu= '';    			}
if (isset($_POST["ape"]))     		{ $ape= $_POST["ape"];    					} else { $ape= ''; 				}
if (isset($_POST["nom"]))     		{ $nom= $_POST["nom"];       				} else { $nom= '';    			}
if (isset($_POST["dnd_part_es"]))   { $dnd_part_es= $_POST["dnd_part_es"];      } else { $dnd_part_es= '';    	}
if (isset($_POST["dnd_part_in"]))   { $dnd_part_in= $_POST["dnd_part_in"];      } else { $dnd_part_in= '';    	}
if (isset($_POST["repres_es"]))     { $repres_es= $_POST["repres_es"];       	} else { $repres_es= '';    	}
if (isset($_POST["repres_in"]))     { $repres_in= $_POST["repres_in"];       	} else { $repres_in= '';    	}

$urll     = $_POST['url'];
// $urlll     = $_POST['url']['tmp_name'];
$nom_arch= new SplFileInfo($urll); 
$ext  = $nom_arch->getExtension(); 
$str_nom = '60'.$ext;
$directorio = "../images/comite/".$str_nom; 
if (move_uploaded_file($_FILES['url']['tmp_name'], $directorio)) {	$img_up = 'ok';	} 
else {											$img_up = 'er';	}

// $url     = $_FILES['url']['name'];
// $url_tmp = $_FILES['url']['tmp_name'];
echo '  ACA: '.$urll.'<>'.$nom_arch.'<>'.$ext.'<>'.$img_up; die();

// Control de datos
$op = 'ok';		
if($usu=='' OR $ape=='' OR $nom=='' OR $url=='' OR $dnd_part_es=='' OR $dnd_part_in=='' OR $repres_es=='' OR $repres_in=='' )	$op = 'er';

switch($op){

	case 'er':
				$str= '';
				if($usu == '')			$str .= 'Usuario, ';
				if($ape == '')			$str .= 'Apellido, ';
				if($nom == '')			$str .= 'Nombre, ';
				if($url == '')			$str .= 'Imagen, ';
				if($dnd_part_es == '')	$str .= 'Donde participa (Esp), ';
				if($dnd_part_in == '')	$str .= 'Donde participa (Ing), ';
				if($repres_es == '')	$str .= 'Inst. que representa (Esp), ';
				if($repres_in == '')	$str .= 'Inst. que representa (Ing), ';
				echo "<center><label style='font-weight:bold;color:red;'> Faltan datos: ".$str." </label></center>"; 
				break;

	case 'ok':
				// grabo el registro vacio con la imagen
				$add   = $Com->add_vacio();
				$ult_id= $Com->get_ultimo_id_insert();
				$nom_archivo= new SplFileInfo($url); 
				$extension  = $nom_archivo->getExtension(); 
				$str_nombre = $ult_id.'.'.$extension;
				$directorio = "../images/comite/".$str_nombre; 
				if (move_uploaded_file($url_tmp, $directorio)) {	$img_up = 'ok';	} 
				else {												$img_up = 'er';	}
				if($img_up == 'ok')	$add_img= $Com->upd_imagen($ult_id, $str_nombre);
				
				// preparo variables
				$_SESSION['var_new_persComite_usu']= $usu;							$_SESSION['var_new_persComite_ape']= $ape;	
				$_SESSION['var_new_persComite_nom']= $nom;							$_SESSION['var_new_persComite_id']= $ult_id;	
				$_SESSION['var_new_persComite_url']= $url;							$_SESSION['var_new_persComite_url_tmp'] = $url_tmp;
				$_SESSION['var_new_persComite_dnd_part_es'] = $dnd_part_es;		    $_SESSION['var_new_persComite_dnd_part_in']= $dnd_part_es;	            
				$_SESSION['var_new_persComite_repres_es'] = $repres_es;		        $_SESSION['var_new_persComite_repres_in']= $repres_in;	            
				?> <script type="text/javascript"> window.location="./funciones/comite_add.php"; </script><?php	
				break;

	default:	break;
}
?>