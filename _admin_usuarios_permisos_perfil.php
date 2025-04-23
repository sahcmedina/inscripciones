<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
		
	// ------------------------------ FUNCION ------------------------------ //		
	$arr_sino   = array('no','si');
	
	// recibo el id del perfil
	$idperfil   = $_POST['idperfil'];	
	$arr_funcion= array();
	$arr_funcion= $U->gets_funciones_segun_perfil($idperfil, $id_empresa_logueada);
	$nbre_perfil= $U->get_nbre_perfil($idperfil);
?>

<!DOCTYPE html><html lang="es">

<head>

    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>       

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
                                                <li class="breadcrumb-item"> Administración </li>
                                                <li class="breadcrumb-item"><a href="_admin_usuarios.php" title="ir">Usuarios</a></li>
                                                <li class="breadcrumb-item active" aria-current="page"> Actualización de permisos </li>
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
                    
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        
                            <div class="widget-content widget-content-area br-8">

                                <br/>
                                <div class="panel-heading"><h7 class="panel-title"><i class="icon-table"></i><center><?php echo ' Permisos del Perfil:  <b>'.$nbre_perfil.'</b> ' ?></center></h7>
                                <br/>

                                <form id="editar_permisos" class="form-horizontal validate" method="post" action="./funciones/usuario_perfil_edit.php"  role="form">	                                        
                                <div class="table-responsive">		                
                                    <table class="table table-striped table-bordered">
								    <?php 
								
										$tabla= "<thead><tr class=\"rowHeaders\">			
									 		<th style='text-align:center'> Asignar     </th>
									 		<th style='text-align:center'> Modulo      </th>
				                            <th style='text-align:center'> Funcion	   </th>
				                            <th style='text-align:center'> Alta	       </th>
				                            <th style='text-align:center'> Baja	       </th>
				                            <th style='text-align:center'> Modificar   </th>
				                            <th style='text-align:center'> Descripcion </th>";
										$tabla.="</tr></thead><tbody>";			
										echo $tabla;								
										for($j=0 ; is_array($arr_funcion) && $j<count($arr_funcion) ; $j++){
											$cur  = $arr_funcion[$j];										
											$accion = "";
											
											if($cur["nbre_perf"] != '')       $elejida= 'checked'; 	  else    $elejida= '';
											if($cur["alta"] == '1')           $alta   = 'checked'; 	  else    $alta   = '';
											if($cur["baja"] == '1')           $baja   = 'checked'; 	  else    $baja   = '';
											if($cur["modificacion"] == '1')   $modific= 'checked'; 	  else    $modific= '';
											
											echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
                                                . '<td style="text-align:center">' . '<input name="chek[]" id="chek[]" value="'.$cur["f"].'" type="checkbox" '.$elejida.' class="form-check-success" > '. "</td>\n"
                                                . '<td style="text-align:center">' . utf8_encode($cur['nbre_m'])      . "</td>\n"
                                                . '<td style="text-align:center">' . utf8_encode($cur['nbre_f'])      . "</td>\n"
                                                . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-A" name="'.$cur["f"].'-A" value="1" type="checkbox" '.$alta.' class="styled" > '. "</td>\n"
                                                . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-B" name="'.$cur["f"].'-B" value="1" type="checkbox" '.$baja.' class="styled" > '. "</td>\n"
                                                . '<td style="text-align:center">' . '<input id="'.$cur["f"].'-M" name="'.$cur["f"].'-M" value="1" type="checkbox" '.$modific.' class="styled" > '. "</td>\n"
                                                . '<td style="text-align:left">'   . $cur['descripcion'] . "</td>\n"
                                                . '<input type="hidden" id="idperfil" name="idperfil" value="'.$idperfil.'" > '. "</td>\n"
                                                . "</tr>\n";
											echo $fila;
										}// for
								        echo "</tbody>";?>
								
								</table>
                                </div><br />
	            
                            <div class="modal-footer"><center>								
                                <button type="submit" id="Submit" name="Submit" class="btn btn-success" onclick="javascript:this.form.submit();this.disabled= true;mostrarMsjBtn_upd()" title="Presione el botón para agregar actualizar los permisos." > Actualizar Permisos </button>
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


</body>
</html>

