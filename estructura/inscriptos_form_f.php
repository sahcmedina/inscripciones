<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
//------------------ RECIBO LOS DATOS ----------------------------
//if (isset($_POST['idevento']))  { $idevento  = $_POST['idevento']; } else { $idevento = ''; }
if (isset($_POST['fkevento']))  { $fkevento  = $_POST['fkevento']; } else { $fkevento = ''; }

if (isset($_POST['dni']))       { $dni       = $_POST['dni']; 		} else { $dni       = ''; }
if (isset($_POST['apellido']))  { $apellido  = $_POST['apellido']; 	} else { $apellido  = ''; }
if (isset($_POST['nombre']))    { $nombre    = $_POST['nombre']; 	} else { $nombre    = ''; }
if (isset($_POST['telefono']))  { $telefono  = $_POST['telefono']; 	} else { $telefono  = ''; }
if (isset($_POST['email']))     { $email     = $_POST['email']; 	} else { $email     = ''; }
if (isset($_POST['empresa']))   { $empresa   = $_POST['empresa']; 	} else { $empresa   = ''; }
if (isset($_POST['cargo']))     { $cargo     = $_POST['cargo']; 	} else { $cargo     = ''; }
if (isset($_POST['localidad'])) { $localidad = $_POST['localidad']; } else { $localidad = ''; }

//echo 'ACA: '.$idevento.' - '.$fkevento.' - '.$dni.' - '.$nombre.' - '.$apellido.' - '.$telefono.' - '.$email.' - '.$empresa.' - '.$cargo.' - '.$localidad; die();

// Control: datos faltantes
$op = 'ok';
if($dni=='' OR $nombre=='' OR $apellido=='' OR $telefono=='' OR $email=='' OR $empresa=='' OR $cargo=='' OR $localidad=='')	$op= 'dats_f';

switch($op){

	case 'dats_f':
		$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Faltaron datos, por favor intente de nuevo.'; break;
	case 'ok':
		include('../_sis/funciones/mod6_foros.php');	$For = new Foros();
		$add_ins= $For->add_inscripto($fkevento, $dni, $nombre, $apellido, $telefono, $email, $empresa, $cargo, $localidad);
		if($add_ins){	$a_ico= 'success';    $a_tit= 'Inscripción realizada';	 $a_sub= 'Nos comunicaremos vía email.'; 	 												}
		else{			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Ocurrió un error, por favor intente de nuevo.';  	 	}
		break;
	default:
		break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;
// retorno
?><script type="text/javascript"> window.location="../index.php"; </script>