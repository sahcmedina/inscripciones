<?php
session_start();
$knt= 0;

if (isset($_SESSION["v_dep"])) 			{$dep = $_SESSION["v_dep"];			} else {$dep ='';		}
if (isset($_SESSION["v_prov"]))         {$prov= $_SESSION["v_prov"];		} else {$prov ='';		}
if (isset($_SESSION["v_user"]))         {$fk_user= $_SESSION["v_user"];		} else {$fk_user ='';	}

if (isset($_SESSION["v_fk_depo"]))      {$fk_depo= $_SESSION["v_fk_depo"];  } else {$fk_depo ='';	}

if (isset($_SESSION["v_mat1"]))         {$hay_m1= $_SESSION["v_mat1"];	    } else {$hay_m1 ='';	}
if (isset($_SESSION["v_cant_1"]))       {$cant_1= $_SESSION["v_cant_1"];	} else {$cant_1 ='';	}
if (isset($_SESSION["v_cod_1"]))  		{$cod_1 = $_SESSION["v_cod_1"];		} else {$cod_1 ='';		}
if (isset($_SESSION["v_trat_1"]))      	{$trat_1= $_SESSION["v_trat_1"];	} else {$trat_1 ='';	}
if (isset($_SESSION["v_ara_1"]))      	{$ara_1= $_SESSION["v_ara_1"];  	} else {$ara_1 ='';  	}

																		$opc= 'ok';
if($dep=='' OR $prov=='' OR $cant_1=='' OR $cod_1=='' OR $trat_1=='')	$opc= 'er';

switch($opc){

	case 'ok':	

		include('mod2_ingresos.php');	$Ing = new Ingresos();

		if($trat_1== 'M')							$trat_1_= 'M';
		else{
			if($trat_1== 'P' && $ara_1=='0')		$trat_1_= 'P';
			else{
				if($trat_1== 'P' && $ara_1!='0')	$trat_1_= 'A';
			} 
		}

        // Grabo M1
		if($hay_m1 == 'si'){
			$arr_ult_reg  = $Ing->gets_ult_orden($trat_1_, $cod_1, $dep);
			if(count($arr_ult_reg) ==0 ){	
				// 1er registro: codigo - deposito
				$orden=0; $ant=0; $aho=$cant_1; $tot=$cant_1;
			}else{
				// existen otros reg
				$id_reg= $arr_ult_reg[0]['id'];
				$orden = $arr_ult_reg[0]['orden'];
				$total = $arr_ult_reg[0]['total'];

				$ant  = $total;
				$aho  = $cant_1;
				$tot  = $ant + $cant_1;

				// al "ult" reg lo marco en 0  
				$Ing->mdf_marca_ult($trat_1_, $id_reg, '0');
			}
			
 			$add_m1 = $Ing->add($trat_1_, $cod_1, $dep, $ara_1, $ant, $aho, $tot, '1', '', $prov, '', $fk_user, ($orden+1) );
			if($add_m1)	$knt ++;
		}		
		
		if($knt >0){
			$a_ico= 'success';	$a_tit= 'Registro Agregado';	$a_sub= 'En total: '.$knt.' registros.';  
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

?> <script type="text/javascript"> window.location="../_depositos_inventario.php"; </script>
