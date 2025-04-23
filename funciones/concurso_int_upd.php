<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('concurso_int.php');	$Con = new Concurso_int();

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))                { $id                = $_POST["id"];                } else { $id       = ''; }
if (isset($_POST["habilitar"]))         { $habilitar         = $_POST["habilitar"];         } else { $habilitar   = ''; }
if (isset($_POST["deshabilitar"]))      { $deshabilitar      = $_POST["deshabilitar"];      } else { $deshabilitar = ''; }
if (isset($_POST["mostrar_jurado"]))    { $mostrar_jurado    = $_POST["mostrar_jurado"];    } else { $mostrar_jurado   = ''; }
if (isset($_POST["mostrar_ganadores"])) { $mostrar_ganadores = $_POST["mostrar_ganadores"]; } else { $mostrar_ganadores = ''; }

// verifico los datos
$op='ok';
$falta='';
if($habilitar =='' )         {$op='er'; $falta.='Falta Fecha de habilitación. \n';}
if($deshabilitar =='' )      {$op='er'; $falta.='Falta Fecha de deshabilitar. \n';}
if($mostrar_jurado =='' )    {$op='er'; $falta.='Falta mostrar jurado. \n';}
if($mostrar_ganadores =='' ) {$op='er'; $falta.='Falta mostrar ganadores. \n';}

if($falta == ''){$op='ok'; }else{ $op='er'; }

switch($op){
	case 'er': $_SESSION['var_retorno_']= 'upd_con_er'; $_SESSION['msj_retorno_']= 'Datos Faltantes.'.$falta; break;
	case 'ok':
		$archivos = array(); $nombres = array(); $nominput = array(); $actuales = array();
		$actuales = $Con->gets_nombres_archivos($id); // obtengo el nombre de los archivos que actualmente hay para borrarlos

		$archivos[0] = $_FILES['reglamento_es']['name']; // recibo archivo español
		$archivos[1] = $_FILES['reglamento_en']['name']; // recibo archivo ingles

		$anio = date("Y");
		$nombres[0] = 'Reglamento_ArgOliva_'.$anio.'_esp'; // nombres que deben llevar segun idioma
		$nombres[1] = 'Reglamento_ArgOliva_'.$anio.'_ing';

		$nominput[0] = 'reglamento_es'; // nombre de los input del tipo file
		$nominput[1] = 'reglamento_en';
		
		for ($i=0; $i<2; $i++){
			if($archivos[$i] != '' ){ // consulto primero por el español
				$actual_ = '../reglamento/'.$actuales[0][$nominput[$i]];
				unlink($actual_);		// borro el archivo que está en la carpeta y que quiere subir.
				
				$nom_archivo= new SplFileInfo($archivos[$i]); 
				$extension  = $nom_archivo->getExtension();
				$str_nombre = $nombres[$i].'.'.$extension;

				$directorio = '../reglamento/'.$str_nombre;
				move_uploaded_file($_FILES[$nominput[$i]]['tmp_name'], $directorio);

				$nom[$i] = $nombres[$i].'.'.$extension;
			}else{ $nom[$i] = $nombres[$i].'.pdf'; }
		}
		$reglamento_es = $nom[0]; $reglamento_en = $nom[1];
		$mod = $Con->upd_concurso($id, $habilitar, $deshabilitar, $mostrar_jurado, $mostrar_ganadores, $reglamento_es, $reglamento_en);
		if($mod){
			$_SESSION['var_retorno_']= 'upd_con_ok';  $_SESSION['msj_retorno_']= 'Los parámetros se Actualizaron Correctamente.';
		}else{
			$_SESSION['var_retorno_']= 'upd_con_er'; $_SESSION['msj_retorno_']= 'No se pudo actualizar los parámetros.';
		}
	break;
}
?>
<script type="text/javascript"> window.location="../_web_concurso_internacional.php"; </script>
