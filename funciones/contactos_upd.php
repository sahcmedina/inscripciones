<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('contactos.php');	$C = new Contacto();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))       { $id       = $_POST["id"];       } else { $id       = ''; }
if (isset($_POST["nombre"]))   { $nombre   = $_POST["nombre"];   } else { $nombre   = ''; }
if (isset($_POST["apellido"])) { $apellido = $_POST["apellido"]; } else { $apellido = ''; }
if (isset($_POST["correo"]))   { $correo   = $_POST["correo"];   } else { $correo   = ''; }
if (isset($_POST["telefono"])) { $telefono = $_POST["telefono"]; } else { $telefono = ''; }
if (isset($_POST["horarios"])) { $horarios = $_POST["horarios"]; } else { $horarios = ''; }

if (isset($_POST["m_argoliva"]))     { $m_argoliva     = $_POST["m_argoliva"];     } else { $m_argoliva     = ''; }
if (isset($_POST["m_concurso"]))     { $m_concurso     = $_POST["m_concurso"];     } else { $m_concurso     = ''; }
if (isset($_POST["m_concurso_nac"])) { $m_concurso_nac = $_POST["m_concurso_nac"]; } else { $m_concurso_nac = ''; }
if (isset($_POST["m_rondas"]))       { $m_rondas       = $_POST["m_rondas"];       } else { $m_rondas       = ''; }
if (isset($_POST["m_jornadas"]))     { $m_jornadas     = $_POST["m_jornadas"];     } else { $m_jornadas     = ''; }
if (isset($_POST["m_chefs"]))        { $m_chefs        = $_POST["m_chefs"];        } else { $m_chefs        = ''; }
if (isset($_POST["m_expo"]))         { $m_expo         = $_POST["m_expo"];         } else { $m_expo         = ''; }

if (isset($_POST["foto_actual"])) { $foto_actual = $_POST["foto_actual"]; } else { $foto_actual = ''; }
if (isset($_POST["cambia_img"]))  { $cambia_img  = $_POST["cambia_img"];  } else { $cambia_img  = ''; }

// verifico los datos
$op='ok';
$falta='';
if($nombre =='' )    {$op='er'; $falta.='Falta Ingresar nombre. \n';}
if($apellido =='' )  {$op='er'; $falta.='Falta Ingresar apellido. \n';}
if($correo =='' )    {$op='er'; $falta.='Falta Ingresar correo. \n';}
if($telefono =='' )  {$op='er'; $falta.='Falta Ingresar telefono. \n';}
if($horarios ==''  ) {$op='er'; $falta.='Falta Ingresar horarios. \n';}

if ($cambia_img == 'Si') {
	$foto_nueva = $_FILES['foto']['name'];
	if ($foto_nueva == ''){
		$op='er';
		$falta.='Falta seleccionar una imagen. \n';
	}
}

switch($op){
	case 'er': $_SESSION['var_retorno_']= 'upd_con_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta; break;
	case 'ok':
		if ($cambia_img == 'Si'){
			// borrar lo que hay actualmente
			$img_actual_ = "../images/contacto/".$foto_actual;
			unlink($img_actual_);
			
			// subir la nueva foto del contacto
			$foto_nueva = $_FILES['foto']['name'];
			$nom_archivo= new SplFileInfo($foto_nueva); 
			$extension  = $nom_archivo->getExtension(); 
			if(strlen($id) == 1){
				$id_nom = '0'.$id;
			}
			$str_nombre = 'contacto'.$id_nom.'.'.$extension;
			$directorio = "../images/contacto/".$str_nombre; 
			move_uploaded_file($_FILES['foto']['tmp_name'], $directorio);
		}else{
			$str_nombre = $foto_actual;
		}

		//$id, $nombre, $apellido, $correo, $telefono, $horarios, $m_argoliva, $m_concurso, $m_concurso_nac, $m_rondas, $m_jornadas, $m_chefs, $m_expo
		$mod = $C->upd_contacto($id, $nombre, $apellido, $correo, $telefono, $horarios, $str_nombre, $m_argoliva, $m_concurso, $m_concurso_nac, $m_rondas, $m_jornadas, $m_chefs, $m_expo);
		if($mod){
			$_SESSION['var_retorno_']= 'upd_con_ok';  $_SESSION['msj_retorno_']= 'El Contacto se Actualizó Correctamente.';
		}else{
			$_SESSION['var_retorno_']= 'upd_con_er'; $_SESSION['msj_retorno_']= 'No se pudo actualizar los datos.';
		}
	break;
}
?>
<script type="text/javascript"> window.location="../_web_contactos.php"; </script>
