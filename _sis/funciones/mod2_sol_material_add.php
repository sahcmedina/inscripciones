<?php
session_start();

if (isset($_SESSION["v_cod_mat"])) 		{$cod_mat = $_SESSION["v_cod_mat"];				} else {$cod_mat ='';		}
if (isset($_SESSION["v_usu"]))         	{$usu= $_SESSION["v_usu"];						} else {$usu ='';			}
if (isset($_SESSION["v_depo_logueado"])){$depo_logueado= $_SESSION["v_depo_logueado"];	} else {$depo_logueado ='';	}
if (isset($_SESSION["v_movil"]))      	{$movil= $_SESSION["v_movil"];  				} else {$movil ='';			}
if (isset($_SESSION["v_cant"]))         {$cant= $_SESSION["v_cant"];	    			} else {$cant ='';			}
if (isset($_SESSION["v_destino"]))      {$dest= $_SESSION["v_destino"];				    } else {$dest='';		    }
if (isset($_SESSION["v_tabla"]))        {$tabla= $_SESSION["v_tabla"];		        	} else {$tabla ='';		    }
if (isset($_SESSION["v_id"]))           {$id= $_SESSION["v_id"];		        	    } else {$id ='';		    }

																												    $opc= 'ok';
if($cod_mat=='' OR $usu=='' OR $depo_logueado=='' OR $movil=='' OR $cant=='' OR $dest=='' OR $tabla=='' OR $id=='')	$opc= 'er';

switch($opc){

	case 'ok':	
		include('mod2_sol_material.php');	$Solic = new SolicitudMateriales();

		if($tabla== 'A'){
			include('mod2_ingresos.php');	     $Ing = new Ingresos();
			$arr_inv_a = array();
			$arr_inv_a = $Ing->gets_segun_id('inv_a', $id);
			$fk_arato  = $arr_inv_a[0]['fk_arato'];
		}else $fk_arato= 0;

		$add = $Solic->add($cod_mat, $usu, $depo_logueado, $movil, $cant, $dest, $tabla, $fk_arato);
		if($add){
			$a_ico= 'success';	$a_tit= 'Registro Agregado';	$a_sub= '';  
		}else{
			$a_ico= 'error';	$a_tit= 'Error al Agregar';	    $a_sub= 'Intente de nuevo';  
		}        
 		break;

 	case 'er':
		$a_tit= 'Error al Agregar';	  $a_ico= 'error';    $a_sub= 'Intente nuevamente, faltan datos';		 
 		break;
 }
 $_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;
 $_SESSION["depo_elegido"]= $fk_depo;

?> <script type="text/javascript"> window.location="../_ind_sol_materiales.php"; </script>
