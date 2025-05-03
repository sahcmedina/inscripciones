<?php
session_start();
include("concursantes.php"); $Con = new Concursantes();

if (isset($_POST["raz_soc"]))     	{ $raz_soc= $_POST["raz_soc"];      		} else { $raz_soc= '';    		}
if (isset($_POST["dni"]))     		{ $dni= $_POST["dni"];    					} else { $dni= ''; 				}
if (isset($_POST["cod_id"]))     	{ $cod_id= $_POST["cod_id"];       			} else { $cod_id= '';    		}
if (isset($_POST["dom"]))     		{ $dom= $_POST["dom"];       				} else { $dom= '';    			}
if (isset($_POST["tel"]))     		{ $tel= $_POST["tel"];       				} else { $tel= '';    			}
if (isset($_POST["web"]))     		{ $web= $_POST["web"];       				} else { $web= '';    			}
if (isset($_POST["pais"]))     		{ $pais= $_POST["pais"];       				} else { $pais= '';    			}
if (isset($_POST["provincia"]))     { $provincia= $_POST["provincia"];       	} else { $provincia= '';    	}
if (isset($_POST["provincia_arg"])) { $provincia_arg= $_POST["provincia_arg"];  } else { $provincia_arg= '';    }
if (isset($_POST["tipo"]))          { $tipo= $_POST["tipo"];                    } else { $tipo= '';             }
if (isset($_POST["tipo_int"]))      { $tipo_int= $_POST["tipo_int"];            } else { $tipo_int= '';         }

if (isset($_POST["volumen"]))       { $volumen= $_POST["volumen"];              } else { $volumen= '';          }
if (isset($_POST["categ_reg_int"])) { $categ_reg_int= $_POST["categ_reg_int"];  } else { $categ_reg_int= '';    }
if (isset($_POST["categ_reg_nac"])) { $categ_reg_nac= $_POST["categ_reg_nac"];  } else { $categ_reg_nac= '';    }

//  echo '  ACA: '.$raz_soc.'-'.$dni.'-'.$cod_id.'-'.$dom.'-'.$tel.'-'.$pais.'-'.$tipo.'-'.$volumen.'-'.$categ_reg_int.'-'.$categ_reg_nac; die();
 
if (isset($_POST["n_marca"]))     	{ $n_marca= $_POST["n_marca"];       		} else { $n_marca= '';    		}
if (isset($_POST["n_varietal"]))    { $n_varietal= $_POST["n_varietal"];       	} else { $n_varietal= '';    	}
if (isset($_POST["n_lote"]))     	{ $n_lote= $_POST["n_lote"];       			} else { $n_lote= '';    		}
if (isset($_POST["n_litros"]))     	{ $n_litros= $_POST["n_litros"];       		} else { $n_litros= '';    		}
if (isset($_POST["n_grupo"]))     	{ $n_grupo= $_POST["n_grupo"];       		} else { $n_grupo= '';    		}
if (isset($_POST["n_origen"]))     	{ $n_origen= $_POST["n_origen"];       		} else { $n_origen= '';    		}

if (isset($_POST["pres_i1"]))     	{ $pres_i1= $_POST["pres_i1"];       		} else { $pres_i1= '';    		}
if (isset($_POST["m_i1"]))     		{ $m_i1= $_POST["m_i1"];       				} else { $m_i1= '';    			}
if (isset($_POST["v_i1"]))     		{ $v_i1= $_POST["v_i1"];       				} else { $v_i1= '';    			}
if (isset($_POST["lo_i1"]))     	{ $lo_i1= $_POST["lo_i1"];       			} else { $lo_i1= '';    		}
if (isset($_POST["li_i1"]))     	{ $li_i1= $_POST["li_i1"];       			} else { $li_i1= '';    		}
if (isset($_POST["g_i1"]))     		{ $g_i1= $_POST["g_i1"];       				} else { $g_i1= '';    			}
if (isset($_POST["o_i1"]))     		{ $o_i1= $_POST["o_i1"];       				} else { $o_i1= '';    			}

if (isset($_POST["pres_i2"]))     	{ $pres_i2= $_POST["pres_i2"];       		} else { $pres_i2= '';    		}
if (isset($_POST["m_i2"]))     		{ $m_i2= $_POST["m_i2"];       				} else { $m_i2= '';    			}
if (isset($_POST["v_i2"]))     		{ $v_i2= $_POST["v_i2"];       				} else { $v_i2= '';    			}
if (isset($_POST["lo_i2"]))     	{ $lo_i2= $_POST["lo_i2"];       			} else { $lo_i2= '';    		}
if (isset($_POST["li_i2"]))     	{ $li_i2= $_POST["li_i2"];       			} else { $li_i2= '';    		}
if (isset($_POST["g_i2"]))     		{ $g_i2= $_POST["g_i2"];       				} else { $g_i2= '';    			}
if (isset($_POST["o_i2"]))     		{ $o_i2= $_POST["o_i2"];       				} else { $o_i2= '';    			}

