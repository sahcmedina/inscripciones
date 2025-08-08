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
	include_once('./funciones/mod3_productos.php');               $Productos = new Productos(); 
	include_once('./funciones/mod3_ronda_neg.php');               $RondaNeg  = new RondaNegocios();
    include_once('./funciones/mod3_rn_agenda.php');	              $RondAg    = new RN_Agenda();

    $arr_durac= array('15', '20','25','30');
	$arr_p    = array(); 
	$arr_p    = $Productos->gets(); 

	$id_user  = $U->get_id( $login);

    $arr_     = array();
	$arr_     = $RondaNeg->gets();

    $arr_param    = array();
	$arr_param    = $RondaNeg->gets_param();
    list($hh, $mm, $ss)= explode(':', $arr_param[0]['primer_reunion']);
    $par_prim_reun= $hh.':'.$mm;
    $par_duracion = $arr_param[0]['duracion'];
    $par_x_dia    = $arr_param[0]['x_dia'];
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

    <!-- PASAR DATOS AL MODAL: Ver Agenda  -->
    <script>
    $(document).ready(function(){  
        $('#modal_ver').on('show.bs.modal', function (event) {    
            var button   = $(event.relatedTarget)  // Botón que activó el modal
            var id       = button.data('id')   
            var nombre   = button.data('nombre')   
            var modal    = $(this)
            modal.find('.modal-body #id_ver').val(id)
            modal.find('.modal-body #nombre_ver').val(nombre)
            
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

    <!-- AJAX: Validar datos por ajax - Antes de Borrar Proceso -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id;          
        $("#validar_del").click(function(){
            id = $("#id_del").val();			

            $("#mostrar_validar_del").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_ronda_neg_ajax_validar_del_procAg.php",                                                                                                                                                                                                    
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

    <!-- AJAX: Validar datos por ajax - Antes de Ver -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id;          
        $("#validar_ver").click(function(){
            usu= $("#usuario").val();		
            id = $("#id_ver").val();			

            $("#mostrar_validar_ver").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_rn_agenda_ajax_validar_ver.php",                                                                                                                                                                                                    
                    data: "id="+id+"&usu="+usu,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");                   },
                    success: function(data){ 	$("#mostrar_validar_ver").html(data);  	n();    }
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
                                                <li class="breadcrumb-item active" aria-current="page"> Agenda </li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO -->

                    <!-- FUNCIONES EXTRAS -->
                    <br/>
                    <div class="row layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                            <div class="widget-content widget-content-area br-8">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div>
                                        <h6 class="mb-3">Parametros</h6>
                                        <div>
                                            <strong>1° reunión: <?php echo '<b>'.$par_prim_reun.' hs</b>'; ?></strong> &nbsp; &nbsp; &nbsp; 
                                            <?php echo '/'; ?>&nbsp; &nbsp; &nbsp; 
                                            <strong>Duración: <?php echo '<b>'.$par_duracion.' min.</b>'; ?></strong> &nbsp; &nbsp; &nbsp; 
                                            <?php echo '/'; ?>&nbsp; &nbsp; &nbsp; 
                                            <strong>Reuniones x día: <?php echo '<b>'.$par_x_dia.'</b>'; ?></strong> &nbsp; &nbsp; &nbsp; 
                                        </div>
                                    </div>
                                    <div>
                                        <?php if($modf == '1') { ?>
                                            <button data-bs-toggle="modal" data-bs-target="#modal_upd" class="btn btn-outline-success btn-icon mb-2 me-2 btn-sm" title="Modificar parametros"><i class="bi bi-pencil" style="font-size: 1rem;"></i></button>
                                        <?php } ?>
                                        <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 btn-sm" title="Más info.."><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <!-- Modal: Ver -->
                    <div id="modal_ver" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-content" >
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Ver Agenda </h6></div>

                            <form name="form_ver" id="form_ver" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre_ver" name="nombre_ver" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id_ver"     name="id_ver"     >	 
                                                <input type="hidden"  id="usuario"    name="usuario" value="<?php echo $id_user ?>" >
                                            </div>	
                                            <div class="col-md-2"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="2">Cancelar</button>		                                    
                                    <button id="validar_ver" name="validar_ver" type="button" class="btn btn-success" title="Haga click para ver agenda" tabindex="3"> Ver </button>
                                    <br /><br />
                                    <div id="mostrar_validar_ver" ></div> 
                                </div></center> 
                                    
                            </form>

                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal: Procesar -->
                    <div id="modal_procesar" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-content" >
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Procesar Agenda </h6></div>

                            <form name="form_procesar" id="form_procesar" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label style="color:red;font: size 30px;"><i class="icon-warning"></i> ¿ Está seguro ? </label></center>
                                        </div><br>
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre_proc" name="nombre_proc" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id_proc"     name="id_proc"     >	 
                                                <input type="hidden"  id="usuario"     name="usuario" value="<?php echo $id_user ?>" >
                                            </div>	
                                            <div class="col-md-2"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="2">Cancelar</button>		                                    
                                    <button id="validar_proc" name="validar_proc" type="button" class="btn btn-success" title="Se va a validar si se puede procesar." tabindex="3"> Correr proceso </button>
                                    <br /><br />
                                    <div id="mostrar_validar_proc" ></div> 
                                </div></center> 
                                    
                            </form>

                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal: Borrar -->
                    <div id="modal_del" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-content" >
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Borrar Proceso </h6></div>

                            <form name="form_del_reg" id="form_del_reg" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label style="color:red;font: size 30px;"><i class="icon-warning"></i> ¿ Está seguro ? </label></center>
                                        </div><br>
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre_del" name="nombre_del" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id_del"     name="id_del"     >	 
                                            </div>	
                                            <div class="col-md-2"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="2">Cancelar</button>		                                    
                                    <button id="validar_del" name="validar_del" type="button" class="btn btn-danger" title="Se va a validar si se puede borrar." tabindex="3"> Finalizar </button>
                                    <br /><br />
                                    <div id="mostrar_validar_del" ></div> 
                                </div></center> 
                                    
                            </form>

                            </div>
                        </div>
                    </div>

                    <!-- Modal: Agregar -->
                    <div id="modal_add" class="modal animated fadeInDown" tabindex="-1" role="dialog" >
                    <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Agregar Producto </h6></div>

                            <form name="add_reg" id="add_reg" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">                                    
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-5">
                                                <label>Nombre<span class="mandatory">*</span></label>   
                                                <input type="text" id="nom_" name="nom_" class="form-control form-control-sm" tabindex="2" required>
                                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $id_user ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="4">Cancelar</button>		                                    
                                    <button id="validar_add" name="validar_add" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="5" > Agregar </button>
                                    <br /><br />
                                    <div id="mostrar_validar_add" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar -->
                    <div id="modal_upd" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar Parametros </h6></div>

                            <form name="mdf_reg" id="mdf_reg" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">
                                    <div class="row">
                                        <div class="col-md-1">
                                        </div>  
                                        <div class="col-md-3">
                                            <label >1° reunión (hora) <span class="mandatory">*</span></label>
                                            <input type="time"   id="hs_"        name="hs_"     class="form-control form-control-sm" tabindex="1" value="<?php echo $par_prim_reun ?>" required>  
                                            <input type="hidden" id="usuario"    name="usuario" value="<?php echo $id_user ?>" >                                          
                                        </div>  
                                        <div class="col-md-3">
                                            <label >Duración (min)<span class="mandatory">*</span></label>
                                            <select id="duracion_" name="duracion_" class="form-select duracion form-control-sm" tabindex="2"><?php
                                                // for ($i = 0; $i < count($arr_durac); $i++)
                                                //     echo '<option value="'.$arr_durac[$i].'"'.'>'.utf8_encode($arr_durac[$i])."</option>\n";
                                                if (isset($arr_durac) && is_array($arr_durac)) {
                                                    for ($i = 0; $i < count($arr_durac); $i++) {
                                                        $selected = (isset($par_duracion) && $par_duracion == $arr_durac[$i]) ? 'selected' : '';
                                                        echo '<option value="'.$arr_durac[$i].'" '.$selected.'>'.htmlspecialchars($arr_durac[$i])."</option>\n";
                                                    }
                                                } ?>
                                            </select>              
                                        </div>  
                                        <div class="col-md-3">
                                            <label >Reuniones x día (1 a 15)<span class="mandatory">*</span></label>
                                            <input type="number" min="1" max="15" id="x_dia_" name="x_dia_" value="<?php echo $par_x_dia ?>" class="form-control form-control-sm" tabindex="3" required>              
                                        </div>                                        
                                    </div>
                                    </div>
                                </div> 

                                <div class="modal-footer"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="4">Cancelar</button>		                                    
                                    <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="5"> Modificar </button>
                                    <br/><br/>
                                    <div id="mostrar_validar_upd" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- DATATABLE -->
                    <div class="row layout-top-spacing">                    
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        
                            <div class="widget-content widget-content-area br-8">
                                <table id="dt_" class="table dt-table-hover" style="width:100%">
                                    
                                    <?php
                                        $tabla= "<thead><tr class=\"rowHeaders\">			
                                                <th style='text-align:center'> Nombre		    </th>
                                                <th style='text-align:center'> Fecha 1		    </th>
                                                <th style='text-align:center'> Fecha 2		    </th>
                                                <th style='text-align:center'> Inscripciones	</th>
                                                <th style='text-align:center'> Borrar		    </th>
                                                <th style='text-align:center'> Procesar		    </th>
                                                <th style='text-align:center'> Ver   		    </th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_) && $j<count($arr_) ; $j++){
                                            $cur     = $arr_[$j];
                                        
                                            $btn_del = '<button data-bs-toggle="modal" data-bs-target="#modal_del" 
                                                            data-id="'.$cur['id'].'" data-nombre="'.$cur['nombre'].'"
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Borrar proceso" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                        </button>';
                                                    
                                            $btn_pro = '<button data-bs-toggle="modal" data-bs-target="#modal_procesar" 
                                                            data-id="'.$cur['id'].'" data-nombre="'.$cur['nombre'].'"
                                                            class="btn btn-outline-success btn-icon mb-2 me-4" title="Correr proceso" >
                                                            <i class="bi bi-magic" style="font-size: 1rem;"></i>
                                                        </button>';
                                                    
                                            $btn_ver = '<button data-bs-toggle="modal" data-bs-target="#modal_ver" 
                                                            data-id="'.$cur['id'].'" data-nombre="'.$cur['nombre'].'"
                                                            class="btn btn-outline-info btn-icon mb-2 me-4" title="Ver agenda" >
                                                            <i class="bi bi-search" style="font-size: 1rem;"></i>
                                                        </button>';

                                            if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                            if($modf == '1') { 
                                                $existe_proceso = $RondAg->tf_existe_config($cur['id']); 
                                                if(!$existe_proceso){   
                                                    $btn_procesar   = $btn_pro;                                
                                                    $btn_ver_mostrar= '';
                                                    $btn_ver_borrar = '';
                                                }else{                   
                                                    $btn_procesar   = $RondAg->get_fecha_config($cur['id']);   
                                                    $btn_ver_mostrar= $btn_ver;                                                    
                                                    $btn_ver_borrar = $btn_del_mostrar;
                                                }                                                                                                
                                            } else {  $btn_procesar= '';    }

                                            $dsd_f  = new DateTime($cur['f_inscrip_dsd']);
                                            $dsd_f_ = $dsd_f->format('d/m/y');

                                            $hst_f  = new DateTime($cur['f_inscrip_hst']);
                                            $hst_f_ = $hst_f->format('d/m');

                                            $inscrip= $dsd_f_.' al '.$hst_f_;

                                            if($cur['f_dia_2']== '1900-01-01')  $f_dia_2= '-'; else $f_dia_2= $cur['f_dia_2'];

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['nombre']  	. "</td>\n"
                                            . '<td style="text-align:center">'. $cur['f_dia_1']  	. "</td>\n"
                                            . '<td style="text-align:center">'. $f_dia_2  	        . "</td>\n"
                                            . '<td style="text-align:center">'. $inscrip         	. "</td>\n"
                                            . '<td style="text-align:center">'. $btn_ver_borrar     . "</td>\n"
                                            . '<td style="text-align:center">'. $btn_procesar       . "</td>\n"
                                            . '<td style="text-align:center">'. $btn_ver_mostrar    . "</td>\n"
                                            . "</tr>\n";
                                        }
                                        echo "</tbody>";
                                    ?>   
                                </table>
                            </div>
                        </div>
    
                    </div>

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
        $('#dt_').DataTable({
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

</body>
</html>