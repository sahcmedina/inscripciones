<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('contactos.php');	$C = new Contacto();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST['nombre']))   { $nombre   = $_POST['nombre'];   } else { $nombre   = ''; }
if (isset($_POST['apellido'])) { $apellido = $_POST['apellido']; } else { $apellido = ''; }
if (isset($_POST['correo']))   { $correo   = $_POST['correo'];   } else { $correo   = ''; }
if (isset($_POST['telefono'])) { $telefono = $_POST['telefono']; } else { $telefono = ''; }
if (isset($_POST['horarios'])) { $horarios = $_POST['horarios']; } else { $horarios = ''; }

$img = $_FILES['foto']['name'];

if (isset($_POST['m_argoliva']))     { $m_argoliva     = $_POST['m_argoliva'];     } else { $m_argoliva     = ''; }
if (isset($_POST['m_concurso']))     { $m_concurso     = $_POST['m_concurso'];     } else { $m_concurso     = ''; }
if (isset($_POST['m_concurso_nac'])) { $m_concurso_nac = $_POST['m_concurso_nac']; } else { $m_concurso_nac = ''; }
if (isset($_POST['m_rondas']))       { $m_rondas       = $_POST['m_rondas'];       } else { $m_rondas       = ''; }
if (isset($_POST['m_jornadas']))     { $m_jornadas     = $_POST['m_jornadas'];     } else { $m_jornadas     = ''; }
if (isset($_POST['m_chefs']))        { $m_chefs        = $_POST['m_chefs'];        } else { $m_chefs        = ''; }
if (isset($_POST['m_expo']))         { $m_expo         = $_POST['m_expo'];         } else { $m_expo         = ''; }

//------------------- VALIDO LOS DATOS. -------------------
$op ='ok';
$falta ='';
if($nombre =='' )    {$op='er'; $falta.='Falta Ingresar nombre \n';}
if($apellido =='' )  {$op='er'; $falta.='Falta Ingresar apellido \n';}
if($correo =='' )    {$op='er'; $falta.='Falta Ingresar correo \n';}
if($telefono =='' )  {$op='er'; $falta.='Falta Ingresar telefono \n';}
if($horarios ==''  ) {$op='er'; $falta.='Falta Ingresar horarios \n';}
if($img =='' )       {$op='er'; $falta.='Falta cargar foto del contacto \n';}
//-----------------------------------------------------------

switch ($op){
	case 'ok':
		$img_temp = 'img_temporal';
		$add  = $C->add($nombre, $apellido, $correo, $telefono, $horarios, $img_temp, $m_argoliva, $m_concurso, $m_concurso_nac, $m_rondas, $m_jornadas, $m_chefs, $m_expo);
		// si insertó bien la el registro, consulto el ultimo id guardado e inserto la imagen verdadera.
		if($add){
			$ult_id = $C->get_ultimo_id_insert();
			$nom_archivo= new SplFileInfo($img); 
			$extension  = $nom_archivo->getExtension(); 
			if(strlen($ult_id) == 1){
				$ult_id = '0'.$ult_id;
			}
			$str_nombre = 'contacto'.$ult_id.'.'.$extension;
			$directorio = "../images/contacto/".$str_nombre; 
			move_uploaded_file($_FILES['foto']['tmp_name'], $directorio);
			$add_img= $C->upd_imagen($ult_id, $str_nombre);
	
			if($add_img){	$_SESSION['var_retorno_']= 'add_con_ok'; $_SESSION['msj_retorno_']= 'El contacto se agregó satisfactoriamente.';}
			else{			$_SESSION['var_retorno_']= 'add_con_er'; $_SESSION['msj_retorno_']= 'No se pudo guardar la imagen.';}	
		}else{				$_SESSION['var_retorno_']= 'add_con_er'; $_SESSION['msj_retorno_']= 'No se pudo guardar contacto.';	}
	break;
	case 'er':
		$_SESSION['var_retorno_']= 'add_contacto_er'; $_SESSION['msj_retorno_']= 'Faltaron datos '.$falta;
	break;
}

// retorno
?><script type="text/javascript"> window.location="../_web_contactos.php"; </script>