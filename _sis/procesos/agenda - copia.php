<?php
	session_start();
	
	// ------------------------------ SISTEMA ------------------------------ //
	error_reporting(E_ALL ^ E_NOTICE);
	include_once('../funciones/mod3_ronda_neg.php');	        $RN     = new RondaNegocios();
	include_once('../funciones/mod3_rn_agenda.php');	        $RondAg = new RN_Agenda();
	date_default_timezone_set('America/Argentina/San_Juan');
	$user = $_SESSION['var_usu_rn'];
	$id_rn= $_SESSION['var_id_rn'];
	
	// ------------------------------ FUNCION ------------------------------ //	
	## 1 - Se lee la tabla "ronda_inscriptos_prod" y llenamos la tabla "ronda_union_cv" (match entre C y V)
	## 2 - Se llena 1° fila de compradores
	## 3 - Recorremos la tabla "ronda_union_cv" y llenamos la tabla "ronda_agenda_1" con la fila de compradores

	## El proceso se aborta si: 
	##    (a) no hay disponibilidad de tablas para trabajar: 2 grupos de 4 tablas en total (aux_agenda_1_d1, etc)
	##    (b) cantidad de productos elegidos por los participantes: (productos a C = 0) o (productos a V = 0)
	##    (c) no hay match entre empresas C y empresas V
	
	
	// CTRL 1 - averiguo disponibilidad de tablas para trabajar. 
	$arr_disponib = array();
	$arr_disponib = $RondAg->gets('aux_agenda_uso');
	$n_1          = $arr_disponib[0]['t_1'];
	$n_2          = $arr_disponib[0]['t_2'];
	$hay          = 0;
	if($n_1 != 1 OR $n_2 != 1){
		if($n_1 != 1){             $hay=1; }
		if($hay== 0 && $n_2 != 1){ $hay=2; }
	}

	// CTRL 2 - reviso cantidad de productos en esa RN
	$knt_prod_c = $RN->get_cant_total('c', $id_rn);
	$knt_prod_v = $RN->get_cant_total('v', $id_rn);
	$msj_       = '';
	if($knt_prod_c==0 OR $knt_prod_v==0){
		if($knt_prod_c == 0)	$msj_ = ' Compradores'; 
		if($knt_prod_v == 0){	if($msj_ == '')  $msj_= ' Vendedores'; else $msj_.= ', Vendedores';}	
		
		// Se corta el proceso (b) --> redirecciono
		$a_tit= 'No se puede procesar';	  $a_sub= 'Faltan: '.$msj_;   $a_ico= 'error';	
		$_SESSION['alert_tit']= $a_tit;	  $_SESSION['alert_sub']= $a_sub;	                             $_SESSION['alert_ico']= $a_ico;
		?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script><?php
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
		?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script><?php
		die();
	}	
	

	// ----------------------------------------------------------------------------------------------
	// 1 - Completar tabla: eventos_ronda_neg_union_cv (match entre C y V de c/producto) ------------
	// ----------------------------------------------------------------------------------------------
	
	if($correr_proc_1 == 'si'){

		$arr_emp_cv_prod = array();
		$arr_emp_cv_prod = $RN->gets_emp_cv_prod($id_rn);

		$arr_prod = array();
		$arr_prod = $RN->gets_productos($id_rn);

		$arr_prod_viables  = array();
		$arr_filas_a_grabar= array();
		
		// Para c/Producto traigo #C y #V
		for($i=0 ; $i<count($arr_prod) ; $i++){
			$knt_c = $RN->get_cant($arr_prod[$i]['id_prod'], 'c', $id_rn);
			$knt_v = $RN->get_cant($arr_prod[$i]['id_prod'], 'v', $id_rn); 
			
			$arr_c= array();
			$arr_v= array();

			if($knt_c >0 && $knt_v >0){
				
				$arr_c = $RN->gets_cv_prod('c', $arr_prod[$i]['id_prod'], $id_rn); // Emp q compran X producto
				$arr_v = $RN->gets_cv_prod('v', $arr_prod[$i]['id_prod'], $id_rn); // Emp q venden  X producto 

				// lleno tabla de "union C-V"
				for($j=0 ; $j<count($arr_c) ; $j++){
					$id_emp_c = $arr_c[$j]['fk_insc'];
					for($k=0 ; $k<count($arr_v) ; $k++){
						$id_emp_v = $arr_v[$k]['fk_insc'];
						
						// si no esta el reg -> lo agrego a la tabla
						$existe= $RN->tf_existe_par_cv($id_emp_c, $id_emp_v, $id_rn);  					
						if(!$existe OR $existe==0)	$add_par = $RN->add_par_cv($id_emp_c, $id_emp_v, $id_rn);					
					}
				}
			}	
		}

		// Ctrl para saber si cortar el proceso x (matching = 0)
		$existe_match = $RN->tf_existe_match($id_rn);
		if(!$existe_match){

			// Libero tablas
			$upd_libTabla_= $RondAg->upd_liberar_tabla($hay);
			$del_libtabla_= $RondAg->del_config($id_rn); 
			$del_union_cv = $RondAg->del_union_cv($id_rn); 

			if($upd_libTabla_ && $del_libtabla_ && $del_union_cv){		$msj_2= '';
			}else{ 		if(!$upd_libTabla_)             				$msj_2= ' (Error al liberar agenda_uso)';
				        if(!$del_libtabla_)             				$msj_2= ' (Error al borrar agenda_config)';
				        if(!$del_union_cv)             			    	$msj_2= ' (Error al borrar union_cv)';
			}

			// Se corta el proceso (c) --> redirecciono
			$a_tit= 'No se puede procesar';	  $a_sub= 'No hay Match entre Empresas Compradoras y Vendedores.'.$msj_2;   $a_ico= 'error';	
			$_SESSION['alert_tit']= $a_tit;	  $_SESSION['alert_sub']= $a_sub;	                                $_SESSION['alert_ico']= $a_ico;
			?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script><?php
			die();
		}
	}
	

	// ----------------------------------------------------------------------------------------------
	// 2 - En aux_agenda_X_d1_aux o d2_aux lleno (1°) fila de compradores ---------------------------
	// ----------------------------------------------------------------------------------------------

	if($correr_proc_2 == 'si'){

		$tabla         = $tab_1;
		$tabla_aux     = $tab_1_aux;
		$cambiar_tabla = 'no';

		// lleno 1ª fila de compradores (tabla ronda_agenda_1)
		$arr_compra= array();
		$arr_compra= $RN->gets_compran($id_rn);
		$cant_c    = count($arr_compra);	
		$ind       = 1;
		for($i=0 ; $i<$cant_c ; $i++){
			$add = $RondAg->add_c($tabla_aux, $ind, $arr_compra[$i]['c']);
			$ind++;
		}	
		$upd = $RondAg->aux_inicializar($tabla);
		$upd = $RondAg->aux_copiar($tabla, $tabla_aux);

		$upd = $RondAg->aux_inicializar($vista2);
		$upd = $RondAg->aux_copiar($tab_2, $tabla_aux);

		$upd = $RondAg->aux_inicializar($tab_2_aux);
		$upd = $RondAg->aux_copiar($tab_2_aux, $tabla_aux);
	}	
	

	// ----------------------------------------------------------------------------------------------
	// 3  -------------------------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------
	
	if($correr_proc_3 == 'si'){

		// traigo en un array las diferentes "Emp V" (tabla union_cv)
		$arr_venden = $RN->gets_venden($id_rn);
		$knt_venden = count($arr_venden);

		// Para cada "Emp V" busco sus tuplas y agrego en AUX1, (si todas entran) copio a Agenda1 (sino) comienzo a trabajar en AUX2 y Agenda2
		for($i=0 ; $i<$knt_venden ; $i++){

			$empV = $arr_venden[$i]['v'];

			// busco todas "Emp C" para esa empresa V
			$arr_empC = $RN->gets_empC_para_empV($id_rn, $empV);
			$knt_empC = count($arr_empC);

			$reg_add  = 0;			
			
			// lleno tabla Agenda con cada dupla de esa "Emp V"
			for($j=0 ; $j<$knt_empC ; $j++){

				$emp_c = $arr_empC[$j]['emp_c'];
				$emp_v = $empV;		
				$col_c = $RondAg->get_col($tabla_aux, $emp_c); // en q col esta la dupla_c?

				// debo agregar la empresa en "col_c" (en 1er fila vacia (!=1) PERO q no este en otra col)
				$arr_filas_a_grabar = $RondAg->gets_fila_a_grabar($tabla_aux, $emp_v);
				$band = 0;
				for($p=0 ; ($p<count($arr_filas_a_grabar)) && ($band==0) ; $p++){
					$fila_aConsultar= $arr_filas_a_grabar[$p]['id'];                            
					$ocupado        = $RondAg->tf_filaOcupada($tabla_aux, $col_c, $fila_aConsultar); 
					if(!$ocupado){                                                               
						$add = $RondAg->add_v($tabla_aux, $col_c, $emp_v, $fila_aConsultar);         
						if($add){	$reg_add++;    $band= 1;  $t_1= 1;}                                                          
					}				
				}	
			}
			
			// controlo si se agregaron todas las duplas
			if($knt_empC == $reg_add){
				$upd = $RondAg->aux_inicializar($tabla);
				$upd = $RondAg->aux_copiar($tabla, $tabla_aux);
			}else{
				// tabla Agenda llena
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
		$nbreVista= 'v_rn_'.$id_rn.'_d1';
		$tablaOrig= 'aux_agenda_'.$hay.'_d1_aux';
		$addV     = $RondAg->add_vista($nbreVista, $tablaOrig);
		// Add referencia
		$updV     = $RondAg->aux_upd_config($id_rn, '1', $nbreVista, $f_proceso, $user);
		// Ctrl
		if($addV && $updV)	$proceso1= true; else $proceso1= false;
	}
	if($t_2 == 1)	{
		// Add vista
		$nbreVista_= 'v_rn_'.$id_rn.'_d2';
		$tablaOrig_= 'aux_agenda_'.$hay.'_d2_aux';
		$addV_     = $RondAg->add_vista($nbreVista_, $tablaOrig_);
		// Add referencia
		$updV_     = $RondAg->aux_upd_config($id_rn, '2', $nbreVista_, $f_proceso, $user);
		// Ctrl
		if($addV_ && $updV_)	$proceso2= true; else $proceso2= false;
	}

	// Libero tablas
	$upd_libTabla_2= $RondAg->upd_liberar_tabla($hay);
	$del_union_cv_2= $RondAg->del_union_cv($id_rn); 
	if($upd_libTabla_2 && $del_union_cv_2){		$proceso3= true;  $msj_3= '';
	}else{ 		if(!$upd_libTabla_2)            $proceso3= false; $msj_3= ' (Error al liberar agenda_uso)';
				if(!$del_union_cv_2)            $proceso3= false; $msj_3= ' (Error al borrar union_cv)';
	}

	// ----------------------------------------------------------------------------------------------
	// 5 - Control final ----------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------

	$op= 'ok';
	if($t_1==1){		          if(!$proceso1)	$op= 'er';	 $msj='Al procesar día 1.';       }
	if($op=='ok' && $t_2==1){	  if(!$proceso2)	$op= 'er';	 $msj='Al procesar día 2.';       }
	if($op=='ok' && !$proceso3){		            $op= 'er';   $msj='Al liberar tabla.'.$msj_3; }

	if($op=='ok'){  $a_tit= 'Proceso completado';	  $a_sub= '';                              $a_ico= 'success';  
	}else{          $a_tit= 'Error';	              $a_sub= $msj.' Intente de nuevo.';       $a_ico= 'error';    
	                $del  = $RondAg->del_config($id_rn); 
	}

	$_SESSION['alert_tit']= $a_tit;	    $_SESSION['alert_sub']= $a_sub;	    $_SESSION['alert_ico']= $a_ico;

	// ----------------------------------------------------------------------------------------------
	// 6 - Redirecciono -----------------------------------------------------------------------------
	// ----------------------------------------------------------------------------------------------

	?> <script type="text/javascript"> window.location="../_ronda_neg_agenda.php"; </script>