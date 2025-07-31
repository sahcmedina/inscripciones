<?php
session_start();
include("mod4_ronda_inv.php"); $RI = new RondaInversiones();

if (isset($_POST["usuario"]))       { $user      = $_POST["usuario"];    } else { $user      = ''; }
if (isset($_POST["nom_"]))       	{ $nom       = $_POST["nom_"];       } else { $nom       = ''; }
if (isset($_POST["lug_"]))       	{ $lug       = $_POST["lug_"];       } else { $lug       = ''; }
if (isset($_POST["f1"]))       		{ $f1        = $_POST["f1"];      	 } else { $f1        = ''; }
if (isset($_POST["f2"]))       		{ $f2        = $_POST["f2"];      	 } else { $f2        = ''; }
if (isset($_POST["f_insc_dsd"]))  	{ $f_insc_dsd= $_POST["f_insc_dsd"]; } else { $f_insc_dsd= ''; }
if (isset($_POST["f_insc_hst"]))  	{ $f_insc_hst= $_POST["f_insc_hst"]; } else { $f_insc_hst= ''; }
if (isset($_POST["hs"]))  	        { $hs        = $_POST["hs"];         } else { $hs        = ''; }
if (isset($_POST["chek"]))      	{ $chek      = $_POST["chek"];       } else { $chek      = ''; }
$op = 'ok';

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($user=='' OR $nom=='' OR $lug=='' OR $f1=='' OR $hs=='' OR $f_insc_dsd=='' OR $f_insc_hst=='' OR count($chek)==0){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: El nombre existe?
$c2= 'ok';	$er2= '';
$existe = $RI->tf_existe_nombre($nom);
if($existe){ $c2= 'er';  $er2= 'Repite nombre. ';	}

// Validacion
if($c1== 'er' OR $c2== 'er'){	$op = 'er';	 }

switch($op){

	case 'er':
			$a_tit= 'Error al Agregar';	  $a_sub= 'Errores: '.$er1.$er2;   $a_ico= 'error';	
			break;

	case 'ok':
			$id_ri = 0;
			$add_ev= false;

			// agregar ronda inv
			$add  = $RI->add($user, $nom, $lug, $f1, $f2, $f_insc_dsd, $f_insc_hst, $hs);
			$id_ri= $RI->get_last_id_ri();

			// agregar evento (para web)
			if($id_ri != 0)	$add_ev = $RI->add_evento('RI', $id_ri, $nom, $f1, $hs, $lug, $f_insc_dsd, $f_insc_hst, $user);

			// agregar sectores
			if($add && $add_ev){	
				for($i=0 ; $i<count($chek) ; $i++){
					$id_sect = $chek[$i];
					$add_sect= $RI->add_sect($id_ri, $id_sect, $user);
				}
				$a_tit= 'Registro Agregado';           $a_sub= '';		          $a_ico= 'success'; 
			}else{
				if($add  && !$add_ev)	$a_tit= 'Error al Agregar';	  $a_sub= 'No se agrego Evento, consulte con Administrador';   			$a_ico= 'error';	
				if(!$add && $add_ev)	$a_tit= 'Error al Agregar';	  $a_sub= 'No se agrego Ronda, consulte con Administrador';    			$a_ico= 'error';	
				if(!$add && !$add_ev)	$a_tit= 'Error al Agregar';	  $a_sub= 'No se agrego Ronda ni Evento, consulte con Administrador';   $a_ico= 'error';	
			}
			break;
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_inv_admin.php"; </script>