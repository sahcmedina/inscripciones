<?php
session_start();

if (isset($_POST["id_e"]))     { $id_evento   = $_POST["id_e"];     } else { $id_evento   = ''; }
if (isset($_POST["id_f"]))     { $fk_evento   = $_POST["id_f"];     } else { $fk_evento   = ''; }
if (isset($_POST["titulo"]))   { $titulo      = $_POST["titulo"];   } else { $titulo      = ''; }
if (isset($_POST["dis"]))      { $disertante  = $_POST["dis"];      } else { $disertante  = ''; }
if (isset($_POST["org"]))      { $organismo   = $_POST["org"];      } else { $organismo   = ''; }
if (isset($_POST["fecha"]))    { $fecha       = $_POST["fecha"];   	} else { $fecha       = ''; }
if (isset($_POST["hora"]))     { $hora        = $_POST["hora"];    	} else { $hora        = ''; }
if (isset($_POST["mod"]))      { $modalidad   = $_POST["mod"];      } else { $modalidad   = ''; }
if (isset($_POST["cupo"]))     { $cupo        = $_POST["cupo"];     } else { $cupo        = ''; }
if (isset($_POST["i_inicio"])) { $insc_inicio = $_POST["i_inicio"]; } else { $insc_inicio = ''; }
if (isset($_POST["i_final"]))  { $insc_final  = $_POST["i_final"];  } else { $insc_final  = ''; }
if (isset($_POST["lugar"]))    { $lugar       = $_POST["lugar"]; 	} else { $lugar       = ''; }
if (isset($_POST["id_user"]))  { $id_user     = $_POST["id_user"]; 	} else { $id_user     = ''; }

//echo $id_evento.' - '.$fk_evento.' - '.$titulo.' - '.$disertante.' - '.$organismo.' - '.$fecha.' - '.$hora.' - '.$modalidad.' - '.$cupo.' - '.$insc_inicio.' - '.$insc_final.' - '.$lugar.' - '.$id_user; die();

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($titulo=='' OR $fecha=='' OR $hora=='' OR $modalidad=='' OR $insc_inicio=='' OR $insc_final=='' OR $disertante=='' OR $organismo=='')
{	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control Segun tipo de evento (presencial - online) cupo lugar
$c2= 'ok';	$er2= '';
if($modalidad=='Presencial'){
	if($cupo=='' OR $lugar==''){ 
		$c2= 'er';	$er2= 'Faltan cupo y/o lugar. '; 
	}
}

// Control de la fechas de la conferencia con el periodo de inscripcion
$c3= 'ok';	$er3= '';
if($fecha < $insc_final OR $insc_inicio > $fecha){ $c3= 'er';	$er3= 'Error. Fecha de inicio es menor a la fecha final de inscripcion. '; }

// control de las fechas del periodo de inscripcion
$c4= 'ok';	$er4= '';
if($insc_inicio > $insc_final){
	$c4= 'er';	$er4= 'Error. Periodo de inscripcion. Verifique las fechas. ';
}

// Validacion
if($c1== 'er' OR $c2== 'er' OR $c3== 'er' OR $c4== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1.$er2.$er3.$er4." </label></center>"; 
}else{
	if($modalidad=='OnLine'){ $cupo=''; $lugar=''; }
	
	$_SESSION['var_id_e']       = $id_evento;
	$_SESSION['var_id_f']       = $fk_evento;
	$_SESSION['var_titulo']     = $titulo;
	$_SESSION['var_dis']        = $disertante;
	$_SESSION['var_org']        = $organismo;
	$_SESSION['var_fecha']      = $fecha;
	$_SESSION['var_hora']       = $hora;
	$_SESSION['var_modalidad']  = $modalidad;
	$_SESSION['var_cupo']       = $cupo;
	$_SESSION['var_insc_inicio']= $insc_inicio;
	$_SESSION['var_insc_final'] = $insc_final;
	$_SESSION['var_lugar']      = $lugar;
	$_SESSION['var_id_user']    = $id_user;

	?> <script type="text/javascript"> window.location="./funciones/mod6_foro_upd.php"; </script><?php		
}
?>