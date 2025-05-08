<?php
session_start();

if (isset($_SESSION['var_id_e'])) 	    { $id_evento  = $_SESSION['var_id_e'];       } else { $id_evento   = ''; }
if (isset($_SESSION['var_id_c'])) 	    { $fk_evento  = $_SESSION['var_id_c'];       } else { $fk_evento   = ''; }
if (isset($_SESSION['var_titulo'])) 	{ $titulo     = $_SESSION['var_titulo'];     } else { $titulo      = ''; }
if (isset($_SESSION['var_dis']))        { $disertante = $_SESSION['var_dis'];        } else { $disertante  = ''; }
if (isset($_SESSION['var_org'])) 	    { $organismo  = $_SESSION['var_org'];        } else { $organismo   = ''; }
if (isset($_SESSION['var_fecha'])) 		{ $fecha      = $_SESSION['var_fecha'];      } else { $fecha       = ''; }
if (isset($_SESSION['var_hora'])) 		{ $hora       = $_SESSION['var_hora'];       } else { $hora        = ''; }
if (isset($_SESSION['var_modalidad'])) 	{ $modalidad  = $_SESSION['var_modalidad'];  } else { $modalidad   = ''; }
if (isset($_SESSION['var_cupo'])) 		{ $cupo       = $_SESSION['var_cupo'];       } else { $cupo        = ''; }
if (isset($_SESSION['var_insc_inicio'])){ $insc_inicio= $_SESSION['var_insc_inicio'];} else { $insc_inicio = ''; }
if (isset($_SESSION['var_insc_final'])) { $insc_final = $_SESSION['var_insc_final']; } else { $insc_final  = ''; }
if (isset($_SESSION['var_lugar'])) 		{ $lugar      = $_SESSION['var_lugar'];      } else { $lugar       = ''; }
if (isset($_SESSION['var_id_user'])) 	{ $id_user    = $_SESSION['var_id_user'];    } else { $id_user     = ''; }

//echo ' - '.$id_evento.' - '.$titulo.' - '.$fecha.' - '.$hora.' - '.$modalidad.' - '.$cupo.' - '.$insc_inicio.' - '.$insc_final.' - '.$lugar.' - '.$id_user.' - '.$fk_evento.' - '.$disertante.' - '.$organismo; die();

$opc= 'ok';
if($titulo=='' OR $fecha=='' OR $hora=='' OR $modalidad=='' OR $insc_inicio=='' OR $insc_final=='' OR $disertante=='' OR $organismo=='') $opc= 'er';

// Control de lugar y cupo 
if($modalidad=='Presencial'){ if($cupo=='' OR $lugar==''){ $opc= 'er';} }else{ if($modalidad=='OnLine'){ $cupo==''; $lugar=='';}}

// Control de las fechas que no se solapen
if($fecha < $insc_final OR $insc_inicio > $fecha) { $opc= 'er'; }
if($insc_inicio > $insc_final)                    { $opc= 'er'; }

switch($opc){
    case 'ok':	
        include_once('./mod5_conferencias.php');	$Con = new Conferencias();
        date_default_timezone_set('America/Argentina/San_Juan');
        $f_update = date("Y-m-d H:i:s");
        // actualizar los datos en la tabla eventos
        $upd_e = $Con->upd_evento($id_evento, $titulo, $fecha, $hora, $lugar, $insc_inicio, $insc_final);
        
        // actualizar los datos en la tabla foros
        $upd_f = $Con->upd_conferencia($fk_evento, $disertante, $organismo, $modalidad, $cupo, $f_update, $id_user);
        if($upd_e and $upd_e){	$a_tit= 'Registro Actualizado'; $a_sub= '';		          $a_ico= 'success'; }
        else{		$a_tit= 'Error';	         $a_sub= 'Intente de Nuevo.'; $a_ico= 'error';   }
	break;
    case 'er':
	    $a_tit= 'Error al Agregar';	  $a_sub= 'Intente nuevamente.';   $a_ico= 'error';	
	break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_conf_conferencias.php"; </script>