if (isset($_POST["pres_i3"]))     	{ $pres_i3= $_POST["pres_i3"];       		} else { $pres_i3= '';    		}
if (isset($_POST["m_i3"]))     		{ $m_i3= $_POST["m_i3"];       				} else { $m_i3= '';    			}
if (isset($_POST["v_i3"]))     		{ $v_i3= $_POST["v_i3"];       				} else { $v_i3= '';    			}
if (isset($_POST["lo_i3"]))     	{ $lo_i3= $_POST["lo_i3"];       			} else { $lo_i3= '';    		}
if (isset($_POST["li_i3"]))     	{ $li_i3= $_POST["li_i3"];       			} else { $li_i3= '';    		}
if (isset($_POST["g_i3"]))     		{ $g_i3= $_POST["g_i3"];       				} else { $g_i3= '';    			}
if (isset($_POST["o_i3"]))     		{ $o_i3= $_POST["o_i3"];       				} else { $o_i3= '';    			}

if (isset($_POST["pres_i4"]))     	{ $pres_i4= $_POST["pres_i4"];       		} else { $pres_i4= '';    		}
if (isset($_POST["m_i4"]))     		{ $m_i4= $_POST["m_i4"];       				} else { $m_i4= '';    			}
if (isset($_POST["v_i4"]))     		{ $v_i4= $_POST["v_i4"];       				} else { $v_i4= '';    			}
if (isset($_POST["lo_i4"]))     	{ $lo_i4= $_POST["lo_i4"];       			} else { $lo_i4= '';    		}
if (isset($_POST["li_i4"]))     	{ $li_i4= $_POST["li_i4"];       			} else { $li_i4= '';    		}
if (isset($_POST["g_i4"]))     		{ $g_i4= $_POST["g_i4"];       				} else { $g_i4= '';    			}
if (isset($_POST["o_i4"]))     		{ $o_i4= $_POST["o_i4"];       				} else { $o_i4= '';    			}

// Control de datos de Empresa
$op1      = 'ok';		
$falta_emp= '';
if($raz_soc=='' OR $dni=='' OR $cod_id=='' OR $dom=='' OR $tel=='' OR $pais=='' OR $volumen=='')	$op1 = 'er';
if($op1 == 'er')	$falta_emp= 'Empresa, ';

$existe_cod_id = $Con->tf_existe_codigo_id($cod_id);
if($existe_cod_id ){	$falta_emp= 'Empresa (Codigo de identificación registrado), ';	$op1 ='er';}

if($pais != 7) $tipo_= $tipo_int;
else           $tipo_= $tipo; 		// Nac o Int o (Nac & Int) es decir: 1 / 2 / ambos

// Control de datos de Muestra Nacional
$op2      = 'ok';
$falta_nac= '';
if($tipo_==1 OR $tipo_=='ambos'){
	$op2      = 'ok';			
	if($n_marca=='' OR $n_varietal=='' OR $n_lote=='' OR $n_litros=='' OR $n_grupo=='' OR $n_origen=='')	$op2 = 'er';
	if($op2 == 'er')	$falta_nac = 'Muestra Nacional';
	if($n_litros <=0 ) 	$falta_nac = 'Muestra Nacional (cant. de litros >0)';
}

// Control de datos de 1° Muestra Internacional
$op_int1   = 'ok';
$falta_int1= ''; 
if($pres_i1 == 'si'){	
	if($m_i1=='' OR $v_i1=='' OR $lo_i1=='' OR $li_i1=='' OR $g_i1=='' OR $o_i1==''){	$falta_int1= '1° Muestra Internacional, '; 							$op_int1= 'er'; 	}
	if($li_i1 <=0 )                              									{	$falta_int1= '1° Muestra Internacional (cant. de litros >0), '; 	$op_int1= 'er'; 	}
}else{																					$falta_int1='';  													$op_int1= 'ok';		}

// Control de datos de 2° Muestra Internacional
$op_int2   = 'ok';
$falta_int2= ''; 
if($pres_i2 == 'si'){	
	if($m_i2=='' OR $v_i2=='' OR $lo_i2=='' OR $li_i2=='' OR $g_i2=='' OR $o_i2==''){	$falta_int2= '2° Muestra Internacional, '; 							$op_int2= 'er'; 	}
	if($li_i2 <=0 )                              									{	$falta_int2= '2° Muestra Internacional (cant. de litros >0), '; 	$op_int2= 'er'; 	}
}else{																					$falta_int2='';  													$op_int2= 'ok';		}

