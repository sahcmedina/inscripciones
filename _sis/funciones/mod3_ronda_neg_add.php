<?php
session_start();
include("mod3_ronda_neg.php");          $RN = new RondaNegocios();

if (isset($_SESSION["var_user"]))       { $user= $_SESSION["var_user"];     	    } else { $user= '';  		}
if (isset($_SESSION["var_nom"]))       	{ $nom= $_SESSION["var_nom"];      			} else { $nom= '';   		}
if (isset($_SESSION["var_lug"]))       	{ $lug= $_SESSION["var_lug"];      			} else { $lug= '';   		}
if (isset($_SESSION["var_f1"]))       	{ $f1= $_SESSION["var_f1"];      			} else { $f1= '';   		}
if (isset($_SESSION["var_f2"]))       	{ $f2= $_SESSION["var_f2"];      			} else { $f2= '';   		}
if (isset($_SESSION["var_f_insc_dsd"])) { $f_insc_dsd= $_SESSION["var_f_insc_dsd"]; } else { $f_insc_dsd= '';   }
if (isset($_SESSION["var_f_insc_hst"])) { $f_insc_hst= $_SESSION["var_f_insc_hst"]; } else { $f_insc_hst= '';   }
if (isset($_SESSION["var_hs"]))  	    { $hs= $_SESSION["var_hs"];                 } else { $hs= '';   		}
if (isset($_SESSION["var_chek"]))      	{ $chek= $_SESSION["var_chek"];            	} else { $chek= '';         }
$op = 'ok';

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($user=='' OR $nom=='' OR $lug=='' OR $f1=='' OR $hs=='' OR $f_insc_dsd=='' OR $f_insc_hst=='' OR count($chek)==0){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: F2?
if($f2=='')	$f2_='1900-01-01'; else $f2_=$f2;

// Validacion
if($c1== 'er'){	$op = 'er';	 }

switch($op){

	case 'er':	$a_tit= 'Error al Agregar';	  $a_sub= 'Errores: '.$er1;   $a_ico= 'error';		break;

	case 'ok':
			$id_rn = 0;
			$add_ev= false;

			// agregar ronda
			$add  = $RN->add($user, $nom, $lug, $f1, $f2_, $f_insc_dsd, $f_insc_hst, $hs);
			$id_rn= $RN->get_last_id_rn();

			// agregar evento (para web)
			if($id_rn != 0)	$add_ev = $RN->add_evento('RN', $id_rn, $nom, $f1, $hs, $lug, $f_insc_dsd, $f_insc_hst, $user);

			// agregar productos
			if($add && $add_ev){	
				for($i=0 ; $i<count($chek) ; $i++){
					$id_prod = $chek[$i];
					$add_prod= $RN->add_prod($id_rn, $id_prod, $user);
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

?> <script type="text/javascript"> window.location="../_ronda_neg_admin.php"; </script>