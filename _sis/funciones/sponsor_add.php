<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('sponsor.php');	$S = new Sponsor();

//------------------ RECIBO LOS DATOS ----------------------------

if (isset($_POST['titulo_es']))    { $titulo_es    = $_POST['titulo_es'];    } else { $titulo_es    = ''; }
if (isset($_POST['titulo_in']))    { $titulo_in    = $_POST['titulo_in'];    } else { $titulo_in    = ''; }
if (isset($_POST['subtitulo_es'])) { $subtitulo_es = $_POST['subtitulo_es']; } else { $subtitulo_es = ''; }
if (isset($_POST['subtitulo_in'])) { $subtitulo_in = $_POST['subtitulo_in']; } else { $subtitulo_in = ''; }
if (isset($_POST['nombre_emp']))   { $empresa      = $_POST['nombre_emp'];   } else { $empresa      = ''; }
if (isset($_POST['url_emp']))      { $url          = $_POST['url_emp'];      } else { $url          = ''; }
if (isset($_POST['categoria']))    { $categoria    = $_POST['categoria'];    } else { $categoria    = ''; }
if (isset($_POST['comentario']))   { $comentario   = $_POST['comentario'];   } else { $comentario   = ''; }

$img = $_FILES['imagen']['name'];

// Control de datos
// $op = 'ok';		
if($empresa=='' OR $url=='' OR $img=='' OR $categoria== '' OR $titulo_es== '' OR $titulo_in== '' OR $subtitulo_es== '' OR $subtitulo_in== ''  )	$op = 'err';
else{
	$img_temp = 'img_temporal';
	$mostrar_web =0;
	$add  = $S->add($empresa, $url, $img_temp, $categoria, $comentario, $mostrar_web, $titulo_es, $titulo_in, $subtitulo_es, $subtitulo_in);
	if($add){
		$ult_id = $S->get_ultimo_id_insert();
		// recien ahora trabajo la imagen porque no puedo armar el nombre de la img hasta que no tenga el id

		$nom_archivo= new SplFileInfo($img); 
		$extension  = $nom_archivo->getExtension(); 
		if(strlen($ult_id) == 1){
			$ult_id = '0'.$ult_id;
		}
		$str_nombre = 'sponsor'.$ult_id.'.'.$extension;
		$directorio = "../images/sponsor/".$str_nombre; 
		move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio);
		$add_img= $S->upd_imagen($ult_id, $str_nombre);
	
		if($add_img){	$op= 'ok';						}
		else{			$op= 'err_subir_logo';	}
	
	}else{				$op= 'err_subir_sponsor';		}


}

switch ($op){
	case 'err':  		            $_SESSION['var_retorno_']= 'add_sponsor_er'; $_SESSION['msj_retorno_']= 'Error al agregar sponsor. Faltan Datos.'; 	break;
	case 'err_subir_sponsor':  		$_SESSION['var_retorno_']= 'add_sponsor_er'; $_SESSION['msj_retorno_']= 'Error en DB al subir datos del sponsor.'; 	break;
	case 'err_subir_logo':  	    $_SESSION['var_retorno_']= 'add_sponsor_er'; $_SESSION['msj_retorno_']= 'Error al subir el Logo.'; 			break;
	case 'ok': 						$_SESSION['var_retorno_']= 'add_sponsor_ok'; $_SESSION['msj_retorno_']= 'Se agregó el Sponsor'; 										break;
}

// retorno
?><script type="text/javascript"> window.location="../_web_sponsor.php"; </script>