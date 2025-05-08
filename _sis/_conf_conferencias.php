<?php	
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('15',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
	
	// ------------------------------ FUNCION ------------------------------ //			
	include('./funciones/mod5_conferencias.php'); $Con = new Conferencias();
	
    $arr_conf = array(); $arr_orga  = array();
	$arr_conf = $Con->gets_all_conferencias();
    $arr_orga = $Con->gets_all_organismos();
	$id_user  = $U->get_id( $login);

?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>    

<!-- Muestra input de cupo y lugar segun elija online o presencial -->
<script language="javascript">
$(document).ready(function(){
    var modalidadadd; 
    modalidadadd= $("#modalidad").val();
    if(modalidadadd == 'OnLine'){
        document.getElementById('div_cupo').hidden = true;
        document.getElementById('div_lugar').hidden = true;
    }else{
        if (modalidadadd == 'Presencial'){
            document.getElementById('div_cupo').hidden = false;
            document.getElementById('div_lugar').hidden = false;
        }
    };
});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Agregar -->
<script language="javascript">
$(document).ready(function(){    
    var titulo; var dis; var org; var fecha; var hora; var mod; var cupo; var i_inicio; var i_final; var lugar; var usr;                   
    $("#validar_add").click(function(){
		titulo   = $("#titulo").val();
        dis      = $("#disertante").val();
        org      = $("#organismo").val();
        fecha    = $("#fecha").val();
        hora     = $("#hora").val();
        mod      = $("#modalidad").val();
        cupo     = $("#cupo").val();
        i_inicio = $("#insc_inicio").val();
        i_final  = $("#insc_final").val();
        lugar    = $("#lugar").val();
        usr      = $("#id_user").val();
        $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod5_ajax_validar_add_conferencia.php",                                                                                                                                                                                                    
                data: "titulo="+titulo+"&fecha="+fecha+"&hora="+hora+"&mod="+mod+"&cupo="+cupo+"&i_inicio="+i_inicio+"&i_final="+i_final+"&lugar="+lugar+"&id_user="+usr+"&disertante="+dis+"&organismo="+org,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- Pasar datos al modal para MOSTRARLOS -->
<script>
$(document).ready(function(){  
	$('#modal_view').on('show.bs.modal', function (event) {    
		var button = $(event.relatedTarget)  // Botón que activó el modal
		var id          = button.data('id')    
		var titulo      = button.data('titulo')
        var disertante  = button.data('disertante')
        var organismo   = button.data('organismo')
		var fecha       = button.data('fecha')
		var hora        = button.data('hora')
		var insc_inicio = button.data('insc_inicio')  
		var insc_final  = button.data('insc_final')
		var cupo        = button.data('cupo')    
		var estado      = button.data('estado')
		var modalidad   = button.data('modalidad')
        var lugar       = button.data('lugar')
			var modal = $(this)
		modal.find('.modal-body #id').val(id)
		modal.find('.modal-body #titulo').val(titulo)
        modal.find('.modal-body #disertante').val(disertante)
        modal.find('.modal-body #organismo').val(organismo)
		modal.find('.modal-body #fecha').val(fecha)
		modal.find('.modal-body #hora').val(hora)
		modal.find('.modal-body #insc_inicio').val(insc_inicio)
		modal.find('.modal-body #insc_final').val(insc_final)
		modal.find('.modal-body #cupo').val(cupo)
		modal.find('.modal-body #estado').val(estado)
		modal.find('.modal-body #modalidad').val(modalidad)   
		modal.find('.modal-body #lugar').val(lugar)
		$('.alert').hide();//Oculto alert       
	})
});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Cambiar el estado -->	
<script language="javascript">
$(document).ready(function(){                         
    var id; var state;          
    $("#validar_upd_sta").click(function(){
		id    = $("#id_sta").val();			
		state = $("#estado_sta").val();
        id_usr= $("#id_usr_sta").val();			
		
	  	$("#mostrar_validar_upd_sta").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod5_ajax_validar_upd_estado_conferencia.php",                                                                                                                                                                                                    
                data: "id="+id+"&state="+state+"&idusr="+id_usr,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_upd_sta").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- PASAR DATOS AL MODAL: Mostrar para confirmar cambio de estado -->
<script>
$(document).ready(function(){  
	$('#modal_mdfSta').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var id_sta      = button.data('id_sta')   
		  var titulo_sta  = button.data('titulo_sta')
          var estado_sta  = button.data('estado_sta')   
		  var mostrar_sta = button.data('mostrar_sta')
          var fecha_sta   = button.data('fecha_sta')   
		  var hora_sta    = button.data('hora_sta')
          var modalidad_sta    = button.data('modalidad_sta')   
		  var cupo_sta    = button.data('cupo_sta')   
		  var modal    = $(this)
		  modal.find('.modal-body #id_sta').val(id_sta)
		  modal.find('.modal-body #titulo_sta').val(titulo_sta)
          modal.find('.modal-body #estado_sta').val(estado_sta)
		  modal.find('.modal-body #mostrar_sta').val(mostrar_sta)
          modal.find('.modal-body #fecha_sta').val(fecha_sta)
		  modal.find('.modal-body #hora_sta').val(hora_sta)
          modal.find('.modal-body #modalidad_sta').val(modalidad_sta)
		  modal.find('.modal-body #cupo_sta').val(cupo_sta) 
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- PASAR DATOS AL MODAL: Borrar Foro -->
<script>
$(document).ready(function(){  
	$('#modal_del').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var id_del_evento= button.data('id_del_evento')
          var id_del_conf  = button.data('id_del_conf')   
		  var titulo_del   = button.data('titulo_del')   
		  var modal    = $(this)
		  modal.find('.modal-body #id_del_evento').val(id_del_evento)
          modal.find('.modal-body #id_del_conf').val(id_del_conf)
		  modal.find('.modal-body #titulo_del').val(titulo_del) 
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Borrar el Foro -->	
<script language="javascript">
$(document).ready(function(){                         
    var id_e; var id_c;          
    $("#validar_del").click(function(){
		id_e = $("#id_del_evento").val();
        id_c = $("#id_del_conf").val();			

	  	$("#mostrar_validar_del").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod5_ajax_validar_del_conferencia.php",                                                                                                                                                                                                    
                data: "id_e="+id_e+"&id_c="+id_c,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_del").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- PASAR DATOS AL MODAL:  Para Actualizar Foro -->
<script>
$(document).ready(function(){  
	$('#modal_mdf').on('show.bs.modal', function (event) {    
		var button = $(event.relatedTarget)  // Botón que activó el modal
		var id_eventomdf   = button.data('id_eventomdf')
        var fk_eventomdf   = button.data('fk_eventomdf')    
		var titulomdf      = button.data('titulomdf')
        var disertantemdf  = button.data('disertantemdf')
        var idorganismomdf = button.data('idorganismomdf')
		var fechamdf       = button.data('fechamdf')
		var horamdf        = button.data('horamdf')
		var insc_iniciomdf = button.data('insc_iniciomdf')  
		var insc_finalmdf  = button.data('insc_finalmdf')
		var cupomdf        = button.data('cupomdf')    
		var modalidadmdf   = button.data('modalidadmdf')
        var lugarmdf       = button.data('lugarmdf')
			var modal = $(this)
		modal.find('.modal-body #id_eventomdf').val(id_eventomdf)
        modal.find('.modal-body #fk_eventomdf').val(fk_eventomdf)
		modal.find('.modal-body #titulomdf').val(titulomdf)
        modal.find('.modal-body #disertantemdf').val(disertantemdf)
        modal.find('.modal-body #idorganismomdf').val(idorganismomdf)
		modal.find('.modal-body #fechamdf').val(fechamdf)
		modal.find('.modal-body #horamdf').val(horamdf)
		modal.find('.modal-body #insc_iniciomdf').val(insc_iniciomdf)
		modal.find('.modal-body #insc_finalmdf').val(insc_finalmdf)
		modal.find('.modal-body #cupomdf').val(cupomdf)
		modal.find('.modal-body #modalidadmdf').val(modalidadmdf)   
		modal.find('.modal-body #lugarmdf').val(lugarmdf)

        $("#div_select_org_mdf").delay(10).queue(function(n) { 
		  	$.ajax({
		  		type: "POST",
		  		url:  "./funciones/mod5_ajax_llenar_tabla_organismos.php",
		  		data: "id_org="+idorganismomdf,
		  		dataType: "html",
		  		error: function(){
		  			alert("error petición ajax");
		  		},
		  		success: function(data){                                                      
		  			$("#div_select_org_mdf").html(data);
		  			n();
		  		}
		  	});                                           
		});

        var modali_; 
        modali_= $("#modalidadmdf").val();
        if(modali_ == 'OnLine'){
           document.getElementById('divcupomdf').hidden = true;
           document.getElementById('divlugarmdf').hidden = true;
        }else{
            if (modalidad_ == 'Presencial'){
                document.getElementById('divcupomdf').hidden = false;
                document.getElementById('divlugarmdf').hidden = false;
            }
         };

		$('.alert').hide();//Oculto alert       
	})
});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
<script language="javascript">
$(document).ready(function(){                         
    var id_e; var id_c; var titulo;	var estado; var fecha; var hora; var tipo; var cupo; var i_inicio; var i_final;
    var lugar; var usr; var dis; var org;
    $("#validar_upd").click(function(){
		id_e      = $("#id_eventomdf").val();
        fk_evento = $("#fk_eventomdf").val();			
		titulo    = $("#titulomdf").val();
        dis       = $("#disertantemdf").val();
        org       = $("#organismomdf").val();
        fecha     = $("#fechamdf").val();			
		hora      = $("#horamdf").val();			
		mod       = $("#modalidadmdf").val();			
		cupo      = $("#cupomdf").val();
        i_inicio  = $("#insc_iniciomdf").val();			
		i_final   = $("#insc_finalmdf").val();
        lugar     = $("#lugarmdf").val();
        usr       = $("#id_usermdf").val();

	  	$("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod5_ajax_validar_upd_conferencia.php",                                                                                                                                                                                                    
                data: "id_e="+id_e+"&titulo="+titulo+"&fecha="+fecha+"&hora="+hora+"&mod="+mod+"&cupo="+cupo+"&i_inicio="+i_inicio+"&i_final="+i_final+"&lugar="+lugar+"&id_user="+usr+"&id_c="+fk_evento+"&dis="+dis+"&org="+org,
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_upd").html(data);  	n();    }
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
                                                <li class="breadcrumb-item"><a href="principal.php" title="Dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="inner-text"></span></a></li>
                                                <li class="breadcrumb-item">Conferencias</li>
                                                <li class="breadcrumb-item active" aria-current="page">Conferencias</li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO ------------------------------------------------------------------------------------------------------------>

                    <!-- Modal: Info -->
                    <div id="modal_info" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Información </h6></div>

                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label><i class="icon-warning"></i> La función permite administrar Eventos, espedificamente Conferencias </label></center>
                                        </div><br>
                                        <div class="row">
                                            <center><label><i class="icon-warning"></i> Alta, bajas y/o modificaciones de datos de una Conferencia </label></center>
                                        </div><br>							
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="1">Cerrar</button>		                                                                        
                                </div></center> 
                                    
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Borrar -->
                    <div id="modal_del" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-content" >
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-trash" style="font-size: 1rem;"></i> Borrar Conferencia </h6></div>

                            <form name="formdel" id="formdel" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label style="color:red;font: size 30px;"><i class="bi bi-exclamation-triangle" style="font-size: 1rem;"></i>  ¿ Está seguro de Elimnar esta Conferencia ? </label></center>
                                        </div><br>
                                        <div class="row" align="center">
                                            <div class="col-md-12">
                                                <label>Titulo</label>
                                                <input type="text"   id="titulo_del" name="titulo_del" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden" id="id_del_evento" name="id_del_evento" >
                                                <input type="hidden" id="id_del_conf"   name="id_del_conf" >
                                            </div>	
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="2">Cancelar</button>		                                    
                                    <button id="validar_del" name="validar_del" type="button" class="btn btn-danger" title="Se va a validar si se puede modificar." tabindex="3"> Eliminar </button>
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
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-plus-circle" style="font-size: 1rem;"></i> Agregar Conferencia </h6></div>

                            <form name="add_dep" id="add_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Titulo<span class="mandatory">*</span></label>   
                                                <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" tabindex="1" required>
                                                <input type="hidden" id="id_user" name="id_user" value="<?php echo $id_user; ?>" >
                                            </div>
                                        </div>  <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Disertante<span class="mandatory">*</span></label>
                                                <input type="text" id="disertante" name="disertante" class="form-control form-control-sm" tabindex="2" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Organismo Organizador<span class="mandatory">*</span></label>
                                                <select id="organismo" name="organismo" class="form-select form-control-sm" tabindex="3" required >
	    	                                    <?php
		   		                                    for ($i = 0; $i < count($arr_orga); $i++)
                                                        echo '<option value="'.$arr_orga[$i]['id'].'"'.'>' .$arr_orga[$i]['organismo']. "</option>\n";
					                            ?>
			                                     </select>     
                                            </div>
                                        </div> <br>                                  
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Fecha<span class="mandatory">*</span></label>   
                                                <input type="date" id="fecha" name="fecha" class="form-control form-control-sm" tabindex="4" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Hora<span class="mandatory">*</span></label>   
                                                <input type="time" id="hora" name="hora" class="form-control form-control-sm" tabindex="5" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Modalidad<span class="mandatory">*</span></label>   
                                                <select id="modalidad" name="modalidad" class="form-select form-control-sm" onChange="show_div(this)" tabindex="6" required>
											        <option value="OnLine">OnLine</option>
											        <option value="Presencial">Presencial</option>
											    </select>
                                            </div>
                                            <div class="col-md-3" id="div_cupo" name="div_cupo">
                                                <label>Cupo<span class="mandatory">*</span></label>   
                                                <input type="number" id="cupo" name="cupo" class="form-control form-control-sm" tabindex="7" required>
                                            </div>
                                        </div> <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Periodo de Inscripción</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Inicio<span class="mandatory">*</span></label>
                                                <input type="date" id="insc_inicio" name="insc_inicio" class="form-control form-control-sm" tabindex="8" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Final<span class="mandatory">*</span></label>
                                                <input type="date" id="insc_final"  name="insc_final"  class="form-control form-control-sm" tabindex="9" required>
                                            </div>
                                        </div> <br>
                                        <div class="row" id="div_lugar" name="div_lugar">
                                            <div class="col-md-12">
                                                <label>Lugar<span class="mandatory">*</span></label>   
                                                <input type="text" id="lugar" name="lugar" class="form-control form-control-sm" tabindex="10" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="11">Cancelar</button>		                                    
                                    <button id="validar_add" name="validar_add" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="12" > Agregar </button>
                                    <br /><br />
                                    <div id="mostrar_validar_add" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Ver mas datos -->
                    <div id="modal_view" class="modal animated fadeInDown" tabindex="-1" role="dialog" >
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-info-circle" style="font-size: 1rem;"></i> Ver datos de la Conferencia </h6></div>

                            <form name="view_con" id="view_con" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <label>Titulo<span class="mandatory">*</span></label>   
                                                <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" tabindex="1" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Estado<span class="mandatory">*</span></label>   
                                                <input type="text" id="estado" name="estado" title="Indica si se muestra o no esta conferencia en la página" class="form-control form-control-sm" tabindex="1" readonly>
                                            </div>
                                        </div>  <br>                                  
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Fecha<span class="mandatory">*</span></label>   
                                                <input type="date" id="fecha" name="fecha" class="form-control form-control-sm" tabindex="2" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Hora<span class="mandatory">*</span></label>   
                                                <input type="time" id="hora" name="hora" class="form-control form-control-sm" tabindex="3" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Modalidad<span class="mandatory">*</span></label>   
                                                <input type="text" id="modalidad" name="modalidad" class="form-control form-control-sm" tabindex="4" readonly>
                                            </div>
                                            <div class="col-md-3" id="div_cupo" name="div_cupo">
                                                <label>Cupo<span class="mandatory">*</span></label>   
                                                <input type="text" id="cupo" name="cupo" class="form-control form-control-sm" tabindex="5" readonly>
                                            </div>
                                        </div> <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Periodo de Inscripción</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Inicio<span class="mandatory">*</span></label>
                                                <input type="date" id="insc_inicio" name="insc_inicio" class="form-control form-control-sm" tabindex="6" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Final<span class="mandatory">*</span></label>
                                                <input type="date" id="insc_final"  name="insc_final"  class="form-control form-control-sm" tabindex="7" readonly>
                                            </div>
                                        </div> <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Lugar<span class="mandatory">*</span></label>   
                                                <input type="text" id="lugar" name="lugar" class="form-control form-control-sm" tabindex="8" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="9">Cancelar</button>		                                    
                                    <br>
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar Estado -->
                    <div id="modal_mdfSta" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-repeat" style="font-size: 1rem;"></i> Modificar Estado de la Conferencia  </h6></div>

                            <form name="mdfsta" id="mdfsta" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <center><div class="input-group md-4">
                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-exclamation-triangle" style="font-size: 1rem;"></i></span>
                                                    <input type="text" id="mostrar_sta" name="mostrar_sta" class="form-control form-control-sm" aria-label="notification" aria-describedby="basic-addon1" readonly>
                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-exclamation-triangle" style="font-size: 1rem;"></i></span>
                                                </div></center>
                                            </div>
                                        </div> <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Titulo<span class="mandatory">*</span></label>   
                                                <input type="text" id="titulo_sta" name="titulo_sta" class="form-control form-control-sm" tabindex="1" readonly>
                                                <input type="hidden" id="estado_sta" name="estado_sta" >
                                                <input type="hidden" id="id_sta" name="id_sta" >
                                                <input type="hidden" id="id_usr_sta"     name="id_usr_sta" value="<?php echo $id_user; ?>" >
                                            </div>
                                        </div>  <br>                                  
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Fecha<span class="mandatory">*</span></label>   
                                                <input type="date" id="fecha_sta" name="fecha_sta" class="form-control form-control-sm" tabindex="2" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Hora<span class="mandatory">*</span></label>   
                                                <input type="time" id="hora_sta" name="hora_sta" class="form-control form-control-sm" tabindex="3" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Modalidad<span class="mandatory">*</span></label>   
                                                <input type="text" id="modalidad_sta" name="modalidad_sta" class="form-control form-control-sm" tabindex="4" readonly>
                                            </div>
                                            <div class="col-md-3" >
                                                <label>Cupo<span class="mandatory">*</span></label>   
                                                <input type="text" id="cupo_sta" name="cupo_sta" class="form-control form-control-sm" tabindex="5" readonly>
                                            </div>
                                        </div> <br>
                                    </div>
                                </div>

                                <div class="modal-footer"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="5">Cancelar</button>		                                    
                                    <button id="validar_upd_sta" name="validar_upd_sta" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="6"> Cambiar Estado </button>
                                    <br/><br/>
                                    <div id="mostrar_validar_upd_sta" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar -->
                    <div id="modal_mdf" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">          
                                <div class="modal-header">
                                    <h6 class="modal-title"><i class="bi bi-pencil" style="font-size: 1rem;"></i> Editar datos de la Conferencia </h6>
                                </div>
                                <form name="formedt" id="foredt" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                    <div class="modal-body with-padding">
                                        <div class="form-group-sm">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Titulo<span class="mandatory">*</span></label>   
                                                    <input type="text" id="titulomdf" name="titulomdf" class="form-control form-control-sm" tabindex="1" required>
                                                    <input type="hidden" id="id_eventomdf"   name="id_eventomdf">
                                                    <input type="hidden" id="fk_eventomdf"   name="fk_eventomdf">
                                                    <input type="hidden" id="id_usermdf"     name="id_usermdf" value="<?php echo $id_user; ?>" >
                                                </div>
                                            </div>  <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Disertante<span class="mandatory">*</span></label>
                                                    <input type="text" id="disertantemdf" name="disertantemdf" class="form-control form-control-sm" tabindex="2" required>
                                                </div>
                                                <div class="col-md-6" id="div_select_org_mdf"></div>
                                            </div> <br>                                  
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Fecha<span class="mandatory">*</span></label>   
                                                    <input type="date" id="fechamdf" name="fechamdf" class="form-control form-control-sm" tabindex="2" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Hora<span class="mandatory">*</span></label>   
                                                    <input type="time" id="horamdf" name="horamdf" class="form-control form-control-sm" tabindex="3" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Modalidad<span class="mandatory">*</span></label>   
                                                    <select id="modalidadmdf" name="modalidadmdf" class="form-select form-control-sm" onChange="show_divmdf(this)" tabindex="6" required>
                                                        <option value="OnLine">OnLine</option>
                                                        <option value="Presencial">Presencial</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="divcupomdf" name="divcupomdf">
                                                    <label>Cupo<span class="mandatory">*</span></label>   
                                                    <input type="number" id="cupomdf" name="cupomdf" class="form-control form-control-sm" tabindex="5" required>
                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Periodo de Inscripción</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Inicio<span class="mandatory">*</span></label>
                                                    <input type="date" id="insc_iniciomdf" name="insc_iniciomdf" class="form-control form-control-sm" tabindex="6" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Final<span class="mandatory">*</span></label>
                                                    <input type="date" id="insc_finalmdf"  name="insc_finalmdf"  class="form-control form-control-sm" tabindex="7" required>
                                                </div>
                                            </div> <br>
                                            <div class="row" id="divlugarmdf" name="divlugarmdf">
                                                <div class="col-md-12">
                                                    <label>Lugar<span class="mandatory">*</span></label>   
                                                    <input type="text" id="lugarmdf" name="lugarmdf" class="form-control form-control-sm" tabindex="8" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer"><center>					
                                    <button type="button" tabindex="11" class="btn btn-dark" onclick="window.location.href='./_conf_conferencias.php'" tabindex="11">Cancelar</button>
                                        <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="6"> Modificar </button>
                                        <br/><br/>
                                        <div id="mostrar_validar_upd" ></div> 
                                    </div></center>
                                </form>
                            </div>
                        </div>
                    </div>
				
                    <!-- FUNCIONES EXTRAS -->
                    <br><br>
                    <div class="alert custom-alert-3 alert-light-primary alert-dismissible fade show mb-4" role="alert">
                        <div class="media">
                            <div class="alert-icon">
                                <i class="bi bi-list-check" style="font-size: 1,5rem;"></i>
                            </div>
                            &nbsp;&nbsp;
                            <div class="media-body">
                                <div class="alert-text">
                                    <strong> <h6> Listado de Conferencias generadas </h6> </strong> 
                                </div>
                            </div>
                            <div class="alert-btn">
                                <?php if($alta == '1') { ?>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_add" class="btn btn-outline-success btn-icon mb-2 me-4 btn-sm" title="Agregar una Conferencia" ><i class="bi bi-plus-circle" style="font-size: 1rem;"></i></button>                                        
                                <?php } ?>
                                <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4 btn-sm" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- DATATABLE -->
                    <div class="row layout-top-spacing">                    
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        
                            <div class="widget-content widget-content-area br-8">
                                <table id="dt_conferencias" class="table dt-table-hover" style="width:100%">
                                    
                                    <?php
                                        $tabla= "<thead><tr class=\"rowHeaders\">			
                                                <th style='text-align:center'> id   	</th>
                                                <th style='text-align:center'> Título	</th>
                                                <th style='text-align:center'> Fecha 	</th>
                                                <th style='text-align:center'> Hora 	</th>
                                                <th style='text-align:center'> Estado 	</th>
                                                <th style='text-align:center'> Acciones </th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_conf) && $j<count($arr_conf) ; $j++){
                                            $cur  = $arr_conf[$j];
                                            if($cur['estado']== '1'){ $msj_mostrar= 'No se Muestra'; }else{ $msj_mostrar= 'Si se Muestra'; }
                                        
                                            $btn_del = ' <button data-bs-toggle="modal" data-bs-target="#modal_del" 
                                                            data-id_del_evento="'.$cur['id_evento'].'" data-id_del_conf="'.$cur['id_conferencia'].'" 
                                                            data-titulo_del="'.$cur['titulo'].'" 
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Eliminar Conferencia" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                            </button>';

                                            $btn_mdf = '<button data-bs-toggle="modal" data-bs-target="#modal_mdf" 
                                                           data-id_eventomdf="'.$cur['id_evento'].'" data-fk_eventomdf="'.$cur['fk_evento'].'" data-titulomdf="'.$cur['titulo'].'" data-fechamdf="'.$cur['fecha'].'" data-horamdf="'.$cur['hora'].'"
                                                           data-modalidadmdf="'.$cur['modalidad'].'" data-cupomdf="'.$cur['cupo'].'" data-insc_iniciomdf="'.$cur['f_inscrip_dsd'].'"
                                                           data-insc_finalmdf="'.$cur['f_inscrip_hst'].'" data-lugarmdf="'.$cur['lugar'].'" 
                                                           data-disertantemdf="'.$cur['disertante'].'" data-idorganismomdf="'.$cur['id_organismo'].'"
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Editar datos de la Conferencia">
                                                           <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                                           </button>';
                                                           
                                            $btn_view = '<button data-bs-toggle="modal" data-bs-target="#modal_view" 
                                                           data-id="'.$cur['id'].'" data-titulo="'.$cur['titulo'].'" data-fecha="'.$cur['fecha'].'" data-hora="'.$cur['hora'].'" 
                                                           data-insc_inicio="'.$cur['f_inscrip_dsd'].'" data-insc_final="'.$cur['f_inscrip_hst'].'" data-lugar="'.$cur['lugar'].'"
                                                           data-estado="'.$msj_mostrar.'" data-modalidad="'.$cur['modalidad'].'" data-cupo="'.$cur['cupo'].'" 
                                                           class="btn btn-outline-primary btn-icon mb-2 me-4" title="Ver mas Datos de la Conferencia">
                                                           <i class="bi bi-eye" style="font-size: 1rem;"></i>
                                                           </button>';

                                            if ($cur['estado']==1){
                                                $clase= 'class="btn btn-light-warning mb-2 me-4"'; $msj='Deshabilitada';
                                            }else{
                                                $clase= 'class="btn btn-light-success mb-2 me-4"'; $msj='Habilitada';
                                            }

                                            $btn_state= '<button data-bs-toggle="modal" data-bs-target="#modal_mdfSta"'.$clase.' 
                                                         data-id_sta="'.$cur['id_conferencia'].'" data-titulo_sta="'.$cur['titulo'].'" data-estado_sta="'.$cur['estado'].'" data-mostrar_sta="Actualmente '.$msj_mostrar.'"
                                                         data-fecha_sta="'.$cur['fecha'].'" data-hora_sta="'.$cur['hora'].'" data-modalidad_sta="'.$cur['modalidad'].'" data-cupo_sta="'.$cur['cupo'].'"
                                                         title="Modificar estado de la Conferencia">'.$msj.'
                                                         </button>';

                                            if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; $btn_sta_mostrar= $btn_state; } 
                                            else             { $btn_mdf_mostrar= ''; 
                                                               $btn_sta_mostrar= '<button data-bs-toggle="modal"'.$clase.' title="Estado de la Conferencia">'.$msj.'</button>';}

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['id']    	."</td>\n"
                                            . '<td style="text-align:center">'. $cur['titulo']  ."</td>\n"
                                            . '<td style="text-align:center">'.'<i class="bi bi-calendar-event" style="font-size: 1rem;"></i>  '.
                                                date('d/m/Y', strtotime($cur['fecha']))."</td>\n"
                                            . '<td style="text-align:center">'.'<i class="bi bi-clock" style="font-size: 1rem;"></i>  '. 
                                                date('H:i', strtotime($cur['hora']))   ."</td>\n"
                                            . '<td style="text-align:center">'. $btn_sta_mostrar  ."</td>\n"
                                            . '<td style="text-align:center">'. $btn_view.$btn_mdf_mostrar.$btn_del_mostrar."</td>\n"
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
    $('#dt_conferencias').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "columnDefs": [ {
			"targets": [0],
			"visible": false
		 } ],
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

<!-- Mostrar input Segun selección de tipo de conferencia en el modal Agregar  -->
<script type="text/javascript">
	function show_div(selectTag){
		if(selectTag.value == 'OnLine' ){
			document.getElementById('div_cupo').hidden = true;
            document.getElementById('div_lugar').hidden = true;	
		}else{
			document.getElementById('div_cupo').hidden = false;
            document.getElementById('div_lugar').hidden = false;		
		}	 		
	}
</script>

<!-- Mostrar input según valor seleccionado en el modal Modificar  -->
<script type="text/javascript">
	function show_divmdf(selectTag){
		if(selectTag.value == 'OnLine' ){
			document.getElementById('divcupomdf').hidden = true;
            document.getElementById('divlugarmdf').hidden = true;	
		}else{
			document.getElementById('divcupomdf').hidden = false;
            document.getElementById('divlugarmdf').hidden = false;		
		}	 		
	}
</script>

</body>
</html>

