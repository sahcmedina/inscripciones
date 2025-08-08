<?php
session_start();
include("mod4_ronda_inv.php"); $RI = new RondaInversiones();

if (isset($_POST["id_"]))           { $id= $_POST["id_"];     				} else { $id= '';  			}
if (isset($_POST["usuario"]))       { $user= $_POST["usuario"];     		} else { $user= '';  		}
if (isset($_POST["nombre"]))       	{ $nom= $_POST["nombre"];      			} else { $nom= '';   		}
if (isset($_POST["lugar_"]))       	{ $lug= $_POST["lugar_"];      			} else { $lug= '';   		}
if (isset($_POST["f1_"]))       	{ $f1= $_POST["f1_"];      				} else { $f1= '';   		}
if (isset($_POST["f2_"]))       	{ $f2= $_POST["f2_"];      				} else { $f2= '';   		}
if (isset($_POST["dsd_"]))  		{ $f_insc_dsd= $_POST["dsd_"];  		} else { $f_insc_dsd= '';   }
if (isset($_POST["hst_"]))  		{ $f_insc_hst= $_POST["hst_"];  		} else { $f_insc_hst= '';   }
if (isset($_POST["hs_"]))  	        { $hs= $_POST["hs_"];                 	} else { $hs= '';   		}
if (isset($_POST["chek"]))      	{ $chek= $_POST["chek"];            	} else { $chek= '';         }
$op = 'ok';

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($user=='' OR $nom=='' OR $lug=='' OR $f1=='' OR $hs=='' OR $f_insc_dsd=='' OR $f_insc_hst==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

//verifico que haya seleccionado al menos un sector
$c2= 'ok';	$er2= '';
if(!is_array($chek) OR count($chek)==0){ $c2= 'er';	$er2= 'Falta sector'; }

// Validacion
if($c1== 'er' OR $c2== 'er'){	$op = 'er';	 }

switch($op){

	case 'er':
			$a_tit= 'Error al actualizar';	  $a_sub= 'Errores: '.$er1.$er2;   $a_ico= 'error';	
			break;

	case 'ok':
			$add_ev= false;

			// upd ronda
			$upd = $RI->upd($id, $user, $nom, $lug, $f1, $f2, $f_insc_dsd, $f_insc_hst, $hs);

			// upd evento (para web)
			$upd_ev = $RI->upd_evento('RI', $id, $user, $nom, $lug, $f1, $f_insc_dsd, $f_insc_hst, $hs);

			// upd sectores
			if($upd && $upd_ev){
				// borro los sectores.
				$del = $RI->del_sectores_segun_ri($id);
				for($i=0 ; $i<count($chek) ; $i++){
					$id_sect = $chek[$i];
					$add_sect= $RI->add_sect($id, $id_sect, $user);
				}
				$a_tit= 'Registro actualizado';           $a_sub= '';		          $a_ico= 'success'; 
			}else{
				if($upd  && !$upd_ev)	$a_tit= 'Error al Modificar';	  $a_sub= 'No se modifico Evento, consulte con Administrador';   			$a_ico= 'error';	
				if(!$upd && $upd_ev)	$a_tit= 'Error al Modificar';	  $a_sub= 'No se modifico Ronda, consulte con Administrador';    			$a_ico= 'error';	
				if(!$upd && !$upd_ev)	$a_tit= 'Error al Modificar';	  $a_sub= 'No se modifico Ronda ni Evento, consulte con Administrador';     $a_ico= 'error';	
			}
			break;
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_ronda_inv_admin.php"; </script>