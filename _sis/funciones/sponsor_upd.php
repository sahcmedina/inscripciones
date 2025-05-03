<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('sponsor.php');	$S = new Sponsor();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))         { $id         = $_POST["id"];         } else { $id         = ''; }
if (isset($_POST['titulo_es']))    { $titulo_es    = $_POST['titulo_es'];    } else { $titulo_es    = ''; }
if (isset($_POST['titulo_in']))    { $titulo_in    = $_POST['titulo_in'];    } else { $titulo_in    = ''; }
if (isset($_POST['subtitulo_es'])) { $subtitulo_es = $_POST['subtitulo_es']; } else { $subtitulo_es = ''; }
if (isset($_POST['subtitulo_in'])) { $subtitulo_in = $_POST['subtitulo_in']; } else { $subtitulo_in = ''; }
if (isset($_POST["nombre"]))     { $nombre     = $_POST["nombre"];     } else { $nombre     = ''; }
if (isset($_POST["url"]))        { $url        = $_POST["url"];        } else { $url        = ''; }
if (isset($_POST["imagen"]))     { $imagen     = $_POST["imagen"];     } else { $imagen     = ''; }
if (isset($_POST["categoria"]))  { $categoria  = $_POST["categoria"];  } else { $categoria  = ''; }
if (isset($_POST["comentario"])) { $comentario = $_POST["comentario"]; } else { $comentario = ''; }

// echo 'SUB ESPANOL: '.$subtitulo_es.' SUN INGLES: '.$subtitulo_in; die;


if (isset($_POST["cambia_img"]))   { $cambia_img = $_POST["cambia_img"];   } else { $cambia_img = ''; }

// verifico los datos
$op='ok';
$falta='';

if($titulo_es == '') {$falta.='Falta Ingresar un Título español \n';}
if($titulo_in == '') {$falta.='Falta Ingresar un Título ingles \n';}
if($subtitulo_es == '') {$falta.='Falta Ingresar un Subtítulo español \n';}
if($subtitulo_in == '') {$falta.='Falta Ingresar un Subítulo ingles \n';}



if($nombre == '') {$falta.='Falta Ingresar un Título \n';}
if($url    == '') {$falta.='Falta Ingresar una direccion \n';}
if($categoria    == '') {$falta.='Falta seleccionar una Categoria \n';}
if ($cambia_img == 'Si') {
	$logo_nuevo = $_FILES['logo']['name'];
	if ($logo_nuevo == ''){
		$falta.='Falta seleccionar una imagen';
	}
}

if($falta==''){$op='ok';}else{$op='er';}

switch($op){
	case 'er': $_SESSION['var_retorno_']= 'upd_sp_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta;
	break;
	case 'ok':
		if ($cambia_img == 'Si'){
			// borrar lo que hay actualmente
			$img_actual_ = "../images/sponsor/".$imagen;
			unlink($img_actual_);
			
			// subir la nueva imagen logo
			$logo_nuevo = $_FILES['logo']['name'];
			$nom_archivo= new SplFileInfo($logo_nuevo); 
			$extension  = $nom_archivo->getExtension(); 
			if(strlen($id) == 1){
				$id_nom = '0'.$id;
			}
			$str_nombre = 'sponsor'.$id_nom.'.'.$extension;
			$directorio = "../images/sponsor/".$str_nombre; 
			move_uploaded_file($_FILES['logo']['tmp_name'], $directorio);
		}else{
			$str_nombre = $imagen;
		}
		$mod = $S->upd_sponsor($id, $nombre, $url, $str_nombre, $categoria, $comentario, $titulo_es, $titulo_in, $subtitulo_es, $subtitulo_in);
		if($mod){
			$_SESSION['var_retorno_']= 'upd_sp_ok';  $_SESSION['msj_retorno_']= 'El Sponsor se Actualizó Correctamente.';
		}else{
			$_SESSION['var_retorno_']= 'upd_sp_er'; $_SESSION['msj_retorno_']= 'No se pudo actualizar los datos.';
		}
	break;
}
?>
<script type="text/javascript"> window.location="../_web_sponsor.php"; </script>
