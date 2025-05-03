<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('ronda_de_negocios.php');	$R = new RondaNegocios();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))             { $id             = $_POST["id"];             } else { $id             = ''; }
if (isset($_POST["titulo_es"]))      { $titulo_es      = $_POST["titulo_es"];      } else { $titulo_es      = ''; }
if (isset($_POST["titulo_in"]))      { $titulo_in      = $_POST["titulo_in"];      } else { $titulo_in      = ''; }

if (isset($_POST["descripcion_es"])) { $descripcion_es = $_POST["descripcion_es"]; } else { $descripcion_es = ''; }
if (isset($_POST["descripcion_in"])) { $descripcion_in = $_POST["descripcion_in"]; } else { $descripcion_in = ''; }

if (isset($_POST["contenido_es"]))   { $contenido_es   = $_POST["contenido_es"];   } else { $contenido_es   = ''; }
if (isset($_POST["contenido_in"]))   { $contenido_in   = $_POST["contenido_in"];   } else { $contenido_in   = ''; }

if (isset($_POST["img_original"]))   { $img_actual     = $_POST["img_original"];   } else { $img_actual     = ''; }
if (isset($_POST["cambia_img"]))     { $cambia_img     = $_POST["cambia_img"];     } else { $cambia_img     = ''; }

$img_actual_ = '../images/ronda_negocios/'.$img_actual;
//------------------------------------------------------------------
$falta ='';
if ($cambia_img == 'Si') {
	$url = $_FILES['url']['name'];
	if ($url != ''){
		unlink($img_actual_); 						// elimino la que esta actualmente
		$nom_archivo = new SplFileInfo($url); 		// guardo el nombre del archivo original para luego obtener la extension del archivo
		$extension = $nom_archivo->getExtension(); 	//guardo la extension del archivo
		$nom_imagen = $id.'.'.$extension; 			// nuevo nombre de la imagen
		$directorio = "../images/ronda_negocios/".$nom_imagen; // guardo el nombre de la carpeta adonde la voy a subir 
		move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
		$url = $nom_imagen;
	}else{
		$falta.= 'Falta Imagen \n';
	}
}else{
	$url = $img_actual; // no quiero actualizar ninguna imagen
}
//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------

if($titulo_es == '')      {$falta.='Falta Ingresar un Título en español \n';}
if($titulo_in == '')      {$falta.='Falta Ingresar un Título en ingles \n';}

if($descripcion_es == '') {$falta.='Falta Ingresar una Descripcion en español \n';}
if($descripcion_in == '') {$falta.='Falta Ingresar una Descripcion en ingles \n';}

if($contenido_es == '')   {$falta.='Falta Ingresar Contenido en español \n';}
if($contenido_in == '')   {$falta.='Falta Ingresar Contenido en ingles \n';}

$modificar = 0;
if($falta == '') {$modificar = 1;}

if($modificar == '1'){
	$mod = $R->upd_ronda_negocios($id, $titulo_es, $titulo_in, $descripcion_es, $descripcion_in, $contenido_es, $contenido_in, $url);
	if($mod == true){
		$modificar=2; // se actualizo corectamente
	}else{$modificar=3 ; } // no se pudieron actualizar los datos por problemas en la BD.
}

switch ($modificar){
	case '0': $_SESSION['var_retorno_']= 'upd_rdn_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta; break;
	case '2': $_SESSION['var_retorno_']= 'upd_rdn_ok';  $_SESSION['msj_retorno_']= 'El contenido de la pagina se Actualizó Correctamente.'; break;
	case '3': $_SESSION['var_retorno_']= 'upd_rdn_er'; $_SESSION['msj_retorno_']= 'No se Actualizo. Problemas al guardar los datos.'; break;
}
?><script type="text/javascript"> window.location="../_web_ronda_de_negocios.php"; </script> <?php

