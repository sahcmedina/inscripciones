<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
		
	// ------------------------------ FUNCION ------------------------------ //		
    require_once ('./Mobile_Detect/Mobile_Detect.php');
    require_once('./funciones/mod2_materiales.php');             $Mat   = new Materiales();
    require_once('./funciones/mod2_moviles.php');                $Movil = new Moviles();
    require_once('./funciones/mod2_depositos_tecnicos.php');     $DepoT = new Depositos_tecnicos();
    $arr_sino     = array('no','si');
	
    // Dispositivo conectado
    $dispositivo = new Mobile_Detect();
    if ($dispositivo->isMobile()){       $disp_conectado = 'Movil';     $nbre_funcion = 'Solicitar Material';       }
    else{							     $disp_conectado = 'PC';        $nbre_funcion = 'Solicitar ';               }

	// Datos del user logueado
	$idperfil     = $_POST['idperfil'];	
	$arr_funcion  = array();
	$arr_funcion  = $U->gets_funciones_segun_perfil($idperfil, $id_empresa_logueada);
	$nbre_perfil  = $U->get_nbre_perfil($idperfil);    
	$id_user      = $U->get_id( $login);    
    $depo_logueado= $DepoT->get_depoUser($id_user);

    $arr_codigos= array();
	$arr_codigos= $Mat->gets();
    
    $arr_movil= array();
	$arr_movil= $Movil->gets_segunDepo($depo_logueado);

    $arr_destino = array();
    $arr_destino[0]['id']= 'o';   $arr_destino[0]['nombre']= 'Obra';
    $arr_destino[1]['id']= 's';   $arr_destino[1]['nombre']= 'Siniestro';
    $arr_destino[2]['id']= 'm';   $arr_destino[2]['nombre']= 'Mantenimiento';
?>

<!DOCTYPE html><html lang="es">

