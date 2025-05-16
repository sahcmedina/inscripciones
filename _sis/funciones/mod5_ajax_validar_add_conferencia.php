<?php
session_start();

if (isset($_POST["id_user"]))    { $id_user     = $_POST["id_user"];    } else { $id_user     = ''; }
if (isset($_POST["titulo"]))     { $titulo      = $_POST["titulo"];     } else { $titulo      = ''; }
if (isset($_POST["disertante"])) { $disertante  = $_POST["disertante"]; } else { $disertante  = ''; }
if (isset($_POST["organismo"]))  { $organismo   = $_POST["organismo"];  } else { $organismo   = ''; }
if (isset($_POST["fecha"]))      { $fecha       = $_POST["fecha"];      } else { $fecha       = ''; }
if (isset($_POST["hora"]))       { $hora        = $_POST["hora"];       } else { $hora        = ''; }
if (isset($_POST["mod"]))        { $modalidad   = $_POST["mod"];        } else { $modalidad   = ''; }
if (isset($_POST["cupo"]))       { $cupo        = $_POST["cupo"];       } else { $cupo        = ''; }
if (isset($_POST["i_inicio"]))   { $insc_inicio = $_POST["i_inicio"];   } else { $insc_inicio = ''; }
if (isset($_POST["i_final"]))    { $insc_final  = $_POST["i_final"];    } else { $insc_final  = ''; }
if (isset($_POST["lugar"]))      { $lugar       = $_POST["lugar"];      } else { $lugar       = ''; }

// echo '-'.$titulo.'-'.$disertante.'-'.$organismo.'-'.$fecha.'-'.$hora.'-'.$modalidad.'-'.$cupo.'-'.$insc_inicio.'-'.$insc_final.'-'.$lugar; die();

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($titulo=='' OR $fecha=='' OR $hora=='' OR $modalidad=='' OR $insc_inicio=='' OR $insc_final=='' OR $disertante=='' OR $organismo=='')
{	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control Segun tipo de evento (presencial - online) cupo lugar
$c2= 'ok';	$er2= '';
if($modalidad=='Presencial'){
	if($cupo=='' OR $lugar==''){ 
		$c2= 'er';	$er2= 'Faltan cupo y/o lugar'; 
	}
}

// Control de las fechas que no se solapen
$c3= 'ok';	$er3= '';
if($fecha < $insc_final){
	$c3= 'er';	$er3= 'Error. Fecha de inicio es menor a la fecha final de inscripcion. ';
}
$c4= 'ok';	$er4= '';
if($insc_inicio > $insc_final){
	$c4= 'er';	$er4= 'Error. Periodo de inscripcion. Verifique las fechas. ';
}
$c5= 'ok';	$er5= '';
if($insc_inicio > $fecha){
	$c5= 'er';	$er5= 'Error. Periodo de inscripcion. Verifique las fechas. ';
}

// Validacion
if($c1== 'er' OR $c2== 'er' OR $c3== 'er' OR $c4== 'er' OR $c5== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2.$er3.$er4.$er5." </label></center>"; 
}else{
	$_SESSION['var_titulo']     = $titulo;
	$_SESSION['var_disertante'] = $disertante;
	$_SESSION['var_organismo']  = $organismo;
	$_SESSION['var_fecha']      = $fecha;
	$_SESSION['var_hora']       = $hora;
	$_SESSION['var_modalidad']  = $modalidad;
	$_SESSION['var_cupo']       = $cupo;
	$_SESSION['var_insc_inicio']= $insc_inicio;
	$_SESSION['var_insc_final'] = $insc_final;
	$_SESSION['var_lugar']      = $lugar;
	$_SESSION['var_id_user']    = $id_user;
	
	?> <script type="text/javascript"> window.location="./funciones/mod5_conferencia_add.php"; </script><?php		
}
?>