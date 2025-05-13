<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('9',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
	
	// ------------------------------ FUNCION ------------------------------ //			
	include_once('./funciones/mod3_productos.php');       $Productos = new Productos();
	include_once('./funciones/mod3_ronda_neg.php');       $RondaNeg  = new RondaNegocios();

	$arr_ = array(); 
	$arr_ = $RondaNeg->gets(); 

	$id_user = $U->get_id( $login);

    $arr_prod= array();
    $arr_prod= $Productos->gets();

    $entidad = 'Ronda de Negocios';
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

    <!-- PASAR DATOS AL MODAL: Actualizar  -->
    <script>
    $(document).ready(function(){  
        $('#modal_upd').on('show.bs.modal', function (event) {    
            var button    = $(event.relatedTarget)  // Botón que activó el modal
            var id        = button.data('id')  
            var nom       = button.data('nombre') 
            var modal     = $(this)
            modal.find('.modal-body #id_rn').val(id)
            modal.find('.modal-body #nombre').val(nom)

            $('.alert').hide();//Oculto alert
            })
        });
    </script>

<!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
<script language="javascript">
$(document).ready(function(){                         
    var codi; var prov;  var dir;  var tel; var usu;          
    $("#validar_upd").click(function(){
		id    = $("#id_").val();			
		usu   = $("#usuario").val();			
		nom   = $("#nombre").val();			
		nomant= $("#nombreant").val();			

	  	$("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod3_productos_ajax_validar_upd.php",                                                                                                                                                                                                    
                data: "id="+id+"&usuario="+usu+"&nom="+nom+"&nomant="+nomant,     
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
                url: "./funciones/mod3_ronda_neg_ajax_validar_del.php",                                                                                                                                                                                                    
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
		usu = $("#usuario").val();		    lug= $("#lug_").val();	        f2= $("#f2").val();	                            f_insc_hst= $("#f_insc_hst").val();		
		nom = $("#nom_").val();		        f1 = $("#f1").val();		    f_insc_dsd= $("#f_insc_dsd").val();		        chek= $("#chek").val();		

	  	$("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod3_ronda_neg_ajax_validar_add.php",                                                                                                                                                                                                    
                data: "usu="+usu+"&nom="+nom+"&lug="+lug+"&f1="+f1+"&f2="+f2+"&f_insc_dsd="+f_insc_dsd+"&f_insc_hst="+f_insc_hst+"&chek="+chek,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
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
                                                <li class="breadcrumb-item active" aria-current="page"> Administración </li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO -->

                    <!-- FUNCIONES EXTRAS -->
                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 mx-auto layout-spacing">                            
                            <div class="statbox widget box box-shadow">                                
                                <div class="widget-content widget-content-area text-center">
                                    <br/>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                                    <?php if($alta == '1') { ?>
                                            <button data-bs-toggle="modal" data-bs-target="#modal_add" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar un registro" ><i class="bi bi-plus-circle" style="font-size: 1rem;"></i></button>
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
                                            <label><i class="icon-warning"></i> La función permite administrar los diferentes Productos que serviran de guiar para crear las agendas entre empresas compradoras y empresas vendedoras del producto en cuestion. </label>
                                            <br/><br/>                                            
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
                        <div class="modal-dialog modal-content" >
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Borrar <?php echo $entidad ?> </h6></div>

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
                                    <button id="validar_del" name="validar_del" type="button" class="btn btn-danger" title="Se va a validar si se puede modificar." tabindex="3"> Finalizar </button>
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
                            
                            <div class="modal-header"><h6 class="modal-title"> Agregar <?php echo $entidad ?> </h6></div>

                            <form name="add_reg" id="add_reg" class="form-horizontal validate" method="post" action="./funciones/mod3_ronda_neg_add.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">  

                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Nombre: <span class="mandatory">*</span></label>   
                                                <input type="text" id="nom_" name="nom_" class="form-control form-control-sm" tabindex="1" required>
                                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $id_user ?>" >
                                            </div>
                                            <div class="col-md-5"> 
                                                <label>Lugar: <span class="mandatory">*</span></label>   
                                                <input type="text" id="lug_" name="lug_" class="form-control form-control-sm" tabindex="2" required>
                                            </div> 
                                            <div class="col-md-2"> 
                                                <label>Hs: <span class="mandatory">*</span></label>   
                                                <input type="time" id="hs" name="hs" class="form-control form-control-sm" tabindex="3" required>
                                            </div> 
                                        </div><br/>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Fecha 1: <span class="mandatory">*</span></label>   
                                                <input type="date" id="f1" name="f1" class="form-control form-control-sm" tabindex="4" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Fecha 2: </label>   
                                                <input type="date" id="f2" name="f2" class="form-control form-control-sm" tabindex="5">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Inscripcion desde: <span class="mandatory">*</span></label>   
                                                <input type="date" id="f_insc_dsd" name="f_insc_dsd" class="form-control form-control-sm" tabindex="6" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Inscripcion hasta: <span class="mandatory">*</span></label>   
                                                <input type="date" id="f_insc_hst" name="f_insc_hst" class="form-control form-control-sm" tabindex="7" required>
                                            </div>
                                        </div><br/>                                        

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Productos: (al menos 1)</label>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <?php foreach($arr_prod as $j => $cur): ?>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">
                                                                <input 
                                                                    type="checkbox" name="chek[]" id="chek[]" value="<?php echo $cur['id'] ?>" 
                                                                    class="form-check-input"
                                                                >
                                                                <label class="form-check-label">  <?php echo $cur['nombre'] ?>  </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="8">Cancelar</button>		                                    
                                    <button id="validar_add" name="validar_add" type="submit" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="5" > Agregar </button>
                                    <br /><br />
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar -->
                    <div id="modal_upd" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar <?php echo $entidad ?> </h6></div>

                            <form name="form_mdf_" id="form_mdf_" class="form-horizontal validate" method="post" action="./_ronda_neg_admin_upd.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row" align="center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div><label>Nombre:</label></div>
                                                <input type="text"   id="nombre"  name="nombre" class="form-control form-control-sm" readonly='readonly'/>				                                							
                                                <input type="hidden" id="id_rn" name="id_rn"                         	 />  
                                            </div>	
                                            <div class="col-md-3"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer"><center>	
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> Cerrar </button>
                                    <button type="submit" id="upd_perf" name="upd_perf" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_mdfPermisos()" title="Presione el botón para modificar los permisos." > Siguiente </button>                                    
                                    <br /><br />
                                    <div id="msjBtn_mdfPermisos" style='display:none;' ><img src="images/loading.gif" width="30px" height="30px" alt="loading"/><?php echo '   <font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>
                                    
                            </form>

                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar OLD -->
                    <div id="modal_upd_OLD" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar <?php echo $entidad ?> </h6></div>

                            <form name="mdf_reg" id="mdf_reg" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">                                    					
                                    <div class="form-group-sm">

                                    <div class="row">
                                            <div class="col-md-5">
                                                <label>Nombre: <span class="mandatory">*</span></label>   
                                                <input type="text" id="nombre"    name="nombre" class="form-control form-control-sm" tabindex="1" required>
                                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $id_user ?>" >
                                                <input type="hidden" id="id_"     name="id_" >
                                            </div>
                                            <div class="col-md-5"> 
                                                <label>Lugar: <span class="mandatory">*</span></label>   
                                                <input type="text" id="lugar_" name="lugar_" class="form-control form-control-sm" tabindex="2" required>
                                            </div> 
                                            <div class="col-md-2"> 
                                                <label>Hs: <span class="mandatory">*</span></label>   
                                                <input type="time" id="hs_" name="hs_" class="form-control form-control-sm" tabindex="3" required>
                                            </div> 
                                        </div><br/>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Fecha 1: <span class="mandatory">*</span></label>   
                                                <input type="date" id="f1_" name="f1_" class="form-control form-control-sm" tabindex="4" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Fecha 2: </label>   
                                                <input type="date" id="f2_" name="f2_" class="form-control form-control-sm" tabindex="5">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Inscripcion desde: <span class="mandatory">*</span></label>   
                                                <input type="date" id="dsd_" name="dsd_" class="form-control form-control-sm" tabindex="6" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Inscripcion hasta: <span class="mandatory">*</span></label>   
                                                <input type="date" id="hst_" name="hst_" class="form-control form-control-sm" tabindex="7" required>
                                            </div>
                                        </div><br/>                                        

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Productos: (al menos 1)</label>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <?php foreach($arr_prod as $j => $cur): ?>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">                                                                
                                                                <input 
                                                                    type="checkbox" name="chek[]" id="chek[]" value="<?php echo $cur['id'] ?>" 
                                                                    class="form-check-input"
                                                                >
                                                                <label class="form-check-label">  <?php echo $cur['nombre'] ?>  </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>

                                
                                    </div>
                                </div>

                                <div class="modal-footer"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="8">Cancelar</button>		                                    
                                    <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="9"> Modificar </button>
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
                                                <th style='text-align:center'> Nombre		</th>
                                                <th style='text-align:center'> Lugar		</th>
                                                <th style='text-align:center'> Fecha 1		</th>
                                                <th style='text-align:center'> Productos	</th>
                                                <th style='text-align:center'> Acciones		</th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_) && $j<count($arr_) ; $j++){
                                            $cur  = $arr_[$j];
                                        
                                            $btn_del = ' <button data-bs-toggle="modal" data-bs-target="#modal_del" 
                                                            data-id="'.$cur['id'].'" data-nombre="'.$cur['nombre'].'"
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Borrar registro" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                            </button>';

                                            $btn_mdf = '<button data-bs-toggle="modal" data-bs-target="#modal_upd" 
                                                           data-id="'.$cur['id'].'"             data-nombreant="'.$cur['nombre'].'" data-nombre="'.$cur['nombre'].'"                                                            
                                                           data-lugar="'.$cur['lugar'].'"       data-hs="'.$cur['hs'].'"            data-f1="'.$cur['f_dia_1'].'"  data-f2="'.$cur['f_dia_2'].'"  
                                                           data-dsd="'.date('Y-m-d', strtotime($cur['f_inscrip_dsd'])).'" data-hst="'.date('Y-m-d', strtotime($cur['f_inscrip_hst'])).'"
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar un registro">
                                                           <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                                           </button>';   $fecha_formateada = date('Y-m-d', strtotime($row['fecha']));

                                            $btn_ver = '<button data-bs-toggle="modal" data-bs-target="#modal_ver" 
                                                           data-id="'.$cur['id'].'" data-nombreant="'.$cur['nombre'].'" data-nombre="'.$cur['nombre'].'"                                                            
                                                           class="btn btn-outline-info btn-icon mb-2 me-4" title="Ver más">
                                                           <i class="bi bi-search" style="font-size: 1rem;"></i>
                                                           </button>';

                                            $list_prod = $RondaNeg->get_prod_en_RN($cur['id']);

                                            if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; } else {  $btn_mdf_mostrar= ''; }

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['nombre']  	."</td>\n"
                                            . '<td style="text-align:center">'. $cur['lugar']  	    ."</td>\n"
                                            . '<td style="text-align:center">'. $cur['f_dia_1']  	."</td>\n"
                                            . '<td style="text-align:center">'. $list_prod  	    ."</td>\n"
                                            . '<td style="text-align:center">'. $btn_mdf_mostrar . $btn_del_mostrar . "</td>\n"
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
            modalAdd.addEventListener('shown.bs.modal', function () {   document.getElementById('nom_').focus();        });
        });
    </script> 

</body>
</html>