<head>

    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>       

    <!-- AJAX: lleno select con los materiales que se requieren -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var cod_mat; var destino;   
        $("#destino").change(function(e){
                cod_mat = $("#cod_mat").val();                         
                destino = $("#destino").val();                                   
                depo_log= $("#depo_logueado").val();                                   
                
                $("#llenar_select_origen").delay(50).queue(function(n) {                                                 
                        $.ajax({
                            type: "POST",
                            url: "./funciones/mod2_depositos_tecnicos_ajax_llenarSelOrigen.php",
                            data: "cod_mat="+cod_mat+"&destino="+destino+"&depo_log="+depo_log,     dataType: "html",
                            error: function(){ alert("error petición ajax");   },
                            success: function(data){  $("#llenar_select_origen").html(data);    n();}
                    });                                           
                });                                
        });                              
    });
    </script>

    <!-- Validacion de datos por AJAX para AGREGAR  -->                  
    <script language="javascript">
    $(document).ready(function(){                         
        var cod_mat;     var usuario;   var depo_logueado;   var origen;          
        var movil;       var cant;      var destino;         
        $("#validar_add").click(function(){
            cod_mat= $("#cod_mat").val();       usuario = $("#usuario").val();   depo_logueado = $("#depo_logueado").val();
            movil  = $("#movil").val();         cant= $("#cant").val();          destino= $("#destino").val();  
            origen = $("#origen").val();  
            
            $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod2_sol_material_ajax_validar_add.php",
                    data: "cod_mat="+cod_mat+"&usuario="+usuario+"&depo_logueado="+depo_logueado+"&movil="+movil+"&cant="+cant+"&destino="+destino+"&origen="+origen,
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");                    },
                    success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();	 } 
                });                                           
            });                                
        });              
    });
    </script>

    <!-- MSJ: Espere unos segundos -->
    <script type="text/javascript">
        function mostrarMsjBtn_upd(){ document.getElementById('msjBtn_upd').style.display = 'block'; }
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
			case 'sadmin': 			require('./estructura/barraNotificaciones_SuperAdmin.php');	 				break;
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
                            <a href="./principal.php" class="nav-link"> San Juan SAAS </a>
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
                        
                                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"> Solicitud de Material </li>
                                                <li class="breadcrumb-item active" aria-current="page"> <?php echo $nbre_funcion ?> </li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO ------------------------------------------------------------------------------------------------------------------------>
                    <!-- CONTENIDO ------------------------------------------------------------------------------------------------------------------------>
                    <!-- CONTENIDO ------------------------------------------------------------------------------------------------------------------------>
                    
                    <!-- DATATABLE -->
                    <div class="row layout-top-spacing">                    
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                        
                            <!-- <div class="modal-dialog modal-xl"> -->
                            <div class="modal-content">

                                <form name="add_dep" id="add_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                    <div class="modal-body with-padding">
                                        <div class="form-group-sm">                                    

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Código Material<span class="mandatory"> *</span></label>   
                                                    <select id="cod_mat" name="cod_mat" class="form-select cod_mat form-control-sm" tabindex="1" ><?php
                                                        echo '<option value="0" >Elija..</option>\n';
                                                        for ($i = 0; $i < count($arr_codigos); $i++)
                                                            echo '<option value="'.$arr_codigos[$i]['id'].'"'.'>' .$arr_codigos[$i]['codigo'].' - '.$arr_codigos[$i]['nombre']. "</option>\n";
                                                        ?>	
                                                    </select>                                                     
                                                    <input type="hidden" id="usuario"       name="usuario"       value="<?php echo $id_user ?>" >
                                                    <input type="hidden" id="depo_logueado" name="depo_logueado" value="<?php echo $depo_logueado ?>" >                                                    
                                                </div>  
                                            
                                            <?php if($disp_conectado== 'Movil'){ ?> 
                                                </div><br/> 
                                                <div class="row">
                                            <?php } ?>

                                                <div class="col-md-2">
                                                    <label>Móvil<span class="mandatory"> *</span></label>   
                                                    <select id="movil" name="movil" class="form-select prov form-control-sm" tabindex="2" ><?php
                                                        for ($i = 0; $i < count($arr_movil); $i++)
                                                            echo '<option value="'.$arr_movil[$i]['id'].'"'.'>' .$arr_movil[$i]['codigo']. "</option>\n";
                                                        ?>	
                                                    </select> 
                                                </div>                                                
                                            
                                            <?php if($disp_conectado== 'Movil'){ ?> 
                                                </div><br/> 
                                                <div class="row">
                                            <?php } ?>

                                                <div class="col-md-2">
                                                    <label># cantidad<span class="mandatory"> *</span></label>   
                                                    <input type="text" id="cant" name="cant" class="form-control form-control-sm" tabindex="3" required>
                                                </div>  
                                            
                                            </div><br/>  
                                            <div class="row">
                                                
                                                <div class="col-md-2">
                                                    <label>Destino<span class="mandatory"> *</span></label>   
                                                    <select id="destino" name="destino" class="form-select destino form-control-sm" tabindex="4" ><?php
                                                        echo '<option value="0" >Elija..</option>\n';
                                                        for ($i = 0; $i < count($arr_destino); $i++)
                                                            echo '<option value="'.$arr_destino[$i]['id'].'"'.'>' .$arr_destino[$i]['nombre']. "</option>\n";
                                                        ?>	
                                                    </select> 
                                                </div> 

                                            <?php if($disp_conectado== 'Movil'){ ?> 
                                                </div><br/> 
                                                <div class="row">
                                            <?php } ?>

                                                <div class="col-md-4" >                          
                                                    <div id="llenar_select_origen"></div>
                                                </div>

                                            </div> 

                                        </div>
                                    </div>	


                                    <div class="modal-footer d-flex justify-content-center"><center>					
                                        <br />
                                        <button type="button" onclick="history.back()" class="btn btn-dark" data-bs-dismiss="modal" tabindex="6">Volver</button>		                                    
                                        <button type="button" id="validar_add" name="validar_add" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="7" > Agregar </button>
                                        <br />
                                        <div id="mostrar_validar_add" ></div>
                                        &nbsp; 
                                    </div></center>

                                </form>

                            </div>
                            <!-- </div> -->
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
            "lengthMenu": [10, 20, 50],
            "pageLength": 5 
        });
    </script>

    <!-- SELECT CON BUSQUEDA -->
    <script type="text/javascript">
        new TomSelect("#cod_mat",{      create: false, sortField: { field: "text", direction: "asc" }});
    </script>


</body>
</html>

