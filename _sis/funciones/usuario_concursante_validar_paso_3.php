<?php 
// Una Empresa arg puede participar en ambos concursos.

session_start();
include('concursantes.php');		    $Conc  = new Concursantes();

// recibo datos generales
if (isset($_SESSION["var_raz_soc"]))   			{ $raz_soc = $_SESSION["var_raz_soc"];         	} else { $raz_soc = ''; 	}
if (isset($_SESSION["var_cod_id"]))    			{ $cod_id = $_SESSION["var_cod_id"];       	   	} else { $cod_id = '';  	}
if (isset($_SESSION["var_dni"]))      	    	{ $dni= $_SESSION["var_dni"];                  	} else { $dni= '';   		}
if (isset($_SESSION["var_dom"]))         		{ $dom= $_SESSION["var_dom"];            	   	} else { $dom= '';   		}
if (isset($_SESSION["var_tel"]))         		{ $tel= $_SESSION["var_tel"];            		} else { $tel= '';   		}
if (isset($_SESSION["var_pais"]))         		{ $pais= $_SESSION["var_pais"];            		} else { $pais= '';   		}
if (isset($_SESSION["var_provincia_arg"]))  	{ $prov_arg= $_SESSION["var_provincia_arg"];    } else { $prov_arg= ''; 	}
if (isset($_SESSION["var_provincia"]))      	{ $prov= $_SESSION["var_provincia"];           	} else { $prov= '';   		}
if (isset($_SESSION["var_tipo"]))      	    	{ $tipo= $_SESSION["var_tipo"];                	} else { $tipo= '';   		}
if (isset($_SESSION["var_web"]))      	    	{ $web= $_SESSION["var_web"];                  	} else { $web= '';   		}

if (isset($_SESSION["var_vol"]))      	    	{ $volumen= $_SESSION["var_vol"];               } else { $volumen= '';   	}
if (isset($_SESSION["var_categ_reg_int"]))      { $categ_reg_int=$_SESSION["var_categ_reg_int"];} else { $categ_reg_int= '';}
if (isset($_SESSION["var_categ_reg_nac"]))      { $categ_reg_nac=$_SESSION["var_categ_reg_nac"];} else { $categ_reg_nac= '';}

// recibo datos Muestra Nacional
if (isset($_SESSION["var_n_marca"]))      	    { $n_marca= $_SESSION["var_n_marca"];          } else { $n_marca= '';  		}
if (isset($_SESSION["var_n_varietal"]))      	{ $n_varietal= $_SESSION["var_n_varietal"];    } else { $n_varietal= '';  	}
if (isset($_SESSION["var_n_lote"]))      	    { $n_lote= $_SESSION["var_n_lote"];            } else { $n_lote= '';  		}
if (isset($_SESSION["var_n_litros"]))      		{ $n_litros= $_SESSION["var_n_litros"];        } else { $n_litros= '';  	}
if (isset($_SESSION["var_n_grupo"]))      	    { $n_grupo= $_SESSION["var_n_grupo"];          } else { $n_grupo= '';  		}
if (isset($_SESSION["var_n_origen"]))      		{ $n_origen= $_SESSION["var_n_origen"];        } else { $n_origen= '';  	}

// recibo datos Muestra Internacional (G1)
if (isset($_SESSION["var_pres_i1"]))      		{ $presenta_i1= $_SESSION["var_pres_i1"];  		} else { $presenta_i1= '';  }
if (isset($_SESSION["var_g_i1"]))      			{ $grupo_i1= $_SESSION["var_g_i1"];        		} else { $grupo_i1= '';  	}
if (isset($_SESSION["var_m_i1"]))      			{ $marca_i1= $_SESSION["var_m_i1"];        		} else { $marca_i1= '';  	}
if (isset($_SESSION["var_v_i1"]))      			{ $varietal_i1= $_SESSION["var_v_i1"];  		} else { $varietal_i1= '';  }
if (isset($_SESSION["var_lo_i1"]))      	    { $lote_i1= $_SESSION["var_lo_i1"];         	} else { $lote_i1= '';      }
if (isset($_SESSION["var_li_i1"]))      		{ $litros_i1= $_SESSION["var_li_i1"];      		} else { $litros_i1= '';  	}
if (isset($_SESSION["var_o_i1"]))      			{ $origen_i1= $_SESSION["var_o_i1"];      		} else { $origen_i1= '';  	}

// recibo datos Muestra Internacional (G2)
if (isset($_SESSION["var_pres_i2"]))      		{ $presenta_i2= $_SESSION["var_pres_i2"];  		} else { $presenta_i2= '';  }
if (isset($_SESSION["var_g_i2"]))      			{ $grupo_i2= $_SESSION["var_g_i2"];        		} else { $grupo_i2= '';  	}
if (isset($_SESSION["var_m_i2"]))      			{ $marca_i2= $_SESSION["var_m_i2"];        		} else { $marca_i2= '';  	}
if (isset($_SESSION["var_v_i2"]))      			{ $varietal_i2= $_SESSION["var_v_i2"];  		} else { $varietal_i2= '';  }
if (isset($_SESSION["var_lo_i2"]))      	    { $lote_i2= $_SESSION["var_lo_i2"];          	} else { $lote_i2= '';      }
if (isset($_SESSION["var_li_i2"]))      		{ $litros_i2= $_SESSION["var_li_i2"];      		} else { $litros_i2= '';  	}
if (isset($_SESSION["var_o_i2"]))      			{ $origen_i2= $_SESSION["var_o_i2"];      		} else { $origen_i2= '';  	}