// Control de datos de 3° Muestra Internacional
$op_int3   = 'ok';
$falta_int3= ''; 
if($pres_i3 == 'si'){	
	if($m_i3=='' OR $v_i3=='' OR $lo_i3=='' OR $li_i3=='' OR $g_i3=='' OR $o_i3==''){	$falta_int3= '3° Muestra Internacional, '; 							$op_int3= 'er'; 	}
	if($li_i3 <=0 )                              									{	$falta_int3= '3° Muestra Internacional (cant. de litros >0), '; 	$op_int3= 'er'; 	}
}else{																					$falta_int3='';  													$op_int3= 'ok';		}

// Control de datos de 4° Muestra Internacional
$op_int4   = 'ok'; 
$falta_int4= ''; 
if($pres_i4 == 'si'){	
	if($m_i4=='' OR $v_i4=='' OR $lo_i4=='' OR $li_i4=='' OR $g_i4=='' OR $o_i4==''){	$falta_int4= '4° Muestra Internacional, '; 							$op_int4= 'er'; 	}
	if($li_i4 <=0 )                              									{	$falta_int4= '4° Muestra Internacional (cant. de litros >0), '; 	$op_int4= 'er'; 	}
}else{																					$falta_int4='';  													$op_int4= 'ok';		}

if($op1== 'er' OR $op2== 'er' OR $op_int1== 'er' OR $op_int2== 'er' OR $op_int3== 'er' OR $op_int4== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Faltan datos en sección: ".$falta_emp.$falta_nac.$falta_int1.$falta_int2.$falta_int3.$falta_int4." </label></center>"; 

}else{

	$_SESSION['var_raz_soc'] = $raz_soc;		$_SESSION['var_dni'] = $dni;				$_SESSION['var_cod_id'] = $cod_id;			    
	$_SESSION['var_dom']  = $dom;               $_SESSION['var_tel'] = $tel;		 		$_SESSION['var_web'] = $web;
	$_SESSION['var_pais'] = $pais;				$_SESSION['var_provincia'] = $provincia;	$_SESSION['var_provincia_arg'] = $provincia_arg;
	$_SESSION['var_tipo'] = $tipo_;							

	$_SESSION['var_vol'] = $volumen;			$_SESSION['var_categ_reg_int'] = $categ_reg_int;	$_SESSION['var_categ_reg_nac'] = $categ_reg_nac;

	$_SESSION['var_n_marca'] = $n_marca;		$_SESSION['var_n_varietal']= $n_varietal;	$_SESSION['var_n_lote'] = $n_lote;
	$_SESSION['var_n_litros']= $n_litros;		$_SESSION['var_n_grupo']= $n_grupo;			$_SESSION['var_n_origen'] = $n_origen;

	$_SESSION['var_pres_i1'] = $pres_i1;		
	$_SESSION['var_m_i1']= $m_i1;				$_SESSION['var_v_i1']= $v_i1;				$_SESSION['var_lo_i1'] = $lo_i1;
	$_SESSION['var_li_i1'] = $li_i1;		    $_SESSION['var_g_i1']= $g_i1;	            $_SESSION['var_o_i1'] = $o_i1;

	$_SESSION['var_pres_i2'] = $pres_i2;		
	$_SESSION['var_m_i2']= $m_i2;				$_SESSION['var_v_i2']= $v_i2;				$_SESSION['var_lo_i2'] = $lo_i2;
	$_SESSION['var_li_i2'] = $li_i2;		    $_SESSION['var_g_i2']= $g_i2;	            $_SESSION['var_o_i2'] = $o_i2;

	$_SESSION['var_pres_i3'] = $pres_i3;		
	$_SESSION['var_m_i3']= $m_i3;				$_SESSION['var_v_i3']= $v_i3;				$_SESSION['var_lo_i3'] = $lo_i3;
	$_SESSION['var_li_i3'] = $li_i3;		    $_SESSION['var_g_i3']= $g_i3;	            $_SESSION['var_o_i3'] = $o_i3;

	$_SESSION['var_pres_i4'] = $pres_i4;		
	$_SESSION['var_m_i4']= $m_i4;				$_SESSION['var_v_i4']= $v_i4;				$_SESSION['var_lo_i4'] = $lo_i4;
	$_SESSION['var_li_i4'] = $li_i4;		    $_SESSION['var_g_i4']= $g_i4;	            $_SESSION['var_o_i4'] = $o_i4;	

	?> <script type="text/javascript"> window.location="./funciones/usuario_concursante_validar_paso_3.php"; </script><?php		
}
?>