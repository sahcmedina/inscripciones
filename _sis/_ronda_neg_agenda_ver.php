<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('10',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];

    if(count($datos_f)== 0){ 
        $a_ico= 'error';                   $a_tit= 'No tiene permisos a la función.';	   $a_sub= '';					
        $_SESSION['alert_ico']= $a_ico;    $_SESSION['alert_tit']= $a_tit;	               $_SESSION['alert_sub']= $a_sub;	 
        ?><script type="text/javascript"> window.location="../_sis/principal.php"; </script><?php 
        die();
    }
	
	// ------------------------------ FUNCION ------------------------------ //			
	include_once('./funciones/mod3_productos.php');     $Productos = new Productos(); 
	include_once('./funciones/mod3_ronda_neg.php');     $RondaNeg  = new RondaNegocios();
    include_once('./funciones/mod3_rn_agenda.php');	    $RondAg    = new RN_Agenda();

    $id       = $_SESSION['var_id'];
    $id_user  = $U->get_id( $login);

    // datos de la RN
    $arr_rn   = array();
	$arr_rn   = $RondaNeg->gets_id($id);

    // datos de la Agenda
    $arr_ag   = array();
	$arr_ag   = $RondAg->gets_config($id);

    // Dia 1
    if($arr_ag[0]['dia1']==1){  
        $hay_dia1= true;  
        $arr_info= array();
        $v_1     = $arr_ag[0]['view1']; 
        $dia1    = $arr_rn[0]['d1']; 

        $arr_emp_d1 = array();
		$arr_emp_d1 = $RondAg->aux_gets_empC($v_1);		

    }else{  
        $hay_dia1= false; }

    // Dia 2
    if($arr_ag[0]['dia2']==1){  
        $hay_dia2 = true;  
        $arr_info2= array();
        $v_2      = $arr_ag[0]['view2'];         
        $dia2     = $arr_rn[0]['d2'];  

        $arr_emp_d2 = array();
		$arr_emp_d2 = $RondAg->aux_gets_empC($v_2);	

    }else{  
        $hay_dia2= false; }

    // Hs de reuniones
    if($hay_dia1 OR $hay_dia2){
    
        // Parámetros ($horaInicio     = '09:00';  $duracionReunion= 35; $cantReuniones  = 15; )
        $arr_param    = array();
        $arr_param    = $RondaNeg->gets_param();
        list($hh, $mm, $ss)= explode(':', $arr_param[0]['primer_reunion']);
        $horaInicio   = $hh.':'.$mm;
        $duracionReunion = $arr_param[0]['duracion'];
        $cantReuniones= $arr_param[0]['x_dia'];
        $arr_hs         = array();
        $ind_hs         = 0;

        // Convertimos la hora inicial a un objeto DateTime para facilitar los cálculos
        $fechaActual    = new DateTime();
        $horaInicioArray= explode(':', $horaInicio);
        $fechaActual->setTime($horaInicioArray[0], $horaInicioArray[1], 0);

        // Calculamos el horario para cada reunión
        for ($i = 1; $i <= $cantReuniones; $i++) {
            // Almacenamos la hora de inicio para esta reunión
            $inicioReunion = clone $fechaActual;
            
            // Calculamos la hora de fin añadiendo la duración
            $fechaActual->add(new DateInterval('PT' . $duracionReunion . 'M'));
            
            // Guardo
            array_push($arr_hs, $inicioReunion->format('H:i'));
        }
    }


    //////////////////////////////////////
    
    // $arr_durac= array('15', '20','25','30');
	// $arr_p    = array(); 
	// $arr_p    = $Productos->gets();     

    // $arr_param    = array();
	// $arr_param    = $RondaNeg->gets_param();
    // list($hh, $mm, $ss)= explode(':', $arr_param[0]['primer_reunion']);
    // $par_prim_reun= $hh.':'.$mm;
    // $par_duracion = $arr_param[0]['duracion'];
    // $par_x_dia    = $arr_param[0]['x_dia'];
?>

<!DOCTYPE html><html lang="es">

