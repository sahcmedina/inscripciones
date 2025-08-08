<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('10',$datos[0]['fk_perfil']);
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
	include_once('./funciones/mod3_productos.php');               $Productos = new Productos(); 
	include_once('./funciones/mod3_ronda_neg.php');               $RondaNeg  = new RondaNegocios();
    include_once('./funciones/mod3_rn_agenda.php');	              $RondAg    = new RN_Agenda();

    $id = $_SESSION['var_id'];

    $arr_durac= array('15', '20','25','30');
	$arr_p    = array(); 
	$arr_p    = $Productos->gets(); 

	$id_user  = $U->get_id( $login);

    $arr_     = array();
	$arr_     = $RondaNeg->gets();

    $arr_param    = array();
	$arr_param    = $RondaNeg->gets_param();
    list($hh, $mm, $ss)= explode(':', $arr_param[0]['primer_reunion']);
    $par_prim_reun= $hh.':'.$mm;
    $par_duracion = $arr_param[0]['duracion'];
    $par_x_dia    = $arr_param[0]['x_dia'];
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

    <!-- PASAR DATOS AL MODAL: Procesar Agenda  -->
    <script>
    $(document).ready(function(){  
        $('#modal_procesar').on('show.bs.modal', function (event) {    
            var button   = $(event.relatedTarget)  // Botón que activó el modal
            var id       = button.data('id')   
            var nombre   = button.data('nombre')   
            var modal    = $(this)
            modal.find('.modal-body #id_proc').val(id)
            modal.find('.modal-body #nombre_proc').val(nombre)
            
            $('.alert').hide();//Oculto alert
            })
        });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var codi; var prov;  var dir;  var tel; var usu;          
        $("#validar_upd").click(function(){
            usu     = $("#usuario").val();			
            hs      = $("#hs_").val();			  
            duracion= $("#duracion_").val();			
            x_dia   = $("#x_dia_").val();			

            $("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_rn_agenda_param_ajax_validar_upd.php",                                                                                                                                                                                                    
                    data: "usuario="+usu+"&hs="+hs+"&duracion="+duracion+"&x_dia="+x_dia,     
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
                    url: "./funciones/mod3_productos_ajax_validar_del.php",                                                                                                                                                                                                    
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
            usu  = $("#usuario").val();				
            nom  = $("#nom_").val();				

            $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_productos_ajax_validar_add.php",                                                                                                                                                                                                    
                    data: "usu="+usu+"&nom="+nom,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		},
                    success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
                });                                           
            });                                
        });              
    });
    </script>

    <!-- AJAX: Validar datos por ajax - Antes de Procesar -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var id;          
        $("#validar_proc").click(function(){
            usu= $("#usuario").val();		
            id = $("#id_proc").val();			

            $("#mostrar_validar_proc").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod3_rn_agenda_ajax_validar_proc.php",                                                                                                                                                                                                    
                    data: "id="+id+"&usu="+usu,     
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");           		    },
                    success: function(data){ 	$("#mostrar_validar_proc").html(data);  	n();    }
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
                                                <li class="breadcrumb-item" aria-current="page"> Agenda </li>
                                                <li class="breadcrumb-item active" aria-current="page"> NOMBRE </li>
                                            </ol>
                                        </nav>
                        
                                    </div>
                                </div>

                            </header>
                        </div>
                    </div>
                    
                    <!-- CONTENIDO -->

                    <!-- Modal: Info -->
                    <div id="modal_info" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Información </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <label> La función permite administrar las Agendas de las Rondas de Negocios. </label>
                                            <br/><br/>
                                            <label><b>* Mdf Parametros:</b> Cambia los permisos para el perfil de un usuario elegido. </label>
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

                    <!-- TABS -->
                    <br />
                    <div class="simple-pill">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active position-relative mb-2 me-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-d1" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                    <span class="btn-text-inner"> Compradores </span>
                                    <span class="badge badge-info counter"><?php echo $knt_inscript_c; ?></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative mb-2 me-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-d2" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                    <span class="btn-text-inner"> Vendedores </span>
                                    <span class="badge badge-info counter"><?php echo $knt_inscript_v; ?></span>
                                </button>
                            </li>                            
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-d1" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                
                                <!-- DT Dia 1 -->
                                <?php if(count($arr_inscript_c) > 0){	?>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <table id="dt_c" class="table dt-table-hover" style="width:100%">
                                                    <?php
                                                    $tabla= "<thead><tr class=\"rowHeaders\">			
                                                        <th style='text-align:center'> id   	 </th>
                                                        <th style='text-align:center'> Persona	 </th>
                                                        <th style='text-align:center'> Telefono  </th>
                                                        <th style='text-align:center'> Email     </th>
                                                        <th style='text-align:center'> Empresa   </th>
                                                        <th style='text-align:center'> CUIT      </th>
                                                        <th style='text-align:center'> Provincia </th>";
                                                    $tabla.="</tr></thead><tbody>";			
                                                    echo $tabla;
                                                    for($j=0 ; is_array($arr_inscript_c) && $j<count($arr_inscript_c) ; $j++){
                                                        $cur  = $arr_inscript_c[$j];
                                                        echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                                            . '<td style="text-align:center">'. $cur['id']    	    ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['persona']     ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['tel']         ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['email']       ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['emp']         ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['cuit']        ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['prov']        ."</td>\n"
                                                            . "</tr>\n";
                                                    }
                                                    echo "</tbody>";
                                                ?>  
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{ 
                                    echo '<center><span style="font-weight:bold;color:red;">No hay Compradores inscriptos </span></center>';
                                } ?>
                                <!-- Fin - DT Compradores -->

                            </div>
                            <div class="tab-pane fade" id="pills-d2" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                                <!-- DT Dia 2 -->
                                <?php if(count($arr_inscript_v) > 0){	?>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <table id="dt_v" class="table dt-table-hover" style="width:100%">
                                                    <?php
                                                    $tabla= "<thead><tr class=\"rowHeaders\">		
                                                        <th style='text-align:center'> id   	 </th>
                                                        <th style='text-align:center'> Persona	 </th>
                                                        <th style='text-align:center'> Telefono  </th>
                                                        <th style='text-align:center'> Email     </th>
                                                        <th style='text-align:center'> Empresa   </th>
                                                        <th style='text-align:center'> CUIT      </th>
                                                        <th style='text-align:center'> Provincia </th>";
                                                    $tabla.="</tr></thead><tbody>";			
                                                    echo $tabla;
                                                    for($j=0 ; is_array($arr_inscript_v) && $j<count($arr_inscript_v) ; $j++){
                                                        $cur  = $arr_inscript_v[$j];
                                                        echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                                            . '<td style="text-align:center">'. $cur['id']    	    ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['persona']     ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['tel']         ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['email']       ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['emp']         ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['cuit']        ."</td>\n"
                                                            . '<td style="text-align:center">'. $cur['prov']        ."</td>\n"
                                                            . "</tr>\n";
                                                    }
                                                    echo "</tbody>";
                                                ?>  
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }else{ 
                                    echo '<center><span style="font-weight:bold;color:red;">No hay Vendedores inscriptos </span></center>';
                                } ?>
                                <!-- Fin - DT Vendedores -->

                            </div>
                        </div>

                    </div>
                    <!-- FIN TABS -->

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
            modalAdd.addEventListener('shown.bs.modal', function () {   document.getElementById('nom_').focus();          });

            var modalUpd = document.getElementById('modal_upd');
            modalUpd.addEventListener('shown.bs.modal', function () {   document.getElementById('hs_').focus();            });
        });
    </script>    

    <?php 
	    require_once('./estructura/buscador_barra.php');
	?> 

</body>
</html>