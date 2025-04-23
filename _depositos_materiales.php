<?php
    require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('3',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
	
	// ------------------------------ FUNCION ------------------------------ //			
	include('./funciones/mod2_materiales.php'); $Mat= new Materiales();
	$arr_materiales = array(); 
	$arr_materiales = $Mat->gets();

?>

<!DOCTYPE html><html lang="en">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>    
    
<!-- Validacion de datos por AJAX para AGREGAR  -->
<script language="javascript">
$(document).ready(function(){                         
    var cod; var nom; var min; var uni; var scra;          
    $("#validar_add").click(function(){
		cod  = $("#codigo_").val();
		nom  = $("#nombre_").val();
		min  = $("#cant_min_").val();
		uni  = $("#unidad_medida_").val();
	    scra = $("#min_scrap_").val();
		
		$("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod2_ajax_validar_add_materiales.php",
				data: "cod="+cod+"&nom="+nom+"&min="+min+"&uni="+uni+"&scra="+scra,
                dataType: "html",
                error: function(){	        alert("error petición ajax");                    },
                success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();	 } 
			});                                           
        });                                
    });              
});
</script>

<!-- PASAR DATOS AL MODAL: Modificar Material -->
<script>
$(document).ready(function(){  
	$('#modal_upd').on('show.bs.modal', function (event) {    
		  var button = $(event.relatedTarget)  // Botón que activó el modal
		  var id             = button.data('id')   
		  var codigo_        = button.data('codigo_')
		  var codigo_viejo   = button.data('codigo_viejo')
		  var nombre_        = button.data('nombre_')
		  var cant_min_      = button.data('cant_min_')
		  var unidad_medida_ = button.data('unidad_medida_')
		  var min_scrap_     = button.data('min_scrap_') 
		  var f_create_      = button.data('f_create_')
		  var f_update_      = button.data('f_update_')
		  var modal          = $(this)
		  modal.find('.modal-body #id_upd').val(id)
		  modal.find('.modal-body #codigo_upd').val(codigo_)
		  modal.find('.modal-body #codigo_viejo').val(codigo_viejo)
		  modal.find('.modal-body #nombre_upd').val(nombre_)
		  modal.find('.modal-body #cant_min_upd').val(cant_min_)
		  modal.find('.modal-body #unidad_medida_upd').val(unidad_medida_)
		  modal.find('.modal-body #min_scrap_upd').val(min_scrap_)
		  modal.find('.modal-body #f_create_').val(f_create_)
		  modal.find('.modal-body #f_update_').val(f_update_)
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- Validacion de datos por AJAX para MODIFICAR  -->
<script language="javascript">
$(document).ready(function(){                         
    var id1; var cod1; var nom1; var min1; var uni1; var scra1; var fcre1;          
    $("#validar_upd").click(function(){
		id1   = $("#id_upd").val();
		cod1  = $("#codigo_upd").val();
		cod2  = $("#codigo_viejo").val();
		nom1  = $("#nombre_upd").val();
		min1  = $("#cant_min_upd").val();
		uni1  = $("#unidad_medida_upd").val();
	    scra1 = $("#min_scrap_upd").val();
		fcre1 = $("#f_create_").val();
		$("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod2_ajax_validar_upd_materiales.php",
				data: "id1="+id1+"&cod1="+cod1+"&cod2="+cod2+"&nom1="+nom1+"&min1="+min1+"&uni1="+uni1+"&scra1="+scra1+"&fcre1="+fcre1,
                dataType: "html",
                error: function(){	
					alert("error petición ajax");           
					},
                success: function(data){ 
					$("#mostrar_validar_upd").html(data);  
					n();
				 } 
			});                                           
        });                                
    });              
});
</script>

<!-- PASAR DATOS AL MODAL: Borrar -->
<script>
$(document).ready(function(){  
	$('#modal_del').on('show.bs.modal', function (event) {    
		  var button = $(event.relatedTarget)  // Botón que activó el modal
		  var id            = button.data('id')   
		  var codigo        = button.data('codigo')
		  var nombre        = button.data('nombre')
		  var cant_min      = button.data('cant_min')
		  var unidad_medida = button.data('unidad_medida')
		  var min_scrap     = button.data('min_scrap') 
		  var f_create      = button.data('f_create')  
		  var modal    = $(this)
		  modal.find('.modal-body #id_del').val(id)
		  modal.find('.modal-body #codigo').val(codigo)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-body #cant_min').val(cant_min)
		  modal.find('.modal-body #unidad_medida').val(unidad_medida)
		  modal.find('.modal-body #min_scrap').val(min_scrap)
		  modal.find('.modal-body #f_create').val(f_create)
		 
		  $('.alert').hide();//Oculto alert
		})
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
                url: "./funciones/mod2_ajax_validar_del_materiales.php",                                                                                                                                                                                                    
                data: "id="+id,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_del").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>


<!-- PASAR DATOS AL MODAL: Ver -->
<script>
$(document).ready(function(){  
	$('#modal_ver').on('show.bs.modal', function (event) {    
		  var button = $(event.relatedTarget)  // Botón que activó el modal
		  var id            = button.data('id')   
		  var codigo        = button.data('codigo')
		  var nombre        = button.data('nombre')
		  var cant_min      = button.data('cant_min')
		  var unidad_medida = button.data('unidad_medida')
		  var min_scrap     = button.data('min_scrap') 
		  var f_create      = button.data('f_create')
		  var f_update      = button.data('f_update')  
		  var modal    = $(this)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #codigo').val(codigo)
		  modal.find('.modal-body #nombre').val(nombre)
		  modal.find('.modal-body #cant_min').val(cant_min)
		  modal.find('.modal-body #unidad_medida').val(unidad_medida)
		  modal.find('.modal-body #min_scrap').val(min_scrap)
		  modal.find('.modal-body #f_create').val(f_create)
		  modal.find('.modal-body #f_update').val(f_update)
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- Datatable configuracion -->
<SCRIPT type="text/javascript" >
	$(document).ready(function() {
		$("#dt_material").dataTable({
	        "order": [ 0, "desc" ],
			// "columnDefs": [ {
			// 	"targets": [0],
			// 	"visible": false
			//  } ]
		});   
	});
</SCRIPT>

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
                                                <li class="breadcrumb-item"><a href="#">Depósitos</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Materiales</li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO ----------------------------------------------------------------------------------->
                    <!-- CONTENIDO ----------------------------------------------------------------------------------->
                    <!-- CONTENIDO ----------------------------------------------------------------------------------->
                    
                    <!-- FUNCIONES EXTRAS -->
                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 mx-auto layout-spacing">                            
                            <div class="statbox widget box box-shadow">                                
                                <div class="widget-content widget-content-area text-center">
                                    <br/>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                                    <?php if($alta == '1') { ?>
                                        <button data-bs-toggle="modal" data-bs-target="#modal_add" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar un Material" ><i class="bi bi-plus-circle" style="font-size: 1rem;"></i></button>
                                    <?php } ?> 
                                    <br/>                               
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
                                            <label><i class="icon-warning"></i> La función permite cargar los materiales que ingresan al depósito. Además permite:</label>
                                            <br/><br/>
                                            <label><i class="icon-warning"></i> * Alta de material nuevo </label>
                                            <label><i class="icon-warning"></i> * Modificacón de algun dato en particular del material </label>
                                            <label><i class="icon-warning"></i> * Baja de un material debido a que ya no se va a pedir mas u otro motivo </label>
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

                    <!-- Modal: Borrar -->
                    <div id="modal_del" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Borrar </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">

                                        <div class="row">
                                            <center><label style="color:red;font: size 30px;"><i class="icon-warning"></i> ¿ Está seguro ? </label></center>
                                        </div><br>

                                        <div class="row" align="center">
                                            <div class="col-md-3">
                                                <label>Código:</label>
                                                <input type="text"    id="codigo" name="codigo" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id_del" name="id_del" >	 
                                            </div>	
                                            <div class="col-md-6">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre" name="nombre" class="form-control form-control-sm" tabindex="2" readonly >	 
                                            </div>
                                        </div>	
                                        
                                        <div class="row" align="center">
                                            <div class="col-md-4">
                                                <label># Mínima:</label>
                                                <input type="number" id="cant_min" name="cant_min" min="0" class="form-control form-control-sm" tabindex="4" readonly >	 
                                            </div>	
                                            <div class="col-md-4">
                                                <label>Unidad:</label>
                                                <input type="text"    id="unidad_medida" name="unidad_medida" class="form-control form-control-sm" tabindex="5" readonly >	 
                                            </div>	                                            	
                                            <div class="col-md-3">
                                                <label># Min Scrap:</label>
                                                <input type="number" id="min_scrap" min="0" name="min_scrap" class="form-control form-control-sm" tabindex="6" readonly >	 
                                            </div>	
                                        </div>	

                                    </div><br /> 
                                </div>

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="2">Cancelar</button>		                                    
                                    <button id="validar_del" name="validar_del" type="button" class="btn btn-danger" title="Se va a validar si se puede modificar." tabindex="3"> Borrar </button>
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
                            
                            <div class="modal-header"><h6 class="modal-title"> Agregar </h6></div>

                            <form name="add_" id="add_" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm"> 

                                        <div class="row" align="center">
                                            <div class="col-md-3">
                                                <label>Código:</label>
                                                <input type="text"    id="codigo_" name="codigo_" class="form-control form-control-sm" tabindex="1" required >	 
                                            </div>	
                                            <div class="col-md-7">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre_" name="nombre_" class="form-control form-control-sm" tabindex="2" required >	 
                                            </div>
                                        </div><br/>	
                                        
                                        <div class="row" align="center">
                                            <div class="col-md-3">
                                                <label># Stock Mínimo:</label>
                                                <input type="number" id="cant_min_" name="cant_min_" min="0" class="form-control form-control-sm" tabindex="3" required >	 
                                            </div>	
                                            <div class="col-md-4">
                                                <label>Unidad:</label>
                                                <select id="unidad_medida_" name="unidad_medida_" class="form-select unidad_medida_ form-control-sm" tabindex="4" required>
                                                    <option value="LTR">LITROS</option>
                                                    <option value="MTR">METROS</option>
                                                    <option value="UNI">UNIDAD</option>
                                                </select> 
                                            </div>
                                            <div id='mostrar_scrap' class="col-md-3">
                                                <label># Min Scrap: (0 no necesita)</label>
                                                <input type="number" id="min_scrap_" min="0" name="min_scrap_" value='0' class="form-control form-control-sm" tabindex="6" required >	 
                                            </div>	
                                        </div>	

                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="6">Cancelar</button>		                                    
                                    <button id="validar_add" name="validar_add" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="7" > Agregar </button>
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
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar </h6></div>

                            <form name="mdf_dep" id="mdf_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">                                        
                                    
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label >Código <span class="mandatory">*</span></label>
                                                <input type="text"   id="codigo_upd"   name="codigo_upd"   class="form-control form-control-sm" tabindex="1" required>
                                                <input type="hidden" id="codigo_viejo" name="codigo_viejo" >
                                                <input type="hidden" id="id_upd"       name="id_upd"   >
                                                <input type="hidden" id="usuario"      name="usuario" value="<?php echo $id_user ?>" >
                                            </div>
                                            <div class="col-md-8">
                                                <label>Nombre <span class="mandatory">*</span></label>
                                                <input type="text" id="nombre_upd" name="nombre_upd" class="form-control form-control-sm" tabindex="2" required>
                                            </div>
                                        </div><br/>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label >Fecha Creado <span class="mandatory">*</span></label>
                                                <input type="text"   id="f_create_"      name="f_create_"   class="form-control form-control-sm" tabindex="3" readonly='readonly'>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Fecha Última modificacion <span class="mandatory">*</span></label>
                                                <input type="text" id="f_update_" name="f_update_" class="form-control form-control-sm" tabindex="4" readonly='readonly'>
                                            </div>
                                        </div><br/>                                       

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label ># Stock Mínimo<span class="mandatory">*</span></label>
                                                <input type="number"   id="cant_min_upd"      name="cant_min_upd" min="0"  class="form-control form-control-sm" tabindex="5" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Unidad <span class="mandatory">*</span></label>
                                                <select id="unidad_medida_upd" name="unidad_medida_upd" class="form-select unidad_medida_upd form-control-sm" tabindex="6" required>
                                                    <option value="LTR">LITROS</option>
                                                    <option value="MTR">METROS</option>
                                                    <option value="UNI">UNIDAD</option>
                                                </select> 
                                            </div>
                                            <div class="col-md-4"> 
                                                <label># Min Scrap (0 no necesita)<span class="mandatory">*</span></label>   
                                                <input type="number" id="min_scrap_upd" min="0" name="min_scrap_upd" class="form-control form-control-sm" tabindex="7" required >
                                            </div>
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

                    <!-- Modal: Ver -->
                    <div id="modal_ver" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Ver </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">

                                        <div class="row" align="center">
                                            <div class="col-md-3">
                                                <label>Código:</label>
                                                <input type="text"    id="codigo" name="codigo" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id"     name="id"     >	 
                                            </div>	
                                            <div class="col-md-6">
                                                <label>Nombre:</label>
                                                <input type="text"    id="nombre" name="nombre" class="form-control form-control-sm" tabindex="2" readonly >	 
                                            </div>
                                        </div>	
                                        
                                        <div class="row" align="center">
                                            <div class="col-md-4">
                                                <label># Mínima:</label>
                                                <input type="number" id="cant_min" name="cant_min" min="0" class="form-control form-control-sm" tabindex="4" readonly >	 
                                            </div>	
                                            <div class="col-md-4">
                                                <label>Unidad:</label>
                                                <input type="text"    id="unidad_medida" name="unidad_medida" class="form-control form-control-sm" tabindex="5" readonly >	 
                                            </div>	                                            	
                                            <div class="col-md-3">
                                                <label># Min Scrap:</label>
                                                <input type="number" id="min_scrap" min="0" name="min_scrap" class="form-control form-control-sm" tabindex="6" readonly >	 
                                            </div>	
                                        </div>	

                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal"  tabindex="2">Cerrar</button>		                                                         
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
                                                <th style='text-align:center'> Código	</th>
                                                <th style='text-align:center'> Nombre	</th>
                                                <th style='text-align:center'> # Stock  Min 	</th>
                                                <th style='text-align:center'> Unid Med	</th>
                                                <th style='text-align:center'> Acciones	</th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_materiales) && $j<count($arr_materiales) ; $j++){
                                            $cur  = $arr_materiales[$j];
                                        
                                            if($cur['f_update'] == '0000-00-00 00:00:00'){ $fupdate=''; }else{ $fupdate= date("d/m/Y H:i:s", strtotime($cur['f_update'])); }

                                            $btn_del = ' <button data-bs-toggle="modal" data-bs-target="#modal_del" 
                                                            data-id="'.$cur['id'].'" data-codigo="'.$cur['codigo'].'" data-nombre="'.$cur['nombre'].'"
							                                data-cant_min="'.$cur['cant_min'].'" data-unidad_medida="'.$cur['unidad_medida'].'" 
							                                data-min_scrap="'.$cur['cant_min_scrap'].'" data-f_create="'.date("d/m/Y H:i:s", strtotime($cur['f_create'])).'"
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Eliminar un registro" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                            </button>';

                                            $btn_mdf = '<button data-bs-toggle="modal" data-bs-target="#modal_upd" 
                                                           data-id="'.$cur['id'].'" data-codigo_="'.$cur['codigo'].'" data-codigo_viejo="'.$cur['codigo'].'" data-nombre_="'.$cur['nombre'].'" data-cant_min_="'.$cur['cant_min'].'" data-unidad_medida_="'.$cur['unidad_medida'].'" 
							                               data-min_scrap_="'.$cur['cant_min_scrap'].'" data-f_create_="'.date("d/m/Y H:i:s", strtotime($cur['f_create'])).'" data-f_update_="'.$fupdate.'"
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar un registro">
                                                           <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                                           </button>';

                                            $btn_ver = '<button data-bs-toggle="modal" data-bs-target="#modal_ver" 
                                                           data-id="'.$cur['id'].'" data-codigo="'.$cur['codigo'].'" data-nombre="'.$cur['nombre'].'" data-cant_min="'.$cur['cant_min'].'" data-unidad_medida="'.$cur['unidad_medida'].'" 
							                               data-min_scrap="'.$cur['cant_min_scrap'].'" data-f_create="'.date("d/m/Y H:i:s", strtotime($cur['f_create'])).'" data-f_update="'.$fupdate.'"
                                                           class="btn btn-outline-info btn-icon mb-2 me-4" title="Ver un registro">
                                                           <i class="bi bi-search" style="font-size: 1rem;"></i>
                                                           </button>';

                                            if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; } else {  $btn_mdf_mostrar= ''; }

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['codigo']        ."</td>\n"
                                            . '<td style="text-align:center">'. $cur['nombre']  	  ."</td>\n"
                                            . '<td style="text-align:center">'. $cur['cant_min'] 	  ."</td>\n"
                                            . '<td style="text-align:center">'. $cur['unidad_medida'] ."</td>\n"
                                            . '<td style="text-align:center">'. $btn_ver_. $btn_mdf_mostrar. $btn_del_mostrar."</td>\n"
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
            <div class="footer-wrapper">
                <div class="footer clearfix"><div class="pull-left"> &copy; <?php echo $footer ?> </div></div>
            </div>
            
            
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


</body>
</html>

