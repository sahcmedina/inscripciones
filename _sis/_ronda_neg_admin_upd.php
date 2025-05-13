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
    $id_user = $U->get_id( $login);

	if (isset($_POST["id_rn"])) 	 {$id_rn  = $_POST["id_rn"];      } else {$id_rn  ='';  }	
	if (isset($_POST["nombre"])) 	 {$nombre = $_POST["nombre"];     } else {$nombre ='';  }
    
    $arr_prod= array();
    $arr_prod= $Productos->gets();

	$arr_    = array();
	$arr_    = $RondaNeg->gets_id($id_rn);
    list($hh, $mm, $ss) = explode(':', $arr_[0]['hora']);
    $hora    = $hh.':'.$mm;
    list($d_f, $d_hs) = explode(' ', $arr_[0]['f_inscrip_dsd']);
    $dsd     = $d_f;
    list($h_f, $h_hs) = explode(' ', $arr_[0]['f_inscrip_hst']);
    $hst     = $h_f;
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
                            <a href="./principal.php" class="nav-link"> Inscripciones </a>
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
                                                <li class="breadcrumb-item"><a href="_ronda_neg_admin.php" title="ir">Administración</a></li>
                                                <li class="breadcrumb-item active" aria-current="page"> Actualización </li>
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
                        
                        <div class="modal-content">

                                <br/>
                                <form name="mdf_reg" id="mdf_reg" class="form-horizontal validate" method="post" action="./funciones/mod3_ronda_neg_upd.php" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">                                    					
                                    <div class="form-group-sm">

                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Nombre: <span class="mandatory">*</span></label>   
                                                <input type="text" id="nombre"    name="nombre" class="form-control form-control-sm" tabindex="1" value="<?php echo $arr_[0]['nombre'] ?>" required>
                                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $id_user ?>" >
                                                <input type="hidden" id="id_"     name="id_" value="<?php echo $id_rn ?>" >
                                            </div>
                                            <div class="col-md-5"> 
                                                <label>Lugar: <span class="mandatory">*</span></label>   
                                                <input type="text" id="lugar_" name="lugar_" class="form-control form-control-sm" value="<?php echo $arr_[0]['lugar'] ?>" tabindex="2" required>
                                            </div> 
                                            <div class="col-md-2"> 
                                                <label>Hs: <span class="mandatory">*</span></label>   
                                                <input type="time" id="hs_" name="hs_" class="form-control form-control-sm" value="<?php echo $hora ?>" tabindex="3" required>
                                            </div> 
                                        </div><br/>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Inscripcion desde: <span class="mandatory">*</span></label>   
                                                <input type="date" id="dsd_" name="dsd_" class="form-control form-control-sm" value="<?php echo $dsd ?>" tabindex="6" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Inscripcion hasta: <span class="mandatory">*</span></label>   
                                                <input type="date" id="hst_" name="hst_" class="form-control form-control-sm" value="<?php echo $hst ?>" tabindex="7" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Fecha 1: <span class="mandatory">*</span></label>   
                                                <input type="date" id="f1_" name="f1_" class="form-control form-control-sm" value="<?php echo $arr_[0]['f_dia_1'] ?>" tabindex="4" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Fecha 2: </label>   
                                                <input type="date" id="f2_" name="f2_" class="form-control form-control-sm" value="<?php echo $arr_[0]['f_dia_2'] ?>" tabindex="5">
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
                                                                <?php 
                                                                $id_prod= $cur['id'];
                                                                $esta   = $RondaNeg->tf_existe_producto_elegido($id_rn, $id_prod);
                                                                if($esta)  $elejida= 'checked'; else $elejida= '';
                                                                ?>                                                            
                                                                <input 
                                                                    type="checkbox" name="chek[]" id="chek[]" value="<?php echo $id_prod ?>" <?php echo $elejida ?>
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

                                <!-- <div class="modal-footer"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="8">Cancelar</button>		                                    
                                    <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="9"> Modificar </button>
                                    <br/><br/>
                                    <div id="mostrar_validar_upd" ></div> 
                                </div></center> -->

                                <div class="modal-footer" style="display: flex; justify-content: center; align-items: center; flex-direction: column;"><center><br/>								
                                    <button type="button" onclick="history.back()" class="btn btn-dark" data-bs-dismiss="modal" tabindex="8"> Volver </button>		                                    
                                    <button type="submit" id="Submit" name="Submit" class="btn btn-success" tabindex="9" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_upd()" title="Presione el botón para agregar actualizar los permisos." > Modificar </button>
                                    <br /><br />
                                    <div id="msjBtn_upd" style='display:none;' ><img src="images/loading.gif" width="35px" height="35px" alt="loading"/><?php echo '<font color=grey><b><i>'.'Por favor, espere unos segundos..'.'</b></i></font>'; ?></div>
                                </div></center>

                            </form>

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

    <!-- Pone foco en el primer componente del Formulario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Poner foco en el campo 'nombre' cuando la página termine de cargar
            document.getElementById('nombre').focus();
        });
    </script>

</body>
</html>

