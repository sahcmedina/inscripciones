<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');
    $rutaImagen = './foto_perfil/'.$datos[0]['id'].'.png';
    $_SESSION['img_perfil'] = $datos[0]['id'];
    $nbre_perfil = $datos[0]['nombre'].''.$datos[0]['apellido'];
?>

<!DOCTYPE html><html lang="es">

<head>

    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>       

</head>

<style>
.img{
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    display: flex; /* Para centrar la imagen */
    justify-content: center; /* Centrar la imagen horizontalmente */
    align-items: center; /* Centrar la imagen verticalmente */
}
</style>

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
                                                <li class="breadcrumb-item active" aria-current="page"> Perfil </li>
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
                        
                            <div class="widget-content widget-content-area br-12">

                                <br/>
                                <div class="panel-heading"><h7 class="panel-title"><i class="icon-table"></i><center><?php echo ' Foto de Perfil:  <b>'.$nbre_perfil.'</b> ' ?></center></h7>
                                <br/>

                                <div class="modal-content">
                                <div class="row">
                                    <!-- <div class="col-md-6 "></div>       -->
                                    <div class="col-md-12 "> <center>
                                        <?php if ($rutaImagen != ''){ ?>
                                            <img id="imgPreview" class="img" src="<?php echo $rutaImagen; ?>" >
                                        <?php } else { ?>
                                            <img id="imgPreview" class="img" >
                                        <?php }?>
                                        </center>
                                    </div> <br>
                                </div><br>    
                                
                                <form name="add_dep" id="add_dep" class="form-horizontal validate" method="post" action="./funciones/usuario_mdf_foto_perfil.php" enctype="multipart/form-data" >
                                    <div class="row">
                                        <div class="col-xl-3 col-md-12 col-md-1"></div>
                                        <div class="col-xl-9 col-md-12 col-md-10">
                                            <label for=""> Si desea cambiar la foto de perfil, haga clic en "Seleccionar Archivo" y luego en "Modificar" </label>
                                        </div>
                                    </div>        
                                    <div class="row">
                                            <div class="col-xl-5 col-lg-12 col-md-4"></div>      
                                            <div class="col-xl-2 col-lg-12 col-md-4">
                                                <div class="profile-image  mt-4 pe-md-4">                        
                                                    <div class="img-uploader-content">            
                                                        <input type="file" name="url_" id="url_" accept="image/png, image/jpeg, image/gif" onchange="previewImage(event, '#imgPreview')"/>
                                                    </div>                        
                                                </div><br/>
                                            </div>
                                    </div>

									<div class="modal-footer d-flex justify-content-center"><br /><br /><br />
                                        <center>
                                            <button type="button" id="cancelar_add" name="cancelar_add" class="btn btn-dark" onclick="window.location.href='./principal.php'">Cancelar</button>
                                            <button type="submit" id="validar_add" name="validar_add" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_add_p1()" title="Se va a cambiar la foto de perfil.">Modificar</button>
                                            <br> <br>
                                            <div id="msjBtn_add_p1" style="display:none;" ><img src="images/loading.gif" width="35px" height="35px" alt="loading"/><?php echo "<font color=grey><b><i>"."Por favor, espere unos segundos.."."</b></i></font>"; ?></div>       
                                        </center>
                                    </div><br>
                                </form>

                                </div>
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

    <!-- Mostrar imagen del perfil en miniatura -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Configurar FilePond
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginFileValidateType
        );
        
        const pond = FilePond.create(document.querySelector('.filepond'), {
            stylePanelAspectRatio: 1, // Hace que el panel sea cuadrado
            imageCropAspectRatio: 1, // Hace que la imagen recortada sea cuadrada
            imagePreviewHeight: 170,
            imagePreviewWidth: 170,
            stylePanelLayout: 'compact circle', // Intenta aplicar un estilo circular
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'center bottom'
        });
        
        <?php if (file_exists($rutaImagen)): ?>
            // Añadir el archivo existente
            pond.addFile('<?php echo $rutaImagen; ?>');
        <?php endif; ?> 

        // Seleccionar el elemento input
        const inputElement = document.querySelector('input[type="file"].filepond');
        
        // Crear la instancia de FilePond
        const pond = FilePond.create(inputElement, {
            allowMultiple: false,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            labelIdle: 'Arrastra tu imagen o <span class="filepond--label-action">Busca</span>',
            // Importante: Esto asegura que FilePond envíe el archivo con el mismo nombre que tu PHP espera
            name: 'url_',
            // FilePond no enviará el formulario automáticamente
            instantUpload: false
        });
        
        // Evento para cuando se envía el formulario
        document.getElementById('add_dep').addEventListener('submit', function(e) {
            // Si no hay archivo seleccionado, evita el envío
            if (pond.getFiles().length === 0) {
                e.preventDefault();
                alert('Por favor selecciona una imagen');
            }
            // Si hay archivo, el formulario se enviará normalmente
        });
    });
    </script>

    <script src="./funciones/mostrar_img_perfil.js"></script>

    <!-- MSJ: Espere unos segundos -->
<script type="text/javascript">
	function mostrarMsjBtn_add_p1(){ 
        document.getElementById('msjBtn_add_p1').style.display = 'block'; // muestra el la frase aguerde....
        document.getElementById('cancelar_add').style.display = 'none'; // boton cancelar lo hago desaparecer
    }
</script>

</body>
</html>

