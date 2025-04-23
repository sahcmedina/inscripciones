<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('2',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
	
	// ------------------------------ FUNCION ------------------------------ //			
	include('./funciones/mod2_depositos_tecnicos.php');     $Tec  = new Depositos_tecnicos();
	include('./funciones/mod2_depositos.php');              $Depo = new Depositos();
    
	$id_user = $U->get_id( $login);

    // actualizo la tabla (según roles actuales)
    $Tec->aux_upd();
    
	$arr_tecnicos = array(); 
	$arr_tecnicos = $Tec->gets(); 
?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>    

<!-- PASAR DATOS AL MODAL: Actualizar  -->
<script>
$(document).ready(function(){  
	$('#modal_upd').on('show.bs.modal', function (event) {    
		  var button     = $(event.relatedTarget)  // Botón que activó el modal
		  var id_upd     = button.data('idd')         
		  var fk_usuario = button.data('fk_usuario')   
		  var fk_deposito= button.data('fk_deposito')   
		  var persona    = button.data('persona')   
		  var modal      = $(this)
		  modal.find('.modal-body #id_upd').val(id_upd)
		  modal.find('.modal-body #fk_usuario').val(fk_usuario)
		  modal.find('.modal-body #fk_deposito').val(fk_deposito)
		  modal.find('.modal-body #persona').val(persona)
		 
		  // hace la busqueda para mostrar la imagen
		  $("#ver_deposito").delay(10).queue(function(n) { 
				$.ajax({
						type: "POST",
						url:  "./funciones/mod2_depositos_tecnicos_ajax_depo.php",
						data: "fk_deposito="+fk_deposito,
						dataType: "html",
						error: function(){
							alert("error petición ajax");
						},
						success: function(data){                                                      
							$("#ver_deposito").html(data);
							n();
						}
				});                                           
			});

		  $('.alert').hide();//Oculto alert
		})
	});
</script>

    <!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id; var dep;  var usu_log;  var usu;       
        $("#validar_upd").click(function(){
            id_upd = $("#id_upd").val();					
            dep    = $("#dep_").val();			
            usu_log= $("#usuario").val();			
            usu    = $("#fk_usuario").val();	

            $("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod2_depositos_tecnicos_ajax_validar_upd.php",                                                                                                                                                                                                    
                    data: "id_upd="+id_upd+"&dep="+dep+"&usu_log="+usu_log+"&usu="+usu,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_upd").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Agregar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var codi; var prov;  var dir;  var tel; var usu;          
        $("#validar_add").click(function(){
            codi = $("#codigo_").val();			
            dep  = $("#dep").val();				
            usu  = $("#usuario").val();				
            nom  = $("#nom_").val();				

            $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod2_ajax_validar_add_arato.php",                                                                                                                                                                                                    
                    data: "cod="+codi+"&dep="+dep+"&usu="+usu+"&nom="+nom,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
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
                                                <li class="breadcrumb-item">Depósitos</li>
                                                <li class="breadcrumb-item"><a href="_depositos_.php" title="ir">Depósitos </a></li>
                                                <li class="breadcrumb-item active" aria-current="page"> Asociar Tecnico a Depósito </li>                                                
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO ------------------------------------------------------------------------------------------------------------------->

                    <!-- Modal: Info -->
                    <div id="modal_info" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Información </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <label><i class="icon-warning"></i> La función permite relacionar los diferentes usuarios que cumplen el rol de TECNICOS, a un DEPOSITO seleccionado. </label>                                            
                                            <br/>
                                            <label><i class="icon-warning"></i> La información se actualiza al ingresar a la función. </label>                                            
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
                    
                    <!-- Modal: Modificar -->
                    <div id="modal_upd" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar </h6></div>

                            <form name="mdf_dep" id="mdf_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label >Persona <span class="mandatory">*</span></label>
                                            <input type="text"   id="persona"    name="persona"   class="form-control form-control-sm" tabindex="1" required>
                                            <input type="hidden" id="id_upd"     name="id_upd"   >
                                            <input type="hidden" id="usuario"    name="usuario" value="<?php echo $id_user ?>" >
                                            <input type="hidden" id="fk_usuario" name="fk_usuario"  >
                                        </div>
                                        <div id="ver_deposito"></div>	
                                    </div>
                                    </div>
                                </div>

                                <div class="modal-footer"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="5">Cancelar</button>		                                    
                                    <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="6"> Modificar </button>
                                    <br/><br/>
                                    <div id="mostrar_validar_upd" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>				

                    <!-- FUNCIONES EXTRAS -->
                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 mx-auto layout-spacing">                            
                            <div class="statbox widget box box-shadow">                                
                                <div class="widget-content widget-content-area text-center">
                                    <br/>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                                    <?php if($alta == '1') { ?>
                                        <!-- <button data-bs-toggle="modal" data-bs-target="#modal_add" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar un Arato" ><i class="bi bi-plus-circle" style="font-size: 1rem;"></i></button> -->
                                    <?php } ?> 
                                    <br/>                               
                                </div>
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
                                                <th style='text-align:center'> Nombre  		</th>
                                                <th style='text-align:center'> Deposito		</th>
                                                <th style='text-align:center'> Acciones		</th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_tecnicos) && $j<count($arr_tecnicos) ; $j++){
                                            $cur  = $arr_tecnicos[$j];
                                        
                                            $btn_mdf = '<button data-bs-toggle="modal" data-bs-target="#modal_upd"     
                                                           data-idd="'.$cur['id'].'" data-fk_usuario="'.$cur['fk_usuario'].'" data-fk_deposito="'.$cur['fk_deposito'].'" data-persona="'.$cur['apellido'].', '.$cur['nombre'].'"
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar un registro">
                                                           <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                                           </button>';

                                            if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; } else {  $btn_mdf_mostrar= ''; }

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['apellido'].', '.$cur['nombre']  	."</td>\n"
                                            . '<td style="text-align:center">'. $cur['nbre_dep'].' - '.$cur['provi']    ."</td>\n"
                                            . '<td style="text-align:center">'. $btn_mdf_mostrar . "</td>\n"
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


</body>
</html>

