<?php
session_start();
date_default_timezone_set('America/Argentina/San_Juan');

if (isset($_SESSION['var_id_user'])) 	{ $id_user    = $_SESSION['var_id_user'];    } else { $id_user    = ''; }
if (isset($_SESSION['var_titulo'])) 	{ $titulo     = $_SESSION['var_titulo'];     } else { $titulo     = ''; }
if (isset($_SESSION['var_disertante'])) { $disertante = $_SESSION['var_disertante']; } else { $disertante = ''; }
if (isset($_SESSION['var_organismo'])) 	{ $organismo  = $_SESSION['var_organismo'];  } else { $organismo  = ''; }
if (isset($_SESSION['var_fecha'])) 		{ $fecha      = $_SESSION['var_fecha'];      } else { $fecha      = ''; }
if (isset($_SESSION['var_hora'])) 		{ $hora       = $_SESSION['var_hora'];       } else { $hora       = ''; }
if (isset($_SESSION['var_modalidad'])) 	{ $modalidad  = $_SESSION['var_modalidad'];  } else { $modalidad  = ''; }
if (isset($_SESSION['var_cupo'])) 		{ $cupo       = $_SESSION['var_cupo'];       } else { $cupo       = ''; }
if (isset($_SESSION['var_insc_inicio'])){ $insc_inicio= $_SESSION['var_insc_inicio'];} else { $insc_inicio= ''; }
if (isset($_SESSION['var_insc_final'])) { $insc_final = $_SESSION['var_insc_final']; } else { $insc_final = ''; }
if (isset($_SESSION['var_lugar'])) 		{ $lugar      = $_SESSION['var_lugar'];      } else { $lugar      = ''; }

// echo $lugar.' - '.$titulo.' - '.$fecha.' - '.$hora.' - '.$modalidad.' - '.$insc_inicio.' - '.$insc_final.' - '.$disertante.' - '.$organismo; die();

$opc= 'ok';
if($titulo=='' OR $fecha=='' OR $hora=='' OR $modalidad=='' OR $insc_inicio=='' OR $insc_final=='' OR $disertante=='' OR $organismo=='' ) $opc= 'er';

// Control de lugar y cupo 
if($modalidad=='Presencial'){ if($cupo=='' OR $lugar==''){ $opc= 'er';} }

// Control de las fechas que no se solapen
if($fecha < $insc_final)      { $opc= 'er'; }
if($insc_inicio > $insc_final){ $opc= 'er'; }

switch($opc){
    case 'ok':	
        $tipo='F'; $estado=1;
        $f_create = date("Y-m-d H:i:s");
        $f_update = ''; 
        include_once('./mod6_foros.php');	$For = new Foros();

        // PRIMERO TENGO QUE AGREGAR EL DETALLE PARA QUE EN LA CABECERA
        $add_det = $For->add_foro($disertante, $organismo, $modalidad, $cupo, $estado, $f_update, $id_user);
        if($add_det){
            $ult_id_foro = $For->get_last_id();
            // guardo cabecera. Tbl eventos
            $add_cab = $For->add_evento($tipo, $ult_id_foro, $titulo, $fecha, $hora, $lugar, $insc_inicio, $insc_final, $f_create, $id_user);
            if($add_cab){	$a_tit= 'Registro Agregado'; $a_sub= '';		          $a_ico= 'success'; }
            else{		    $a_tit= 'Error';	         $a_sub= 'Intente de Nuevo.'; $a_ico= 'error';   }
        }else{              $a_tit= 'Error';	         $a_sub= 'Intente de Nuevo.'; $a_ico= 'error';   }
    break;
    case 'er':
		$a_tit= 'Error al Agregar Cabecera';	  $a_sub= 'Intente nuevamente.';   $a_ico= 'error';	
	break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_foros_.php"; </script>