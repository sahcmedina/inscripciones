<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
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
	$arr_sino= array('no','si');
	$id_user = $U->get_id( $login); 
	// perfiles	
	$arr_perfil = array();
	$arr_perfil = $U->gets_perfil();
	
	// Funciones	
	$arr_func = array();
	$arr_func = $U->gets_funciones();
	
	// modulos y funciones del sistema
	$arr_modulos= array();
	$arr_modulos= $U->gets_modulos_();

    $datos = array();
    $datos = $U->gets_user_empresa(); 

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

    <!-- AJAX: Validar datos por ajax - Antes de Agregar Usuario -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var nom; var ape;  var dni; var email; var tel; var perfil;  var usuario;  var clave;                       
        $("#validar_add_user").click(function(){
            nom = $("#nom").val();			 ape   = $("#ape").val();				
            dni = $("#dni").val();	         email = $("#email").val();		        tel = $("#tel").val();				
            per = $("#perfil").val();	     usu   = $("#usuario").val();			pas = $("#clave").val();				

            $("#mostrar_validar_add_user").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    // url: "./funciones/mod2_ajax_validar_add_arato.php",                                                                                                                                                                                                    
                    url: "./funciones/mod1_ajax_validar_add_user.php",                                                                                                                                                                                                    
                    data: "nom="+nom+"&dni="+dni+"&per="+per+"&email="+email+"&usu="+usu+"&ape="+ape+"&tel="+tel+"&pas="+pas,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");                   		},
                    success: function(data){ 	$("#mostrar_validar_add_user").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

<!-- AJAX: BUSCAR -->	
<script language="javascript">
	$(document).ready(
		function(){                         
		      var consulta;  
		      var id_emp;  
		      $("#_buscar").keyup(function(e){
	             consulta = $("#_buscar").val(); 
	             id_emp   = $("#id_emp").val(); 
	             $("#resultado_busqueda").delay(700).queue(function(n) {                                                 
	                    $.ajax({
	                          type: "POST",
	                          url: "./funciones/usuario_buscar.php",
	                          data: "b="+consulta+"&id_emp="+id_emp,
	                          dataType: "html",
	                          error: function(){  alert("error petición ajax");        },
	                          success: function(data){                                                      
	                                $("#resultado_busqueda").html(data);   n();
	                          }
	                  });                                           
	             });                                
	     	 });                
});
</script>

<!-- AJAX: BUSCAR PERFILES PARA UNA FUNCION -->	
<script language="javascript">
	$(document).ready(
		function(){                         
		      var consulta;  
		      $("#func").change(function(e){
	             consulta = $("#func").val(); 
	             $("#resultado_busqueda_perfiles").delay(100).queue(function(n) {                                                 
	                    $.ajax({
	                          type: "POST",
	                          url: "./funciones/funciones_buscar.php",
	                          data: "b="+consulta,
	                          dataType: "html",
	                          error: function(){  alert("error petición ajax");        },
	                          success: function(data){                                                      
	                                $("#resultado_busqueda_perfiles").html(data);   n();
	                          }
	                  });                                           
	             });                                
	     	 });                
});
</script>

<!-- AJAX: BUSCAR INDICADORES PARA UN PERFIL -->	
<script language="javascript">
	$(document).ready(
		function(){                         
		      var consulta;  
		      $("#perfil_asoc_indi").change(function(e){
	             consulta = $("#perfil_asoc_indi").val(); 
	             $("#resultado_busqueda_perfil_indicadores").delay(100).queue(function(n) {                                                 
	                    $.ajax({
	                          type: "POST",
	                          url: "./funciones/ajax_buscar_perfiles.php",
	                          data: "b="+consulta,
	                          dataType: "html",
	                          error: function(){  alert("error petición ajax");        },
	                          success: function(data){                                                      
	                                $("#resultado_busqueda_perfil_indicadores").html(data);   n();
	                          }
	                  });                                           
	             });                                
	     	 });                
});
</script>

<!-- PASAR DATOS AL MODAL: MDF CLAVE -->
<script>
$(document).ready(function(){  
	$('#modal_edit_clave').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var id       = button.data('id')    
		  var modal    = $(this)
		  modal.find('.modal-body #id').val(id)
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- PASAR DATOS AL MODAL: Borrar Usuario -->
<script>
$(document).ready(function(){  
	$('#modal_del_user').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var id       = button.data('id')       
		  var nbre     = button.data('nbre')  
		  var modal    = $(this)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #nbre').val(nbre)
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- PASAR DATOS AL MODAL: MDF PERMISOS -->
<script>
$(document).ready(function(){  
	$('#modal_mdf_permiso_perfil').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var idperfil = button.data('idperfil')       
		  var nbre     = button.data('nbre')    
		  var modal    = $(this)
		  modal.find('.modal-body #idperfil').val(idperfil)
		  modal.find('.modal-body #nbre').val(nbre)
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- PASAR DATOS AL MODAL: MDF PERFIL -->
<script>
$(document).ready(function(){  
	$('#modal_edit_perfil').on('show.bs.modal', function (event) {    
		  var button = $(event.relatedTarget)  // Botón que activó el modal
		  var id     = button.data('id')       
		  var perfil = button.data('perfil')       
		  var nbre   = button.data('nbre')       
		  var area   = button.data('area')       
		  var inst   = button.data('inst')       
		  
		  var modal = $(this)
		  modal.find('.modal-body #id').val(id)
		  modal.find('.modal-body #perfil_').val(perfil)
		  modal.find('.modal-body #nbre_').val(nbre)
		  modal.find('.modal-body #area_').val(area)
		  modal.find('.modal-body #inst_').val(inst)
		 
		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!--VALIDACION: AGREGAR & MODIFICAR -->	
<script type="text/javascript" >	
	function validar_mdfClave(){ 
		// Clave
	   	if (document.edit_clave.clave.value.length==0){ 
	      	alert("FALTA CARGAR: Clave")  
	      	return false; 
		}
	}	
	function validar_AddPerfil(){ 
		// Nombre
	   	if (document.addperfil.p_nombre.value.length == 0){ 
	      	alert("FALTA CARGAR: Nombre")  			return false; 
	   	}// Descripcion
	   	if (document.addperfil.p_descripcion.value.length == 0){ 
	      	alert("FALTA CARGAR: Descripcion")     	return false; 
	   	}
	}
	function validar_AgregarUsuario(){ 
		// Usuario
	   	if (document.add_usuario.usuario.value.length == 0){ 
	      	alert("FALTA CARGAR: Usuario")        	return false; 
	   	}// Area
	   	if (document.add_usuario.area.value.length == 0){ 
	   		alert("FALTA CARGAR: Area")     		return false;
	   	}// Institucion
	   	if (document.add_usuario.inst.value.length == 0){ 
	   		alert("FALTA CARGAR: Institucion")     	return false;
	   	}// Clave
	   	if (document.add_usuario.clave.value.length == 0){ 
	      	alert("FALTA CARGAR: Clave")  			return false; 
	   	}// Perfil de usr
	   	if (document.add_usuario.perfil.value == '0'){ 
	   		alert("FALTA CARGAR: Perfil")  	      	return false;
	   	}   
	}
	function aux_validarFormatoFecha(campo) {
      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
	}
	function aux_existeFecha(fecha){
      var fechaf= fecha.split("/");
      var day   = fechaf[0];
      var month = fechaf[1];
      var year  = fechaf[2];
      var date  = new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;
	}		
	function validar_Modificar(){ 
		// Origen
	   	if (document.edit_nota_secretaria.sino_mdf_origen.value=='si'){ 
	      	if (document.edit_nota_secretaria.sel_origen.value=='0'){ 
	      		alert("ERROR: Elija Origen")  
	      		return false; 
	      	}else{
				if (document.edit_nota_secretaria.sel_origen.value=='nuevo'){ 
					if (document.edit_nota_secretaria.sel_origen_add.value.length=='0'){ 
						alert("FALTA CARGAR: nuevo Origen")  
	      				return false; 
					}	
				}
			}
	   	} 
	   	// Destino
	   	if (document.edit_nota_secretaria.sino_mdf_destino.value=='si'){ 
	      	if (document.edit_nota_secretaria.sel_destino.value=='0'){ 
	      		alert("ERROR: Elija Destino")  
	      		return false; 
	      	}else{
				if (document.edit_nota_secretaria.sel_destino.value=='nuevo'){ 
					if (document.edit_nota_secretaria.sel_destino_add.value.length=='0'){ 
						alert("FALTA CARGAR: nuevo Destino")  
	      				return false; 
					}	
				}
			}
	   	} 
	   	// Tema
	   	if (document.edit_nota_secretaria.tema.value.length==0){ 
	      	alert("FALTA CARGAR: Tema")  
	      	return false; 
	   	}
	}
	function validar_Eliminar(){ 
		alert("Esta seguro que desea eliminar un registro")  
	}
</script>

<!-- AJAX: COMPRUEBO SI EL PERFIL EXISTE EN LA DB -->	
<script language="javascript">
$(document).ready(function(){                         
      var consulta;             
      //hacemos focus
      $("#p_nombre").focus();                                                 
      //comprobamos si se pulsa una tecla
      $("#p_nombre").keyup(function(e){
             //obtenemos el texto introducido en el campo
             consulta= $("#p_nombre").val();                                      
             id_cli  = $("#id_cli").val();                                      
             //hace la búsqueda
             $("#comprobar_existe_perfil").delay(5).queue(function(n) {                                                 
                    $.ajax({
                          type: "POST",
                          url: "./funciones/usuario_comprobar_existe_perfil.php",
                          data: "b="+consulta+"&id_cli="+id_cli,
                          dataType: "html",
                          error: function(){   alert("error petición ajax");       },
                          success: function(data){                                                      
                                $("#comprobar_existe_perfil").html(data);
                                n();
                          }
                  });                                           
             });                                
      });  
                      
});
</script>

<SCRIPT type="text/javascript" >
	$(document).ready(function() {
		$("#dt").dataTable({
			"order": [ 0, "desc" ]
		});
		$("#dt2").dataTable({
			"order": [ 1, "desc" ],
			"bPaginate": false,
		});
        $("#fentrada").datepicker({
			dateFormat: 'dd/mm/yy', // formato de fecha que se usa en España
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'], dayNamesMin: ['D', 'L', 'M', 'X', 'J', 'V', 'S'], 
			dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'], firstDay: 1, maxDate: "+2Y", minDate: '-2y',monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], // meses
			monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], navigationAsDateFormat: true,
        });          
});
</SCRIPT>	

<!-- MOSTRAR Y OCULTAR CAMPOS SEGUN LO QUE SE SELECCIONE-->	
<script language="javascript">
	// Agregar
	function entrada_origen_add(selectTag){
	 	if(selectTag.value == 'nuevo' ){
			document.getElementById('mostrar_new_entrada_origen_add').hidden = false;	
		}else{
			document.getElementById('mostrar_new_entrada_origen_add').hidden = true;		
		}	 		
	}
	function entrada_destino_add(selectTag){
	 	if(selectTag.value == 'nuevo' ){
			document.getElementById('mostrar_new_entrada_destino_add').hidden = false;	
		}else{
			document.getElementById('mostrar_new_entrada_destino_add').hidden = true;		
		}	 		
	}
	
	// Editar
	function mdf_origen_edit(selectTag){
	 	if(selectTag.value == 'si' )
			document.getElementById('select_origen_edit').hidden = false;
	 	else
	 		document.getElementById('select_origen_edit').hidden = true;
	}
	function entrada_origen_edit(selectTag){
	 	if(selectTag.value == 'nuevo' )
			document.getElementById('add_select_origen_edit').hidden = false;
	 	else
	 		document.getElementById('add_select_origen_edit').hidden = true;
	}
	function mdf_destino_edit(selectTag){
	 	if(selectTag.value == 'si' )
			document.getElementById('select_destino_edit').hidden = false;
	 	else
	 		document.getElementById('select_destino_edit').hidden = true;
	}
	function entrada_destino_edit(selectTag){
	 	if(selectTag.value == 'nuevo' )
			document.getElementById('add_select_destino_edit').hidden = false;
	 	else
	 		document.getElementById('add_select_destino_edit').hidden = true;
	}
		
</script>

<!-- AJAX: COMPRUEBO SI EL USUARIO YA EXISTE EN LA DB -->	
<script language="javascript">
$(document).ready(function(){                         
      var consulta;             
      //hacemos focus
      $("#usuario").focus();                                                 
      //comprobamos si se pulsa una tecla
      $("#usuario").keyup(function(e){
             //obtenemos el texto introducido en el campo
             consulta = $("#usuario").val();                                      
             //hace la búsqueda
             $("#comprobar_usuario").delay(10).queue(function(n) {                                                 
                    $.ajax({
                          type: "POST",
                          url: "./funciones/usuario_comprobar_existe_usuario.php",
                          data: "b="+consulta,
                          dataType: "html",
                          error: function(){
                                alert("error petición ajax");
                          },
                          success: function(data){                                                      
                                $("#comprobar_usuario").html(data);
                                n();
                          }
                  });                                           
             });                                
      });                
});
</script>

<!-- AJAX: COMPRUEBO SI EL DNI YA EXISTE EN LA DB -->	
<script language="javascript">
$(document).ready(function(){                         
      var consulta;             
      //hacemos focus
      $("#dni").focus();                                                 
      //comprobamos si se pulsa una tecla
      $("#dni").keyup(function(e){
             //obtenemos el texto introducido en el campo
             consulta = $("#dni").val();                                      
             //hace la búsqueda
             $("#comprobar_dni_usuario").delay(10).queue(function(n) {                                                 
                    $.ajax({
                          type: "POST",
                          url: "./funciones/usuario_comprobar_existe_dni_usuario.php",
                          data: "b="+consulta,
                          dataType: "html",
                          error: function(){
                                alert("error petición ajax");
                          },
                          success: function(data){                                                      
                                $("#comprobar_dni_usuario").html(data);
                                n();
                          }
                  });                                           
             });                                
      });                
});
</script>

<!-- MSJ: Espere unos segundos -->
<script type="text/javascript">
	function mostrarMsjBtn_mdfPermisos(){ document.getElementById('msjBtn_mdfPermisos').style.display = 'block';	}
	function mostrarMsjBtn_addPerfil(){   document.getElementById('msjBtn_addPerfil').style.display = 'block'; 		}
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
                        
                                        <nav class="breadcrumb-style-five" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="principal.php" title="Dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="inner-text"></span></a></li>
                                                <li class="breadcrumb-item"> Administración </li>
                                                <li class="breadcrumb-item active" aria-current="page"> Usuarios 2</li>
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
                                        <button data-bs-toggle="modal" data-bs-target="#modal_add_perfil" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar nuevo Perfil" ><i class="bi bi-person-vcard" style="font-size: 1rem;"></i></button>
                                        <button data-bs-toggle="modal" data-bs-target="#modal_add_usuario" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar nuevo Usuario" ><i class="bi bi-person-plus" style="font-size: 1rem;"></i></button>
                                    <?php } ?> 
                                    <br/>                               
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Agregar User -->
                    <div id="modal_add_usuario" class="modal animated fadeInDown" tabindex="-1" role="dialog" >
                    <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-plus-circle" style="font-size: 1rem;"></i> Agregar Usuario </h6></div>

                            <form name="add_user" id="add_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					

                                    <div class="form-group-sm">                                    
                                        <div class="row">
                                            <div class="col-md-2" > 
                                                <label>Nombre:<span class="mandatory">*</span></label>   
                                                <input type="text"   id="nom"    name="nom"    class="form-control form-control-sm" required tabindex="1"/>								   	 	                                                								   	 	
                                            </div>
                                            <div class="col-md-2" >
                                                <label>Apellido:<span class="mandatory">*</span></label>
                                                <input type="text" id="ape" name="ape" class="form-control form-control-sm" tabindex="2" required/>				
                                            </div>  
                                            <div class="col-md-2" >
                                                <div id="comprobar_dni_usuario"><label>DNI:<span class="mandatory">*</span></label></div>
                                                <input type="number" id="dni" name="dni" class="form-control form-control-sm" tabindex="3" required/>			
                                            </div>  
                                            <div class="col-md-4" >
                                                <label>Email:<span class="mandatory">*</span></label>
                                                <input type="email" id="email" name="email" class="form-control form-control-sm" tabindex="4" required/>				
                                            </div> 
                                            <div class="col-md-2" >
                                                <label>Telefono:<span class="mandatory">*</span></label>
                                                <input type="number" id="tel" name="tel" class="form-control form-control-sm" tabindex="5" required />				
                                            </div> 
                                        </div>
                                    </div><br />    

                                    <div class="form-group-sm">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Perfil:</label>
                                                <select id="perfil" name="perfil" class="form-select perfil form-control-sm" tabindex="6"><?php
                                                    for ($i = 0; $i < count($arr_perfil); $i++)
                                                        echo '<option value="'.$arr_perfil[$i]['id'].'"'.'>'.utf8_encode($arr_perfil[$i]['nombre'])."</option>\n";?>	
                                                </select>
                                            </div>
                                            <div class="col-md-3" >
                                                <div id="comprobar_usuario"><label>Usuario:<span class="mandatory">*</span></label></div>
                                                <input id="usuario" name="usuario" class="form-control form-control-sm" tabindex="7" required/>								   	 	
                                            </div>
                                            <div class="col-md-3" >
                                                <label>Clave:<span class="mandatory">*</span></label>
                                                <input id="clave" name="clave" class="form-control form-control-sm" value="" tabindex="8" required/>			
                                            </div> 
                                        </div>
                                    </div><br /> 

                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="9">Cancelar</button>		                                    
                                    <button id="validar_add_user" name="validar_add_user" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="10" > Agregar </button>
                                    <br /><br />
                                    <div id="mostrar_validar_add_user" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>
                    
                     <!-- Modal: Agregar Perfil -->
                     <div id="modal_add_perfil" class="modal animated fadeInDown" tabindex="-1" role="dialog" >
                    <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-plus-circle" style="font-size: 1rem;"></i> Agregar Perfil </h6></div>

                            <form name="add_perfil" id="add_perfil" class="form-horizontal validate" method="post" action="./funciones/usuario_perfil_add.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					

                                <div class="form-group-sm">
                                    <div class="row">
                                        <div class="col-md-4">  
                                            <div id="comprobar_existe_perfil"><label>Nombre:</label></div>
                                            <input type="text"   id="p_nombre" name="p_nombre" class="form-control form-control-sm" required> 
                                            <input type="hidden" id="id_cli"   name="id_cli"   value="<?php echo $id_empresa_logueada ?>" > 
                                        </div>	
                                        <div class="col-md-8">
                                            <label>Descripcion:</label>
                                            <input type="text" id="p_descripcion" name="p_descripcion" class="form-control form-control-sm" >
                                        </div>									  								
                                    </div>
                                </div><br />   

                                <div id="Funciones" class="panel panel-default">
                                    <div class="panel-heading" align="center"><h6 class="panel-title"><i class="icon-table"></i><?php echo "Funciones del Sistema:" ?></h6>
                                </div><br/><?php
                                
                                echo '<div class="table-responsive">
                                    <table class="table table-striped table-bordered">'.
                                        "<thead><tr class=\"rowHeaders\">			
                                                <th style='text-align:center'> Asignar     </th>
                                                <th style='text-align:center'> Modulo      </th>
                                                <th style='text-align:center'> Funcion	   </th>
                                                <th style='text-align:center'> Alta	       </th>
                                                <th style='text-align:center'> Baja	       </th>
                                                <th style='text-align:center'> Modificar   </th>
                                                <th style='text-align:center'> Descripcion </th>".
                                        "</tr></thead><tbody>";				
                                for($j=0 ; is_array($arr_func) && $j<count($arr_func) ; $j++){
                                    $cur = $arr_func[$j];
                                    
                                    echo "<tr class=\"cellColor" . ($i%2)  . "\" align=\"center\" id=\"tr$i\">\n"
                                        . '<td style="text-align:center">' . '<input name="chek[]" id="chek[]" value="'.$cur["f"].'" type="checkbox" class="form-check-input chk-parent" > '. "</td>\n"
                                        . '<td style="text-align:center">' . $cur['nbre_m']      . "</td>\n"
                                        . '<td style="text-align:center">' . utf8_encode($cur['nbre_f'])      . "</td>\n"
                                        . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-A" name="'.$cur["f"].'-A" value="1" type="checkbox" class="form-check-input chk-parent" > '. "</td>\n"
                                        . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-B" name="'.$cur["f"].'-B" value="1" type="checkbox" class="form-check-input chk-parent" > '. "</td>\n"
                                        . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-M" name="'.$cur["f"].'-M" value="1" type="checkbox" class="form-check-input chk-parent" > '. "</td>\n"
                                        . '<td style="text-align:left">'   . $cur['descripcion'] . "</td>\n"
                                        . "</tr>\n";						
                                }                                                
                                echo "</tbody></table></div>";?>	                                                       
                                                                        
                                </div>	
                                </div>  

                                <div class="modal-footer"><center>							
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> Cerrar </button>
                                    <button type="submit" id="add_us" name="add_us" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_addPerfil()" title="Presione el botón para agregrar el registro." > Agregar </button>
                                    <br /><br />
                                    <div id="msjBtn_addPerfil" style='display:none;' ><img src="images/loading.gif" width="30px" height="30px" alt="loading"/><?php echo '   <font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar Permisos a Perfil -->
                    <div id="modal_mdf_permiso_perfil" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-pencil" style="font-size: 1rem;"></i> Modificar Permisos a Perfil </h6></div>

                            <form name="form_mdf_permiso_perfil" id="form_mdf_permiso_perfil" class="form-horizontal validate" method="post" action="./_admin_usuarios_permisos_perfil.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row" align="center">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div><label>Perfil actual:</label></div>
                                                <input type="text"   id="nbre"     name="nbre" class="form-control form-control-sm" readonly='readonly'/>				                                							
                                                <input type="hidden" id="idperfil" name="idperfil"                         	 />  
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

                    <!-- Modal: Modificar Clave -->
                    <div id="modal_edit_clave" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-pencil" style="font-size: 1rem;"></i> Modificar clave </h6></div>

                            <!-- Form --> 
                            <form name="edit_clave" id="edit_clave" class="form-horizontal validate" method="post" action="./funciones/usuario_mdf_clave.php" onsubmit='return validar_mdfClave()' enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div id="comprobar_entrada"><label>nueva clave:</label></div>
                                                <input type="password" id="clave" name="clave" class="form-control form-control-sm" value="" >				                                							
                                                <input type="hidden"   id="id"    name="id"                                 />  
                                            </div>	
                                            <div class="col-md-2"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer"><center>							
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> Cerrar </button>
                                    <button type="submit" id='submit' name="submit" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_mdfPass()" title="Presione el botón para modificar el registro." > Cambiar </button>
                                    <br /><br />
                                    <div id="msjBtn_mdfPass" style='display:none;' ><img src="images/loading.gif" width="30px" height="30px" alt="loading"/><?php echo '   <font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>
                                    
                            </form>

                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar Perfil -->
                    <div id="modal_edit_perfil" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-pencil" style="font-size: 1rem;"></i> Modificar Perfil de Usuario </h6></div>

                            <!-- Form -->
                            <form name="edit_perfil" id="edit_perfil" class="form-horizontal validate"  method="post"  action="./funciones/usuario_edit_perfil.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    
                                <div class="form-group-sm">  
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Persona:</label><input id="nbre_" name="nbre_" class="form-control form-control-sm" readonly="readonly" />					                                
                                            <input type="hidden" name="id" id="id"/>
                                            <input type="hidden" name="usuario_login" id="usuario_login" value="<?php echo $datos['id'] ?>"/> 
                                        </div> 
                                        <div class="col-md-4" >
                                            <label>nuevo Perfil:</label>
                                            <select id="perfil_new" name="perfil_new" class="form-select form-control-sm" ><?php
                                            for ($i = 0; $i < count($arr_perfil); $i++)
                                                echo '<option value="'.$arr_perfil[$i]['id'].'"'.'>'.utf8_encode($arr_perfil[$i]['nombre'])."</option>\n";?>
                                            </select>
                                        </div> 								
                                    </div>
                                </div><br /> 							                     
                                    
                                </div>		

                                <div class="modal-footer"><center>							
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> Cerrar </button>
                                    <button type="submit" name="Submit" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_mdfPerfil()" title="Presione el botón para modificar el registro." > Modificar </button>
                                    <br /><br />
                                    <div id="msjBtn_mdfPerfil" style='display:none;' ><img src="images/loading.gif" width="30px" height="30px" alt="loading"/><?php echo '   <font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>

                            </form>
                            

                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal: Borrar User -->
                    <div id="modal_del_user" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-trash" style="font-size: 1rem;"></i> Borrar Usuario </h6></div>


                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="./funciones/usuario_del.php" onsubmit='return validar_mdfClave()' enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <div id="comprobar_entrada"><label>Persona:</label></div>
                                                <input type="text"    id="nbre" name="nbre" class="form-control form-control-sm" readonly >				                                							
                                                <input type="hidden"  id="id"    name="id"                                 />  
                                            </div>	
                                            <div class="col-md-2"></div>
                                        </div>								
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer"><center>							
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> Cerrar </button>
                                    <button type="submit" name="Submit" class="btn btn-danger" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_mdfPass()" title="Presione el botón para modificar el registro." > Borrar </button>
                                    <br /><br />
                                    <div id="msjBtn_mdfPass" style='display:none;' ><img src="images/loading.gif" width="30px" height="30px" alt="loading"/><?php echo '   <font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>
                                    
                            </form>

                            </div>
                        </div>
                    </div>                    

                    <!-- Modal: Info -->
                    <div id="modal_info" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-info-circle" style="font-size: 1rem;"></i> Información </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <label> La función permite administrar los usuarios del sistema. </label>
                                            <br/><br/>
                                            <label><b>* Alta de Perfiles:</b> permite crear nuevos perfiles. Asocia un grupo de funciones con un nombre especifico.</label>
                                            <label><b>* Alta de Usuarios:</b> permite crear nuevos usuarios. </label>
                                            <label><b>* Mdf Permisos:</b> Cambia los permisos para el perfil de un usuario elegido. </label>
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

                    <!-- DATATABLE -->
                    <div class="row layout-top-spacing">                    
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        
                            <div class="widget-content widget-content-area br-8">
                                <table id="dt_" class="table dt-table-hover" style="width:100%">
                                    
                                    <?php
                                        $tabla= "<thead><tr class=\"rowHeaders\">			
                                                <th style='text-align:center'> Estado       </th>
                                                <th style='text-align:center'> Nombre       </th>
                                                <th style='text-align:center'> Perfil	    </th>
                                                <th style='text-align:center'> Usuario	    </th>
                                                <th style='text-align:center'> Mdf Permisos </th>
                                                <th style='text-align:center'> Mdf Clave    </th>
                                                <th style='text-align:center'> Mdf Perfil   </th>
                                                <th style='text-align:center'> Borrar	    </th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($datos) && $j<count($datos) ; $j++){
                                            $cur  = $datos[$j];
                                        
                                            switch($cur['tipo']){
                                                case '1': 	$tipo ='Administrativo';			
                                                            $nbre = utf8_encode($cur['nbre_c']);		
                                                            if( $cur['estado_user']== 1)	$estado= '<Font COLOR="green">'.'Activo'.'</Font>';
                                                            else							$estado= '<Font COLOR="red">'.'Baja'.'</Font>';
                                                            break;		
                                                                            
                                                default : 	$tipo  ='Error';	
                                                            $nbre  = '';
                                                            $estado= '<Font COLOR="red">'.'Error'.'</Font>';
                                                            break;						
                                            }

                                            $btn_mdf_perfil= '<td style="text-align:center">
                                                            <button data-bs-toggle="modal" data-bs-target="#modal_edit_perfil"  
                                                            data-id="'.$cur['id'].'" data-perfil="'.utf8_encode($cur['perfil']).'" data-nbre="'.utf8_encode($cur['nbre_c']).'"
                                                            class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar Perfil para el Usuario" >
                                                            <i class="bi bi-person-vcard" style="font-size: 1rem;"></i>
                                                            </button>'.
                                                        "</td>\n";	

                                            $btn_del=   '<td style="text-align:center">
                                                            <button data-bs-toggle="modal" data-bs-target="#modal_del_user"  
                                                            data-id="'.$cur['id'].'" data-perfil="'.utf8_encode($cur['perfil']).'" data-nbre="'.utf8_encode($cur['nbre_c']).'"
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Borrar Usuario" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                            </button>'.
                                                        "</td>\n";	

                                            $btn_mdf_pass = '<button data-bs-toggle="modal" data-bs-target="#modal_edit_clave" 
                                                           data-id="'.$cur['id'].'" 
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar contraseña para el Usuario">
                                                           <i class="bi bi-key" style="font-size: 1rem;"></i>
                                                        </button>';

                                            $btn_mdf_permisos = '<button data-bs-toggle="modal" data-bs-target="#modal_mdf_permiso_perfil" 
                                                        data-idperfil="'.$cur['idperfil'].'" data-nbre="'.utf8_encode($cur['perfil']).'"
                                                        class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar permisos de un Perfil">
                                                        <i class="bi bi-ui-checks-grid" style="font-size: 1rem;"></i>
                                                     </button>';

                                            if($baja == '1') { $btn_del_mostrar= $btn_del;                  } else {  $btn_del_mostrar= '';      }
                                            if($modf == '1') { $btn_mdf_perf_mostrar= $btn_mdf_perfil;      } else {  $btn_mdf_perf_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_perm_mostrar= $btn_mdf_permisos;    } else {  $btn_mdf_perm_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_pass_mostrar= $btn_mdf_pass;        } else {  $btn_mdf_pass_mostrar= ''; }

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">' . $estado                     . "</td>\n"
                                            . '<td style="text-align:center">' . $nbre                       . "</td>\n"
                                            . '<td style="text-align:center">' . utf8_encode($cur['perfil']) . "</td>\n"
                                            . '<td style="text-align:center">' . utf8_encode($cur['login'])  . "</td>\n"
                                            . '<td style="text-align:center">' . $btn_mdf_perm_mostrar       . "</td>\n"
                                            . '<td style="text-align:center">' . $btn_mdf_pass_mostrar       . "</td>\n"
                                            . $btn_mdf_perf_mostrar
                                            . $btn_del_mostrar
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
            "lengthMenu": [10, 20, 50],
            "pageLength": 5 
        });
    </script>

    <!-- Iconos Feather -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    feather.replace()
    </script>

    <!-- Pone foco en el primer componente del Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalAddPerfil = document.getElementById('modal_add_perfil');
            modalAddPerfil.addEventListener('shown.bs.modal', function () {   document.getElementById('p_nombre').focus();          });
            
            var modalAddUser = document.getElementById('modal_add_usuario');
            modalAddUser.addEventListener('shown.bs.modal', function () {   document.getElementById('nom').focus();                 });
            
            var modalUpdClave = document.getElementById('modal_edit_clave');
            modalUpdClave.addEventListener('shown.bs.modal', function () {   document.getElementById('clave').focus();              });
            
            var modalUpdPerfil = document.getElementById('modal_edit_perfil');
            modalUpdPerfil.addEventListener('shown.bs.modal', function () {   document.getElementById('nbre_').focus();              });
        });
    </script>           

    <?php 
	    require_once('./estructura/buscador_barra.php');
	?> 

</body>
</html>

