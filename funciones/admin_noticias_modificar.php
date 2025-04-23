<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('noticias.php');	$Not = new Noticias();


//  --------------- botones -----
if (isset($_POST["cancelar_upd"])) { $cancelar = $_POST["cancelar_upd"]; } else { $cancelar = ''; }
if (isset($_POST["aceptar_upd"]))  { $aceptar  = $_POST["aceptar_upd"];  } else { $aceptar  = ''; }

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["usuario"]))     { $usuario     = $_POST["usuario"];     } else { $usuario     = ''; }
if (isset($_POST["id"]))          { $id          = $_POST["id"];          } else { $id          = ''; }
if (isset($_POST["titulo"]))      { $titulo      = $_POST["titulo"];      } else { $titulo      = ''; }
if (isset($_POST["descripcion"])) { $descripcion = $_POST["descripcion"]; } else { $descripcion = ''; }
if (isset($_POST["contenido"]))   { $contenido   = $_POST["contenido"];   } else { $contenido   = ''; }

if (isset($_POST["img_original"])) { $img_actual = $_POST["img_original"]; } else { $img_actual = ''; }
if (isset($_POST["cambia_img"]))   { $cambia_img = $_POST["cambia_img"];   } else { $cambia_img = ''; }

$img_actual_ = '../images/noticias/'.$img_actual;

// --------------------- Consulto por el cambio de la imagen
if ($cancelar == 'cancelar') {
	?>
		<script type="text/javascript"> window.location="../_admin_noticias.php"; </script>
	<?php
}else{
	if ($aceptar == 'modificar'){
		$falta='';
		if ($cambia_img == 'Si') {
			$url = $_FILES['url']['name'];
			if ($url != ''){
				unlink($img_actual_); 						// elimino la que esta actualmente
				$nom_archivo = new SplFileInfo($url); 		// guardo el nombre del archivo original para luego obtener la extension del archivo
				$extension = $nom_archivo->getExtension(); 	//guardo la extension del archivo
				$nom_imagen = $id.'.'.$extension; 			// nuevo nombre de la imagen
				$directorio = "../images/noticias/".$nom_imagen; // guardo el nombre de la carpeta adonde la voy a subir
				move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
				$url = $nom_imagen;
			}else{
				$falta.= 'Falta Imagen \n';
			}
		}else{
			$url = $img_actual; // no quiero actualizar ninguna imagen
		}

//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------

		if($titulo == '')      {$falta.='Falta Ingresar un Título \n';}
		if($descripcion == '') {$falta.='Falta Ingresar una Descripcion \n';}
		if($contenido == '')   {$falta.='Falta Ingresar un Contenido \n';}

		$modificar = 0;
		if($falta == '') {$modificar = 1;}

		if($modificar == '1'){
			$f_subido = date("Y-m-d H:i:s"); 
			$mod = $Not->upd_noticia($id, $titulo, $descripcion, $url, $contenido, $f_subido, $usuario);
			
			if($mod == true){
				$modificar=2; // se actualizo corectamente
			}else{$modificar=3 ; } // no se pudieron actualizar los datos por problemas en la BD.
		}

		switch ($modificar){
		case '0': $_SESSION['var_retorno_']= 'upd_news_err'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta; break;
		case '2': $_SESSION['var_retorno_']= 'upd_news_ok';  $_SESSION['msj_retorno_']= 'La Noticias se Actualizó Correctamente.'; break;
		case '3': $_SESSION['var_retorno_']= 'upd_news_err'; $_SESSION['msj_retorno_']= 'No se Actualizo. Problemas al guardar los datos.'; break;
		}
		?><script type="text/javascript"> window.location="../_admin_noticias.php"; </script> <?php
	}
}