<head>

    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>     
    
    <!-- Muestra borde de componentes del Form -->
    <style>
        input:focus, select:focus, textarea:focus {
            border: 2px solid #007bff !important;                   /* Borde azul más grueso */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;  /* Sombra suave */
            transition: all 0.3s ease;                                /* Animación suave */
        }
    </style>

    <!-- PASAR DATOS AL MODAL: Borrar  -->
    <script>
    $(document).ready(function(){  
        $('#modal_del').on('show.bs.modal', function (event) {    
            var button   = $(event.relatedTarget)  // Botón que activó el modal
            var id       = button.data('id')   
            var nombre   = button.data('nombre')   
            var modal    = $(this)
            modal.find('.modal-body #id_del').val(id)
            modal.find('.modal-body #nombre_del').val(nombre)
            
            $('.alert').hide();//Oculto alert
            })
        });
    </script>

    <!-- PASAR DATOS AL MODAL: Procesar Agenda  -->
    <script>
    $(document).ready(function(){  
        $('#modal_procesar').on('show.bs.modal', function (event) {    
            var button   = $(event.relatedTarget)  // Botón que activó el modal
            var id       = button.data('id')   
            var nombre   = button.data('nombre')   
            var modal    = $(this)
            modal.find('.modal-body #id_proc').val(id)
            modal.find('.modal-body #nombre_proc').val(nombre)
            
            $('.alert').hide();//Oculto alert
            })
        });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var codi; var prov;  var dir;  var tel; var usu;          
        $("#validar_upd").click(function(){
            usu     = $("#usuario").val();			
            hs      = $("#hs_").val();			  
            duracion= $("#duracion_").val();			
            x_dia   = $("#x_dia_").val();			

            $("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_rn_agenda_param_ajax_validar_upd.php",                                                                                                                                                                                                    
                    data: "usuario="+usu+"&hs="+hs+"&duracion="+duracion+"&x_dia="+x_dia,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_upd").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Borrar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id;          
        $("#validar_del").click(function(){
            id = $("#id_del").val();			

            $("#mostrar_validar_del").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_productos_ajax_validar_del.php",                                                                                                                                                                                                    
                    data: "id="+id,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_del").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Agregar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var nom; var usu;          
        $("#validar_add").click(function(){	
            usu  = $("#usuario").val();				
            nom  = $("#nom_").val();				

            $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_productos_ajax_validar_add.php",                                                                                                                                                                                                    
                    data: "usu="+usu+"&nom="+nom,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Procesar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id;          
        $("#validar_proc").click(function(){
            usu= $("#usuario").val();		
            id = $("#id_proc").val();			

            $("#mostrar_validar_proc").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_rn_agenda_ajax_validar_proc.php",                                                                                                                                                                                                    
                    data: "id="+id+"&usu="+usu,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		    },
                    success: function(data){ 	$("#mostrar_validar_proc").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- MSJ: Espere unos segundos, al hacer clic -->
    <script type="text/javascript">
        function mostrarMsjBtn_del(){ document.getElementById('msjBtn_del').style.display = 'block'; }
    </script>

</head>

<body class="alt-menu layout-boxed">

    <!-- NOTIFICACIONES - SWEET ALERT -->
    <?php 
    if (isset($_SESSION['alert_tit']))      { $alert_tit= $_SESSION['alert_tit'];      } else { $alert_tit= ''; }
    if (isset($_SESSION['alert_sub']))      { $alert_sub= $_SESSION['alert_sub'];      } else { $alert_sub= ''; }
    if (isset($_SESSION['alert_ico']))      { $alert_ico= $_SESSION['alert_ico'];      } else { $alert_ico= ''; }
    
    if($alert_tit!= ''){
        ?><script type="text/javascript">
        swal.fire({ title: "<?php echo $alert_tit; ?>",  text:  "<?php echo $alert_sub; ?>",    icon:  "<?php echo $alert_ico; ?>"   });
        </script><?php
        $_SESSION['alert_tit']= '';     $_SESSION['alert_sub']= '';      $_SESSION['alert_ico']= '';
    }    
	?>

    <!--  BEGIN LOADER && NAVBAR  -->

    <!-- Barra Horizontal: Logo / Notificaciones, Eventos, Mensajes & Usuario logueado -->
	<?php 
		switch($tipo_user){			  	
			case 'admin': 			require('./estructura/barraNotificaciones_Administradores.php'); 			break;
		} 
	?>

    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row text-center">
                    <div class="nav-logo">
                        <li class="nav-item theme-logo">
                            <a href="./principal.php">
                                <img src="./images/logos/icono.png" alt="logo">
                            </a>
                        </li>
                        <div class="nav-item theme-text">
                            <a href="./principal.php" class="nav-link"> Sistema de Inscripciones </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                
                <div class="shadow-bottom"></div>

                <!-- MENU -->
                <ul class="list-unstyled menu-categories" id="accordionExample"><?php echo $_SESSION['sesion_Menu'];  ?></ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <!--  BARRA - MAPA DE SITIO  -->
                    <div class="secondary-nav">
                        <div class="breadcrumbs-container" data-page-heading="Analytics">
                            <header class="header navbar navbar-expand-sm">

                                <!-- OCULTAR MENU -->
                                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                        <line x1="3" y1="12" x2="21" y2="12"></line>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <line x1="3" y1="18" x2="21" y2="18"></line>
                                    </svg>
                                </a>

                                <!-- MAPA DE SITIO -->
                                <div class="d-flex breadcrumb-content">
                                    <div class="page-header">

                                        <div class="page-title"></div>  
                        
                                        <nav class="breadcrumb-style-five" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="principal.php" title="Dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="inner-text"></span></a></li>
                                                <li class="breadcrumb-item"> Negocios </li>
                                                <li class="breadcrumb-item"><a href="_ronda_neg_agenda.php" title="ir">Agenda</a></li>
                                                <li class="breadcrumb-item active" aria-current="page"> <?php echo $arr_rn[0]['nombre'] ?> </li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO -->

                    <!-- Modal: Info -->
                    <div id="modal_info" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Información </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <label> La función permite administrar las Agendas de las Rondas de Negocios. </label>
                                            <br/><br/>
                                            <label><b>* Mdf Parametros:</b> Cambia los permisos para el perfil de un usuario elegido. </label>
                                            <label><b>* Mdf Clave:</b> Cambia la contraseña para el usuario elegido. </label>
                                            <label><b>* Mdf Perfil:</b> Cambia el perfil para el usuario elegido. </label>
                                            <label><b>* Borrar:</b> Borra un usuario del sistema. </label>
                                        </div><br>							
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="1">Cerrar</button>		                                                                        
                                </div></center> 
                                    
                            </form>

                            </div>
                        </div>
                    </div>

                    <!-- TABS -->
                    <br />
                    <div class="simple-pill">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <?php if($hay_dia1){ ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active position-relative mb-2 me-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-d1" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                        <span class="btn-text-inner"> <b>Día 1:</b> <?php echo $dia1; ?></span>
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a href="./informes/agenda1.php"  target="_blank" title="Generar PDF - día 1"
                                        class="nav-link active position-relative mb-2 me-4 text-decoration-none" 
                                        id="pills-home-tab" role="tab">
                                        <span class="btn-text-inner"> PDF </span>
                                    </a>
                                </li>  
                            <?php }	?>                                                      

                            <?php if($hay_dia2){	?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link position-relative mb-2 me-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-d2" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                        <span class="btn-text-inner"> <b>Día 2</b> <?php echo $dia2; ?></span>
                                    </button>
                                </li>   

                                <li class="nav-item" role="presentation">
                                    <a href="./informes/agenda2.php" target="_blank" title="Generar PDF - día 2"
                                        class="nav-link active position-relative mb-2 me-4 text-decoration-none" 
                                        id="pills-home-tab" role="tab">
                                        <span class="btn-text-inner"> PDF </span>
                                    </a>
                                </li>                               
                            <?php }	?>                        
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <!-- Tab Dia 1 -->
                            <?php if($hay_dia1){	?>
                                <div class="tab-pane fade show active" id="pills-d1" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                                                
                                    <!-- DT Dia 1 -->
                                    <?php if($hay_dia1){	?>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                            <div class="statbox widget box box-shadow">                                            
                                                <div class="widget-content widget-content-area">
                                                    <table id="dt_1" class="table table-striped table-bordered" class="datatable">
                                    
                                                    <?php 

                                                    // Columnas
                                                    $tabla= "<thead><tr class=\"rowHeaders\">			
                                                                <th style='text-align:center'> Hora   	</th>";
                                                    $arr_info[0][0]= 'Hora';
                                                    $ind_info      = 1;

                                                    for($p=0 ; $p<count($arr_emp_d1) ; $p++){
                                                        $nom_emp_c = $RondaNeg->get_nbreEmpresa($arr_emp_d1[$p]);
                                                        $tabla.= "<th style='text-align:center'> ".$nom_emp_c." </th>";
                                                        $arr_info[0][$ind_info]= $nom_emp_c;
                                                        $ind_info++;
                                                    }
                                                    $knt_col_t1           = count($arr_emp_d1);
                                                    $_SESSION['knt_emp_c']= $knt_col_t1;      
                                                    
                                                    $tabla.="</tr></thead><tbody>";			
                                                    echo $tabla;

                                                    $ind_info_f = 1;
                                                    $ind_info_c = 0;

                                                    // Filas
                                                    $fila= "<tr class=\"cellColor" . ($pp%2) . "\" align=\"center\" id=\"tr$pp\">\n";
                                                    $arr_fila = array();
                                                    for($pp= 2; $pp <= 16 ; $pp++){
                                                        $arr_fila = $RondAg->gets_fila($v_1, $pp);
                                                        $ccant    = 0;

                                                        // hs
                                                        $f= '<td style="text-align:center">'. $arr_hs[$ind_hs]."</td>\n";
                                                        $ind_hs++;

                                                        $ind_info_c= 0;
                                                        $arr_info[$ind_info_f][$ind_info_c]= $arr_hs[$ind_hs];
                                                        $ind_info_c ++;

                                                        for($m=0 ; $m<count($arr_fila) ; $m++){ 
                                                            if(1<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c1'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(2<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c2'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(3<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c3'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(4<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c4'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(5<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c5'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(6<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c6'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(7<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c7'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(8<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c8'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(9<= $knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c9'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(10<=$knt_col_t1){ 
                                                                $emp_a_most = $arr_fila[$m]['c10']; 
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                        }
                                                        $ind_info_f++;
                                                        
                                                        // Permite dibujar solamente las filas con datos
                                                        if($ccant > 0){ echo $f; }
                                                        echo "</tr>\n";
                                                    }
                                                    echo "</tr>\n";
                                                    
                                                    echo "</tbody>";?>
                                                </table>

                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- Fin - DT Dia 1 -->

                                </div>
                            <?php }	?>

                            <!-- Tab Dia 2 -->
                            <?php if($hay_dia2){	?>
                                <div class="tab-pane fade show active" id="pills-d2" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                                                
                                    <!-- DT Dia 2 -->
                                    <?php if($hay_dia2){	?>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                            <div class="statbox widget box box-shadow">
                                                <div class="widget-content widget-content-area">
                                                    <table id="dt_2" class="table table-striped table-bordered" class="datatable">
                                    
                                                    <?php 

                                                    // Columnas
                                                    $tabla= "<thead><tr class=\"rowHeaders\">			
                                                                <th style='text-align:center'> Hora   	</th>";
                                                    $arr_info[0][0]= 'Hora';
                                                    $ind_info      = 1;

                                                    for($p=0 ; $p<count($arr_emp_d2) ; $p++){
                                                        $nom_emp_c2 = $RondaNeg->get_nbreEmpresa($arr_emp_d2[$p]);
                                                        $tabla.= "<th style='text-align:center'> ".$nom_emp_c2." </th>";
                                                        $arr_info[0][$ind_info]= $nom_emp_c2;
                                                        $ind_info++;
                                                    }
                                                    $knt_col_t2            = count($arr_emp_d2);
                                                    $_SESSION['knt_emp_c2']= $knt_col_t2;      
                                                    
                                                    $tabla.="</tr></thead><tbody>";			
                                                    echo $tabla;

                                                    $ind_info_f = 1;
                                                    $ind_info_c = 0;

                                                    // Filas
                                                    $fila= "<tr class=\"cellColor" . ($pp%2) . "\" align=\"center\" id=\"tr$pp\">\n";
                                                    $arr_fila = array();
                                                    for($pp= 2; $pp <= 16 ; $pp++){
                                                        $arr_fila = $RondAg->gets_fila($v_2, $pp);
                                                        $ccant    = 0;

                                                        // hs
                                                        $f= '<td style="text-align:center">'. $arr_hs[$ind_hs]."</td>\n";
                                                        $ind_hs++;

                                                        $ind_info_c= 0;
                                                        $arr_info[$ind_info_f][$ind_info_c]= $arr_hs[$ind_hs];
                                                        $ind_info_c ++;

                                                        for($m=0 ; $m<count($arr_fila) ; $m++){ 
                                                            if(1<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c1'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(2<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c2'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(3<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c3'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(4<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c4'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(5<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c5'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(6<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c6'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(7<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c7'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(8<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c8'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(9<= $knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c9'];  
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                            if(10<=$knt_col_t2){ 
                                                                $emp_a_most = $arr_fila[$m]['c10']; 
                                                                if($emp_a_most != 0){ $most = $RondaNeg->get_nbreEmpresa($emp_a_most);	$ccant++;}else{ $most=''; }
                                                                $f.= '<td style="text-align:center">'. $most."</td>\n";

                                                                $arr_info[$ind_info_f][$ind_info_c]= $most;	$ind_info_c++;
                                                            }
                                                        }
                                                        $ind_info_f++;
                                                        
                                                        // Permite dibujar solamente las filas con datos
                                                        if($ccant > 0){ echo $f; }
                                                        echo "</tr>\n";
                                                    }
                                                    echo "</tr>\n";
                                                    
                                                    echo "</tbody>";?>
                                                </table>

                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- Fin - DT Dia 2 -->

                                </div>
                            <?php }	?>

                        </div>

                    </div>
                    <!-- FIN TABS -->

                </div>

            </div>

            <!--  FOOTER  ----------------------------------------------------------------------------------->
            <div class="footer-wrapper"><div class="footer clearfix"><div class="pull-left"> &copy; <?php echo $footer ?> </div></div></div>
            
            
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->


    <!-- SCRIPT ----------------------------------------------------------------------------------->
    <!-- SCRIPT ----------------------------------------------------------------------------------->
    <!-- SCRIPT ----------------------------------------------------------------------------------->

    <?php 
	    require_once('./estructura/librerias_utilizadas_body.php');
	?>  

    <!-- CONFIG DATATABLE -->
    <script>
        $('#dt_1').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });

        $('#dt_2').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });
    </script>

    <!-- Pone foco en el primer componente del Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalAdd = document.getElementById('modal_add');
            modalAdd.addEventListener('shown.bs.modal', function () {   document.getElementById('nom_').focus();          });

            var modalUpd = document.getElementById('modal_upd');
            modalUpd.addEventListener('shown.bs.modal', function () {   document.getElementById('hs_').focus();            });
        });
    </script>    

    <?php 
	    require_once('./estructura/buscador_barra.php');
	?> 

    <?php
        $_SESSION['arr_info']   = $arr_info;      
        $_SESSION['arr_info2']  = $arr_info2;      
        $_SESSION['hay_tabla_1']= $hay_dia1;      
        $_SESSION['hay_tabla_2']= $hay_dia2;      
        $_SESSION['f_dia_1_']   = $dia1;      
        $_SESSION['f_dia_2_']   = $dia2;      
    ?>

</body>
</html>