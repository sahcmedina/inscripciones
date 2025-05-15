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
	
    $arr_conf = array();
	$arr_conf = $Con->gets_all_conferencias();
    $id_user  = $U->get_id( $login);

?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>
    
<!-- AJAX: BUSCAR -->	
<script language="javascript">
$(document).ready(function(){                         
    var consulta;  var evento;
    $("#inscriptos").change(function(e){
        consulta = $("#inscriptos").val();
        evento   ='C'; 
        $("#resultado_busqueda").delay(700).queue(function(n) {                                                 
            $.ajax({
            type: "POST",
            url: "./funciones/ajax_buscar_inscriptos.php",
            data: "b="+consulta+"&e="+evento,
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
                            <a href="./principal.php" class="nav-link">  </a>
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
                                                <li class="breadcrumb-item">Conferencias</li>
                                                <li class="breadcrumb-item active" aria-current="page">Inscriptos</li>
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
                                            <center><label><i class="icon-warning"></i> La función permite administrar los inscriptos a una Conferencia </label></center>
                                        </div><br>
                                    </div><br /> 
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="1">Cerrar</button>		                                                                        
                                </div></center> 
                                    
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
                                    <strong> <h6> Listado de Inscriptos a una Conferencia </h6> </strong> 
                                </div>
                            </div>
                            <div class="alert-btn">
                                <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4 btn-sm" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <label for="inscriptos">Seleccione una Conferencia para ver los Inscriptos</label>
                            <select id="inscriptos" name="inscriptos" class="form-select form-control-sm" tabindex="1" required>
                                <?php
							        echo '<option value="0" >Elija..</option>';
							        for ($i = 0; $i < count($arr_conf); $i++)
								        echo '<option value="'.$arr_conf[$i]['fk_evento'].'"'.'>' .$arr_conf[$i]['titulo']. "</option>\n";
							    ?>	  
                            </select>
                        </div>
                    </div>
                    <br>
                    
                    <br>
				
				    <div id="resultado_busqueda">
                        <!-- DATATABLE -->
                    </div>
				    <br>
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

