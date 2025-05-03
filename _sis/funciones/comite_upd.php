<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('comite.php');	$C = new Comite();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["usuario"]))  { $usuario  = $_POST["usuario"];  } else { $usuario  = ''; }
if (isset($_POST["id"]))       { $id       = $_POST["id"];       } else { $id       = ''; }
if (isset($_POST["apellido"])) { $apellido = $_POST["apellido"]; } else { $apellido = ''; }
if (isset($_POST["nombre"]))   { $nombre   = $_POST["nombre"];   } else { $nombre   = ''; }

if (isset($_POST["dnd_participa_es"])) { $dnd_participa_es = $_POST["dnd_participa_es"]; } else { $dnd_participa_es = ''; }
if (isset($_POST["dnd_participa_in"])) { $dnd_participa_in = $_POST["dnd_participa_in"]; } else { $dnd_participa_in = ''; }

if (isset($_POST["representa_es"])) { $representa_es = $_POST["representa_es"]; } else { $representa_es = ''; }
if (isset($_POST["representa_in"])) { $representa_in = $_POST["representa_in"]; } else { $representa_in = ''; }

if (isset($_POST["url"]))       { $url       = $_POST["url"];       } else { $url       = ''; } //foto vieja
if (isset($_POST["url_nueva"])) { $url_nueva = $_POST["url_nueva"]; } else { $url_nueva = ''; } //foto nueva

if (isset($_POST["cambia_img"])){ $cambia_img = $_POST["cambia_img"]; } else { $cambia_img = ''; }

// verifico los datos
$op='ok';
$falta='';
if($apellido == '')         {$op='er'; $falta.='Falta Ingresar el apellido. \n';}
if($nombre == '' )          {$op='er'; $falta.='Falta Ingresar el nombre del integrante. \n';} 
if($dnd_participa_es == '') {$op='er'; $falta.='Falta Ingresar lugar donde participa en español. \n';} 
if($dnd_participa_in == '') {$op='er'; $falta.='Falta Ingresar lugar donde participa en ingles. \n';}  
if($representa_es == '')    {$op='er'; $falta.='Falta Ingresar entidad que representa en español. \n';} 
if($representa_in == '')    {$op='er'; $falta.='Falta Ingresar entidad que representa en ingles. \n';}

if ($cambia_img == 'Si') {
	$logo_nuevo = $_FILES['url_nueva']['name'];
	if ($logo_nuevo == ''){
		$op='er';
		$falta.='Falta seleccionar una imagen';
	}
}

switch($op){
	case 'er': $_SESSION['var_retorno_']= 'upd_co_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta;
	break;
	case 'ok':
		if ($cambia_img == 'Si'){
			// borrar lo que hay actualmente
			$img_actual_ = "../images/comite/".$url;
			unlink($img_actual_);
			
			// subir la nueva imagen logo
			$logo_nuevo = $_FILES['url_nueva']['name'];
			$nom_archivo= new SplFileInfo($logo_nuevo); 
			$extension  = $nom_archivo->getExtension(); 
			
			$str_nombre = $id.'.'.$extension;
			$directorio = "../images/comite/".$str_nombre; 
			move_uploaded_file($_FILES['url_nueva']['tmp_name'], $directorio);
		}else{
			$str_nombre = $url;
		}

		$update_fecha = date("Y-m-d H:i:s");
		$mod = $C->upd_integrante($id, $apellido, $nombre, $dnd_participa_es, $dnd_participa_in, $representa_es, $representa_in, $str_nombre, $update_fecha, $usuario);
		if($mod){
			$_SESSION['var_retorno_']= 'upd_co_ok';  $_SESSION['msj_retorno_']= 'El Integrante se Actualizó Correctamente.';
		}else{
			$_SESSION['var_retorno_']= 'upd_co_er'; $_SESSION['msj_retorno_']= 'No se pudo actualizar los datos.';
		}
	break;
}
?>
<script type="text/javascript"> window.location="../_web_comite.php"; </script>
