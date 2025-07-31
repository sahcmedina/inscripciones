<?php 
session_start();

if (isset($_POST['chek']))  { $arr_sect= $_POST['chek']; } else { $arr_sect= ''; }
if (isset($_POST['i_o']))   { $i_o     = $_POST['i_o'];  } else { $i_o     = ''; }
if (isset($_POST['prov']))  { $prov    = $_POST['prov']; } else { $prov    = ''; }
if (isset($_POST['emp']))   { $emp     = $_POST['emp'];  } else { $emp     = ''; }
if (isset($_POST['cuit']))  { $cuit    = $_POST['cuit']; } else { $cuit    = ''; }
if (isset($_POST['resp']))  { $resp    = $_POST['resp']; } else { $resp    = ''; }
if (isset($_POST['tel']))   { $tel     = $_POST['tel'];  } else { $tel     = ''; }
if (isset($_POST['email'])) { $email   = $_POST['email'];} else { $email   = ''; }
if (isset($_POST['id']))    { $id      = $_POST['id']; 	 } else { $id      = ''; }
if (isset($_POST['fk_id'])) { $fk_id   = $_POST['fk_id'];} else { $fk_id   = ''; }

// Control: datos faltantes
$op = 'ok';
if($id=='' OR $i_o=='' OR $prov=='' OR $emp=='' OR $cuit=='' OR $resp=='' OR $tel=='' OR $email=='')	$op= 'dats_f';

// Control: # productos elegidos
if(count($arr_sect)== 0)	$op= 'sect_f';

switch($op){

	case 'dats_f':
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Faltaron datos, por favor intente de nuevo.';  		break;

	case 'sect_f':
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Debe elegir sector/es, por favor intente de nuevo.';  break;
			
	case 'ok':
			include_once('../_sis/funciones/mod4_ronda_inv.php');	$RI = new RondaInversiones();

			// add inscrip
			$id_inscrip= 0;
			$add       = $RI->add_inscrip($fk_id, $emp, $cuit, $resp, $tel, $i_o, $prov, $email);
			$id_inscrip= $RI->get_last_id_inscrip();

			// add productos
			for($i=0 ; $i<count($arr_sect) ; $i++){
				$sect    = $arr_sect[$i];
				$add_sect= $RI->add_inscrip_sect($id_inscrip, $sect);
			}

			if($id_inscrip!= 0){	$a_ico= 'success';    $a_tit= 'Inscripción realizada';	 $a_sub= 'Nos comunicaremos vía email.';	 										}
			else{			        $a_ico= 'error';      $a_tit= 'Error';	                 $a_sub= 'Faltaron datos, por favor intente de nuevo.'; }
			break;

	default:
			$a_ico= 'error';      $a_tit= 'Error';	 $a_sub= 'Ocurrió un error, por favor intente de nuevo.';  		break;
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

// retorno
?><script type="text/javascript"> window.location="../index.php"  </script>