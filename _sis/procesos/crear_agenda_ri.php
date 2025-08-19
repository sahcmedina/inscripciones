<?php
	session_start();
	
	// ------------------------------ SISTEMA ------------------------------ //
	error_reporting(E_ALL ^ E_NOTICE);
	include_once('../funciones/mod4_ronda_inv.php');	        $RI     = new RondaInversiones();
	include_once('../funciones/mod4_ri_agenda.php');	        $RondAg = new RI_Agenda();
	date_default_timezone_set('America/Argentina/San_Juan');
	$user = $_SESSION['var_usu_ri'];
	$id_ri= $_SESSION['var_id_ri'];
	
	// ------------------------------ FUNCION ------------------------------ //	
	##                    eventos_ronda_inv_inscrip_sect
	## 1 - Se lee la tabla "ronda_inscriptos_prod" y llenamos la tabla "ronda_union_cv" (match entre C y V)
	## 2 - Se llena 1° fila de compradores
	## 3 - Recorremos la tabla "ronda_union_cv" y llenamos la tabla "ronda_agenda_1" con la fila de compradores
	## 4 - Se crean vistas y se liberan las tablas del procesamiento.

	## El proceso se aborta si: 
	##    (a) no hay disponibilidad de tablas para trabajar: 3 grupos de 4 tablas en total (aux_agenda_1_d1, etc)
	##    (b) cantidad de productos elegidos por los participantes: (productos a C = 0) o (productos a V = 0)
	##    (c) no hay match entre empresas C y empresas V
	
	
	// CTRL 1 - averiguo disponibilidad de tablas para trabajar. 
	$arr_disponib = array();
	$arr_disponib = $RondAg->gets('aux_agenda_uso');
	$n_1          = $arr_disponib[0]['t_1'];
	$n_2          = $arr_disponib[0]['t_2'];
	$n_3          = $arr_disponib[0]['t_3'];
	$hay          = 0;
	if($n_1 != 1 OR $n_2 != 1 OR $n_3 != 1){
		if($n_1 != 1){             $hay=1; }
		if($hay== 0 && $n_2 != 1){ $hay=2; }
		if($hay== 0 && $n_3 != 1){ $hay=3; }
	}

	// CTRL 2 - reviso cantidad de productos en esa RN
	$knt_sect_i = $RI->get_cant_total('i', $id_ri);
	$knt_sect_o = $RI->get_cant_total('o', $id_ri);
	$msj_       = '';

	if($knt_sect_i==0 OR $knt_sect_o==0){
		if($knt_sect_i == 0)	$msj_ = ' Inversores'; 
		if($knt_sect_o == 0){	if($msj_ == '')  $msj_= ' Oferentes'; else $msj_.= ', Oferentes';}	
		
		// Se corta el proceso (b) --> redirecciono
		$a_tit= 'No se puede procesar';	  $a_sub= 'Faltan: '.$msj_;   $a_ico= 'error';	
		$_SESSION['alert_tit']= $a_tit;	  $_SESSION['alert_sub']= $a_sub;	                             $_SESSION['alert_ico']= $a_ico;
		?> <script type="text/javascript"> window.location="../_ronda_inv_agenda.php"; </script><?php
		die();
	}
	
	// a- asigno las tablas a usar && inicializo
	if($hay!= 0){
		$tab_1    = 'aux_agenda_'.$hay.'_d1';
		$tab_1_aux= 'aux_agenda_'.$hay.'_d1_aux';
		$tab_2    = 'aux_agenda_'.$hay.'_d2';
		$tab_2_aux= 'aux_agenda_'.$hay.'_d2_aux';
		
		
		$RondAg->aux_inicializar($tab_1);
		$RondAg->aux_inicializar($tab_1_aux);
		$RondAg->aux_inicializar($tab_2);
		$RondAg->aux_inicializar($tab_2_aux);

		$RondAg->upd_usar_tabla($hay);

		$correr_proc_1 = 'si';	
		$correr_proc_2 = 'si';	
		$correr_proc_3 = 'si';
		$t_1 = 0;
		$t_2 = 0;
		
	}else{

		// Se corta el proceso (a): no hay tabla desocupada para correr el proceso --> redirecciono
		$a_tit= 'No se puede procesar';	  $a_sub= 'Hay 2 procesos en curso, intente en otro momento.';   $a_ico= 'error';	
		$_SESSION['alert_tit']= $a_tit;	  $_SESSION['alert_sub']= $a_sub;	                             $_SESSION['alert_ico']= $a_ico;
		?> <script type="text/javascript"> window.location="../_ronda_inv_agenda.php"; </script><?php
		die();
	}	
	

	// ----------------------------------------------------------------------------------------------
	// 1 - Completar tabla: eventos_ronda_inv_union_io (match entre I y O de c/producto) ------------
	// ----------------------------------------------------------------------------------------------
	
	if($correr_proc_1 == 'si'){

		$arr_emp_io_sect = array();
		$arr_emp_io_sect = $RI->gets_emp_io_sect($id_ri);

		$arr_sect = array();
		$arr_sect = $RI->gets_sectores($id_ri);

		$arr_sect_viables  = array();
		$arr_filas_a_grabar= array();
		
		// Para c/Producto traigo #C y #V
		for($i=0 ; $i<count($arr_sect) ; $i++){
			$knt_i = $RI->get_cant($arr_sect[$i]['id_sect'], 'i', $id_ri);
			$knt_o = $RI->get_cant($arr_sect[$i]['id_sect'], 'o', $id_ri); 
			
			$arr_i= array();
			$arr_o= array();

			if($knt_i >0 && $knt_o >0){
				
				$arr_i = $RI->gets_io_sect('i', $arr_sect[$i]['id_sect'], $id_ri); // Emp q invierten X sector
				$arr_o = $RI->gets_io_sect('o', $arr_sect[$i]['id_sect'], $id_ri); // Emp q ofrecen  X sector 

				// lleno tabla de "union I-O"
				for($j=0 ; $j<count($arr_i) ; $j++){
					$id_emp_i = $arr_i[$j]['fk_insc'];
					for($k=0 ; $k<count($arr_o) ; $k++){
						$id_emp_o = $arr_o[$k]['fk_insc'];

						// si no esta el reg -> lo agrego a la tabla
						$existe= $RI->tf_existe_par_io($id_emp_i, $id_emp_o, $id_ri);  					
						if(!$existe OR $existe==0)	$add_par = $RI->add_par_io($id_emp_i, $id_emp_o, $id_ri);					
					}
				}
			}	
		}

		// Ctrl para saber si cortar el proceso x (matching = 0)
		$existe_match = $RI->tf_existe_match($id_ri);
		if(!$existe_match){

			// Libero tablas
			$upd_libTabla_= $RondAg->upd_liberar_tabla($hay);
			$del_libtabla_= $RondAg->del_config($id_ri); 
			$del_union_io = $RondAg->del_union_io($id_ri); 

			if($upd_libTabla_ && $del_libtabla_ && $del_union_io){		$msj_2= '';
			}else{ 		if(!$upd_libTabla_)             				$msj_2= ' (Error al liberar agenda_uso)';
				        if(!$del_libtabla_)             				$msj_2= ' (Error al borrar agenda_config)';
				        if(!$del_union_io)             			    	$msj_2= ' (Error al borrar union_cv)';
			}

			// Se corta el proceso (c) --> redirecciono
			$a_tit= 'No se puede procesar';	  $a_sub= 'No hay Match entre Empresas Inversoras y Oferentes.'.$msj_2;   $a_ico= 'error';	
			$_SESSION['alert_tit']= $a_tit;	  $_SESSION['alert_sub']= $a_sub;	                                $_SESSION['alert_ico']= $a_ico;
			?> <script type="text/javascript"> window.location="../_ronda_inv_agenda.php"; </script><?php
			die();
		}
		
	}

	// ----------------------------------------------------------------------------------------------
	// 2 - En aux_agenda_X_d1_aux o d2_aux lleno (1°) fila de compradores ---------------------------
	// ----------------------------------------------------------------------------------------------

	if($correr_proc_2 == 'si'){

		$tabla         = $tab_1;
		$tabla_aux     = $tab_1_aux;
		
		// lleno 1ª fila de compradores (tabla ronda_agenda_1)
		$arr_invierte= array();
		$arr_invierte= $RI->gets_invierten($id_ri);
		$cant_i    = count($arr_invierte);
		$ind       = 1;
		for($i=0 ; $i<$cant_i ; $i++){
			$add = $RondAg->add_i($tabla_aux, $ind, $arr_invierte[$i]['i']);
			$ind++;
		}
		
		// copio tabla resultado
		$vac = $RondAg->aux_vaciar($tab_2_aux);
		$upd = $RondAg->aux_copiar($tab_2_aux, $tabla_aux);
	}	
	

	// ----------------------------------------------------------------------------------------------
	// 3  -------------------------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------
	
	if($correr_proc_3 == 'si'){

		// traigo en un array las diferentes "Emp V" (tabla union_cv)
		$arr_ofrecen = $RI->gets_ofrecen($id_ri);
		$knt_ofrecen = count($arr_ofrecen);

		// Para cada "Emp V" busco sus tuplas y agrego en AUX1, (si todas entran) copio a Agenda1 (sino) comienzo a trabajar en AUX2 y Agenda2
		for($i=0 ; $i<$knt_ofrecen ; $i++){

			$empO = $arr_ofrecen[$i]['o'];

			// busco todas "Emp I" para esa empresa O
			$arr_empI = $RI->gets_empI_para_empO($id_ri, $empO);
			$knt_empI = count($arr_empI);

			$reg_add  = 0;			
			
			// lleno tabla Agenda con cada dupla de esa "Emp O"
			for($j=0 ; $j<$knt_empI ; $j++){

				$emp_i = $arr_empI[$j]['emp_i'];
				$emp_o = $empO;		
				$col_i = $RondAg->get_col($tabla_aux, $emp_i); // en q col esta la dupla_i?

				// debo agregar la empresa en "col_c" (en 1er fila vacia (!=1) PERO q no este en otra col)
				$arr_filas_a_grabar = $RondAg->gets_fila_a_grabar($tabla_aux, $emp_o);
				$band = 0;
				for($p=0 ; ($p<count($arr_filas_a_grabar)) && ($band==0) ; $p++){
					$fila_aConsultar= $arr_filas_a_grabar[$p]['id'];                            
					$ocupado        = $RondAg->tf_filaOcupada($tabla_aux, $col_i, $fila_aConsultar); 
					if(!$ocupado){                                                               
						$add = $RondAg->add_o($tabla_aux, $col_i, $emp_o, $fila_aConsultar);         
						if($add){	$reg_add++;    $band= 1;  $t_1= 1;}                                                          
					}				
				}	
			}
			
			// controlo si se agregaron todas las duplas
			if($knt_empI == $reg_add){
				$vac = $RondAg->aux_vaciar($tabla);
				$upd = $RondAg->aux_copiar($tabla, $tabla_aux);
			}else{
				// tabla Agenda llena (se van a extender las reuniones para el día 2)
				$tabla     = $tab_2;
				$tabla_aux = $tab_2_aux;
				$i         = $i-1;
				$t_2       = 1;
			}
		}

	}

	// ----------------------------------------------------------------------------------------------
	// 4 - Creo Vistas y libero tablas --------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------
		
	$f_proceso= Date('Y-m-d H:i:s');

	if($t_1 == 1){
		// Add vista
		$nbreTabla= 'agenda_ri_'.$id_ri.'_d1';
		$tablaOrig= 'aux_agenda_'.$hay.'_d1_aux';
		$addO     = $RondAg->add_tabla($nbreTabla, $tablaOrig);
		// Add referencia
		$updO     = $RondAg->aux_upd_config($id_ri, '1', $nbreTabla, $f_proceso, $user);
		// Ctrl
		if($addO && $updO)	$proceso1= true; else $proceso1= false;
	}
	if($t_2 == 1)	{
		// Add vista
		$nbreTabla_= 'agenda_ri_'.$id_ri.'_d2';
		$tablaOrig_= 'aux_agenda_'.$hay.'_d2_aux';
		$addO_     = $RondAg->add_tabla($nbreTabla_, $tablaOrig_);
		// Add referencia
		$updO_     = $RondAg->aux_upd_config($id_ri, '2', $nbreTabla_, $f_proceso, $user);
		// Ctrl
		if($addO_ && $updO_)	$proceso2= true; else $proceso2= false;
	}

	// Libero tablas
	$upd_libTabla_2= $RondAg->upd_liberar_tabla($hay);
	$del_union_io_2= $RondAg->del_union_io($id_ri); 
	if($upd_libTabla_2 && $del_union_io_2){		$proceso3= true;  $msj_3= '';
	}else{ 		if(!$upd_libTabla_2)            $proceso3= false; $msj_3= ' (Error al liberar agenda_uso)';
				if(!$del_union_io_2)            $proceso3= false; $msj_3= ' (Error al borrar union_io)';
	}

	// ----------------------------------------------------------------------------------------------
	// 5 - Control final ----------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------

	$op= 'ok';
	if($t_1==1){		          if(!$proceso1)	$op= 'er';	 $msj='Al procesar día 1.';       }
	if($op=='ok' && $t_2==1){	  if(!$proceso2)	$op= 'er';	 $msj='Al procesar día 2.';       }
	if($op=='ok' && !$proceso3){		            $op= 'er';   $msj='Al liberar tabla.'.$msj_3; }

	if($op=='ok'){  $RondAg->aux_inicializar($tab_1);
					$RondAg->aux_inicializar($tab_1_aux);
					$RondAg->aux_inicializar($tab_2);
					$RondAg->aux_inicializar($tab_2_aux);
					$a_tit= 'Proceso completado';	  $a_sub= '';                              $a_ico= 'success';  
	}else{          $a_tit= 'Error';	              $a_sub= $msj.' Intente de nuevo.';       $a_ico= 'error';    
	                $del  = $RondAg->del_config($id_ri); 
	}

	$_SESSION['alert_tit']= $a_tit;	    $_SESSION['alert_sub']= $a_sub;	    $_SESSION['alert_ico']= $a_ico;

	// ----------------------------------------------------------------------------------------------
	// 6 - Redirecciono -----------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------

	?> <script type="text/javascript"> window.location="../_ronda_inv_agenda.php"; </script>