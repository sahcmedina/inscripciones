<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('noticias.php');	$Not = new Noticias();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["usuario"]))         { $usuario     = $_POST["usuario"];         } else { $usuario     = ''; }
if (isset($_POST["add_titulo"]))      { $titulo      = $_POST["add_titulo"];      } else { $titulo      = ''; }
if (isset($_POST["add_descripcion"])) { $descripcion = $_POST["add_descripcion"]; } else { $descripcion = ''; }
if (isset($_POST["contenido"]))       { $contenido   = $_POST["contenido"];       } else { $contenido   = ''; }

// recibo la imagen para mostrar en la web -----------------------------------------------
$url = $_FILES['url']['name'];

//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------
$falta_datos ='';
$grabar='0';
// if($usuario!='' && $titulo!='' && $descripcion!='' && $contenido!='' && $url!='')	$grabar='1';
if($usuario == '')     {$falta_datos.='Falta un Usuario \n';}	
if($titulo  == '')     {$falta_datos.='Falta un Título \n';}
if($descripcion == '') {$falta_datos.='Falta Descripción \n';}
if($contenido == '')   {$falta_datos.='Falta un Contenido \n';}
if($url == '')         {$falta_datos.='Falta una Imagen \n';}

if($falta_datos == '') $grabar =1;

if($grabar== '1'){
	$url_tmp = 'sin_img';
	$f_subido = date("Y-m-d H:i:s"); 
	$insertar = $Not->add_noticia($titulo, $descripcion, $contenido, $url_tmp, $f_subido, $usuario);
	$ult_id   = $Not->ultimo_id_insertado();
	
	// recien ahora trabajo la imagen porque no puedo armar el nombre de la img hasta que no tenga el id
	$nom_archivo= new SplFileInfo($url); // guardo el nombre del archivo original para luego obtener la extension del archivo
	$extension  = $nom_archivo->getExtension(); //guardo la extension del archivo
	$str_nombre = $ult_id.'.'.$extension;
	$directorio = "../images/noticias/".$str_nombre; 
	move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
	
	$inser_img= $Not->upd_noticia_imagen($ult_id, $str_nombre);
}

switch ($grabar){
	case '0': $_SESSION['var_retorno_']= 'add_news_err'; $_SESSION['msj_retorno_']= 'Faltaron datos.'.$falta_datos; break;
	case '1': $_SESSION['var_retorno_']= 'add_news_ok';  $_SESSION['msj_retorno_']= 'La Noticias se Agregó Correctamente.'; break;
}

// retorno
?><script type="text/javascript"> window.location="../_admin_noticias.php"; </script>