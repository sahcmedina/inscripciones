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
    require_once('./funciones/mod2_sol_material.php');     $SolMat = new SolicitudMateriales();
    require_once('./funciones/mod2_ingresos.php');         $Ing    = new Ingresos();
    require_once('./funciones/mod2_aratos.php');           $Aratos = new Aratos();

	$arr_solicPorTec = array();
    	
    // Dispositivo conectado
    $dispositivo = new Mobile_Detect();
    if ($dispositivo->isMobile()){       $disp_conectado = 'Movil';     $nbre_funcion = 'Solicitudes Pendientes';       }
    else{							     $disp_conectado = 'PC';        $nbre_funcion = 'Pendientes ';                  }

	// Datos del user logueado
	$idperfil     = $_POST['idperfil'];	
	$arr_funcion  = array();
	$arr_funcion  = $U->gets_funciones_segun_perfil($idperfil, $id_empresa_logueada);
	$nbre_perfil  = $U->get_nbre_perfil($idperfil);    
	$id_user      = $U->get_id( $login);    
    // $depo_logueado= $DepoT->get_depoUser($id_user);

    // Sol Pendientes del Admin
    $arr_solicPendientes = $SolMat->gets_solicPendTodas();
    
?>

<!DOCTYPE html><html lang="es">

<head>

    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>       

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
                    
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    
                        <div class="widget-content widget-content-area br-8">

                        <form name="add_mat_pend" id="add_mat_pend" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                        
                            <table id="dt_" class="table dt-table-hover" style="width:100%">
                                
                                <?php
                                    $tabla= "<thead><tr class=\"rowHeaders\">			
                                            <th style='text-align:center'> Código	        </th>
                                            <th style='text-align:center'> Código	        </th>
                                            <th style='text-align:center'> Nombre	        </th>
                                            <th style='text-align:center'> # Cant 	        </th>
                                            <th style='text-align:center'> Deposito	        </th>
                                            <th style='text-align:center'> Sacar de?        </th>
                                            <th style='text-align:center'> Solicitado el?	</th>
                                            <th style='text-align:center'> Por?	            </th></th>";
                                    $tabla.="</tr></thead><tbody>";			
                                    echo $tabla;
                                    for($j=0 ; is_array($arr_solicPendientes) && $j<count($arr_solicPendientes) ; $j++){
                                        $cur  = $arr_solicPendientes[$j];
                                    
                                        if($cur['f_update'] == '0000-00-00 00:00:00'){ $fupdate=''; }else{ $fupdate= date("d/m/Y H:i:s", strtotime($cur['f_update'])); }

                                        $btn_ver = '<button data-bs-toggle="modal" data-bs-target="#modal_ver" 
                                                       data-id="'.$cur['id'].'" data-codigo="'.$cur['codigo'].'" data-nombre="'.$cur['nombre'].'" data-cant_min="'.$cur['cant_min'].'" data-unidad_medida="'.$cur['unidad_medida'].'" 
                                                       data-min_scrap="'.$cur['cant_min_scrap'].'" data-f_create="'.date("d/m/Y H:i:s", strtotime($cur['f_create'])).'" data-f_update="'.$fupdate.'"
                                                       class="btn btn-outline-info btn-icon mb-2 me-4" title="Ver un registro">
                                                       <i class="bi bi-search" style="font-size: 1rem;"></i>
                                                       </button>';

                                        if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                        if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; } else {  $btn_mdf_mostrar= ''; }
                                            
                                        Switch($cur['mes']){
                                            case 'Jan': $mes_format='Ene'; break;       case 'Feb': $mes_format='Feb'; break;
                                            case 'Mar': $mes_format='Mar'; break;       case 'Apr': $mes_format='Abr'; break;
                                            case 'May': $mes_format='May'; break;       case 'Jun': $mes_format='Jun'; break;
                                            case 'Jul': $mes_format='Jul'; break;       case 'Aug': $mes_format='Ago'; break;
                                            case 'Sep': $mes_format='Sep'; break;       case 'Oct': $mes_format='Oct'; break;
                                            case 'Nov': $mes_format='Nov'; break;       case 'Dec': $mes_format='Dic'; break;
                                        }

                                        // sacar de ?
                                        switch($cur['origen']){
                                            case 'M': $tabla_='inv_m'; $fk_a= '';               $fk_d= $cur['fk_deposito'];  break;
                                            case 'P': $tabla_='inv_p'; $fk_a= '';               $fk_d= $cur['fk_deposito'];  break;
                                            case 'A': $tabla_='inv_a'; $fk_a= $cur['fk_arato']; $fk_d= $cur['fk_deposito'];  break;
                                        }
                                        if($fk_a != ''){   $nbre_ara = ': '.$Aratos->get_nombre($fk_a);   }    // busco nombre
                                        else{              $nbre_ara = '';                                          }
                                        $sacar_de    = $cur['origen'].''.$nbre_ara.' - '; 
                                        $cant_a_sacar= $Ing->get_cantActual_materialASacar($cur['origen'], $cur['mat_id'], $cur['dep_id'], $fk_a);
		                                $sacar_de   .= 'dispo: <b>'.$cant_a_sacar.'</b>';
                                        

                                        echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                        . '<td style="text-align:center">'. $cur['mat_codigo']        ."</td>\n"
                                        . '<td style="text-align:center">'. $cur['mat_codigo']        ."</td>\n"
                                        . '<td style="text-align:center">'. $cur['mat_nbre']  	  ."</td>\n"
                                        . '<td style="text-align:center">'. $cur['cant'] 	  ."</td>\n"
                                        . '<td style="text-align:center">'. $cur['dep_cod'].' - '.$cur['dep_prov']."</td>\n"
                                        . '<td style="text-align:center">'. $sacar_de."</td>\n"
                                        . '<td style="text-align:center">'. $cur['fecha_1'].$mes_format.' '.$cur['fecha_2']."</td>\n"
                                        . '<td style="text-align:center">'. $cur['pers'] 	  ."</td>\n"
                                        . "</tr>\n";
                                    }
                                    echo "</tbody>";
                                ?>   
                            </table>

                            <div class="modal-footer d-flex justify-content-center"><center>					
                                <br/>
                                <button type="button" onclick="history.back()" class="btn btn-dark" data-bs-dismiss="modal" tabindex="1"> Volver </button>		                                    
                                <button type="submit" class="btn btn-success" data-bs-dismiss="modal" tabindex="2"> Aprobar </button>		                                    
                                <br/><br/>
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
        c1 = $('#dt_').DataTable({
            headerCallback:function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML=`
                <div class="form-check form-check-success d-block">
                    <input class="form-check-input chk-parent" type="checkbox" id="form-check-default"> Elija
                </div>`
            },
            columnDefs:[ {
                targets:0, width:"30px", className:"", orderable:!1, render:function(e, a, t, n) {
                    return `
                    <div class="form-check form-check-success d-block">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`
                }
            }],
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
            "lengthMenu": [100],
            "pageLength": 100 
        });
        
        multiCheck(c1);

    </script> 

</body>
</html>