// recibo datos Muestra Internacional (G3)
if (isset($_SESSION["var_pres_i3"]))      		{ $presenta_i3= $_SESSION["var_pres_i3"];  		} else { $presenta_i3= '';  }
if (isset($_SESSION["var_g_i3"]))      			{ $grupo_i3= $_SESSION["var_g_i3"];        		} else { $grupo_i3= '';  	}
if (isset($_SESSION["var_m_i3"]))      			{ $marca_i3= $_SESSION["var_m_i3"];        		} else { $marca_i3= '';  	}
if (isset($_SESSION["var_v_i3"]))      			{ $varietal_i3= $_SESSION["var_v_i3"];  		} else { $varietal_i3= '';  }
if (isset($_SESSION["var_lo_i3"]))      		{ $lote_i3= $_SESSION["var_lo_i3"];          	} else { $lote_i3= '';      }
if (isset($_SESSION["var_li_i3"]))      		{ $litros_i3= $_SESSION["var_li_i3"];      		} else { $litros_i3= '';  	}
if (isset($_SESSION["var_o_i3"]))      			{ $origen_i3= $_SESSION["var_o_i3"];      		} else { $origen_i3= '';  	}

// recibo datos Muestra Internacional (G4)
if (isset($_SESSION["var_pres_i4"]))      		{ $presenta_i4= $_SESSION["var_pres_i4"];  		} else { $presenta_i4= '';  }
if (isset($_SESSION["var_g_i4"]))      			{ $grupo_i4= $_SESSION["var_g_i4"];        		} else { $grupo_i4= '';  	}
if (isset($_SESSION["var_m_i4"]))      			{ $marca_i4= $_SESSION["var_m_i4"];        		} else { $marca_i4= '';  	}
if (isset($_SESSION["var_v_i4"]))      			{ $varietal_i4= $_SESSION["var_v_i4"];  		} else { $varietal_i4= '';  }
if (isset($_SESSION["var_lo_i4"]))      	    { $lote_i4= $_SESSION["var_lo_i4"];          	} else { $lote_i4= '';      }
if (isset($_SESSION["var_li_i4"]))      		{ $litros_i4= $_SESSION["var_li_i4"];      		} else { $litros_i4= '';  	}
if (isset($_SESSION["var_o_i4"]))      			{ $origen_i4= $_SESSION["var_o_i4"];      		} else { $origen_i4= '';  	}

// Controles se realizaron en Funciones/ajax_validar_paso_3
$hubo_error= false;

// echo 'ACA: '.$raz_soc.'-'.$cod_id.'-'.$dom.'-'.$tel.'-'.$pais.'-'.$prov_arg.'-'.$prov.'-'.$tipo.'-'.$web.'-'.$dni;die();

// grabo datos empresa
$id_emp = $Conc->add_empresa($raz_soc, $cod_id, $dom, $tel, $pais, $prov_arg, $prov, $web, $dni, $volumen, $categ_reg_int, $categ_reg_nac);
if($id_emp== 0) $hubo_error= true;

// grabo datos muestras
if(!$hubo_error){
	$add_muestra  = true;
	$add_muestra_1= true;
	$add_muestra_2= true;
	$add_muestra_3= true;
	$add_muestra_4= true;

	// Nac
	if($tipo == 1  OR  $tipo == 'ambos'){
		$codigo_1        = $Conc->aux_generar_codigo();
		$add_muestra_nac = $Conc->add_muestra($id_emp, $n_marca, $n_varietal, $n_lote, $n_litros, $n_grupo, $n_origen, '1', $codigo_1);
		if( !$add_muestra_nac)	$add_muestra= false;
	}
	// Int
	if($presenta_i1== 'si'){	
		$codigo_2       = $Conc->aux_generar_codigo();
		$add_muestra_i1 = $Conc->add_muestra($id_emp, $marca_i1, $varietal_i1, $lote_i1, $litros_i1, '1', $origen_i1, '2', $codigo_2);
		if( !$add_muestra_i1)	$add_muestra_1= false;
	}
	if($presenta_i2== 'si'){
		$codigo_3       = $Conc->aux_generar_codigo();
		$add_muestra_i2 = $Conc->add_muestra($id_emp, $marca_i2, $varietal_i2, $lote_i2, $litros_i2, '2', $origen_i2, '2', $codigo_3);
		if( !$add_muestra_i2)	$add_muestra_2= false;
	}
	if($presenta_i3== 'si'){
		$codigo_4       = $Conc->aux_generar_codigo();	
		$add_muestra_i3 = $Conc->add_muestra($id_emp, $marca_i3, $varietal_i3, $lote_i3, $litros_i3, '3', $origen_i3, '2', $codigo_4);
		if( !$add_muestra_i3)	$add_muestra_3= false;
	}
	if($presenta_i4== 'si'){  
		$codigo_5       = $Conc->aux_generar_codigo();
		$add_muestra_i4 = $Conc->add_muestra($id_emp, $marca_i4, $varietal_i4, $lote_i4, $litros_i4, '4', $origen_i4, '2', $codigo_5);
		if( !$add_muestra_i4)	$add_muestra_4= false;
	}

	if($add_muestra && $add_muestra_1 && $add_muestra_2 && $add_muestra_3 && $add_muestra_4){
		$_SESSION['var_retorno_']= 'add_emp_muestras_ok';	
		$_SESSION['msj_retorno_']= '';
	}else{
		$_SESSION['var_retorno_']= 'add_emp_muestras_er';	
		$_SESSION['msj_retorno_']= 'Por favor revise las muestras subidas. Ocurrio un error al grabar en DB.';
	}

}else{
	$_SESSION['var_retorno_']= 'add_emp_muestras_er';	
	$_SESSION['msj_retorno_']= 'Por favor revise los datos de le Empresa. Ocurrio un error al grabar en DB.';
}

// re direcciono a dashboard
?> <script type="text/javascript"> window.location="../principal.php";  </script><?php 