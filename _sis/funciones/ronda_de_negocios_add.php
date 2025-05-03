<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('ronda_de_negocios.php');	$R = new RondaNegocios();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["titulo_es"]))      { $titulo_es      = $_POST["titulo_es"];      } else { $titulo_es      = ''; }
if (isset($_POST["titulo_in"]))      { $titulo_in      = $_POST["titulo_in"];      } else { $titulo_in      = ''; }

if (isset($_POST["descripcion_es"])) { $descripcion_es = $_POST["descripcion_es"]; } else { $descripcion_es = ''; }
if (isset($_POST["descripcion_in"])) { $descripcion_in = $_POST["descripcion_in"]; } else { $descripcion_in = ''; }

if (isset($_POST["contenido_es"]))   { $contenido_es   = $_POST["contenido_es"];   } else { $contenido_es   = ''; }
if (isset($_POST["contenido_in"]))   { $contenido_in   = $_POST["contenido_in"];   } else { $contenido_in   = ''; }

$url = $_FILES['url']['name'];

//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------
$falta ='';
if($titulo_es == '')      {$falta.='Falta Ingresar un Título en español \n';}
if($titulo_in == '')      {$falta.='Falta Ingresar un Título en ingles \n';}

if($descripcion_es == '') {$falta.='Falta Ingresar una Descripcion en español \n';}
if($descripcion_in == '') {$falta.='Falta Ingresar una Descripcion en ingles \n';}

if($contenido_es == '')   {$falta.='Falta Ingresar Contenido en español \n';}
if($contenido_in == '')   {$falta.='Falta Ingresar Contenido en ingles \n';}

if ($url == '')           {$falta.= 'Falta Imagen \n';}

$modificar = 0;
if($falta == '') {$modificar = 1;}

if($modificar == '1'){
	$url_tmp='imagen_tmp';
	$add = $R->add_contenido_ronda_negocios($titulo_es, $titulo_in, $descripcion_es, $descripcion_in, $contenido_es, $contenido_in, $url_tmp);
	if($add == true){
		$ult_id   = $R->get_ultimo_id_insert();

		// recien ahora trabajo la imagen porque no puedo armar el nombre de la img hasta que no tenga el id
		$nom_archivo= new SplFileInfo($url); 
		$extension  = $nom_archivo->getExtension(); 
		$str_nombre = $ult_id.'.'.$extension;
		$directorio = "../images/ronda_negocios/".$str_nombre; 
		move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
		$add_img= $R->upd_imagen($ult_id, $str_nombre);

		if($add_img){	$modificar=2;						}
		else{			$modificar=3;	}

		 // se actualizo corectamente
	}else{$modificar=3 ; } // no se pudieron actualizar los datos por problemas en la BD.
}

switch ($modificar){
	case '0': $_SESSION['var_retorno_']= 'add_rdn_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta; break;
	case '2': $_SESSION['var_retorno_']= 'add_rdn_ok'; $_SESSION['msj_retorno_']= 'El contenido de la pagina se Agregó Correctamente.'; break;
	case '3': $_SESSION['var_retorno_']= 'add_rdn_er'; $_SESSION['msj_retorno_']= 'No se Agregó. Problemas al guardar los datos.'; break;
}
?><script type="text/javascript"> window.location="../_web_ronda_de_negocios.php"; </script> <?php

