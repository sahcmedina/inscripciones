<?php	
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('2',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
	
	// ------------------------------ FUNCION ------------------------------ //			
	include('./funciones/mod2_depositos.php');              $Dep = new Depositos();
	include('./funciones/comunes_pais_prov.php');           $Pais= new Pais_prov();
	include('./funciones/mod2_depositos_tecnicos.php');     $Tec  = new Depositos_tecnicos();

	$arr_dep = array(); 
	$arr_dep = $Dep->gets();
	$id_user = $U->get_id( $login);

	$arr_prov = array();
	$arr_prov = $Pais->gets_provincias();
?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>    
    
<!-- PASAR DATOS AL MODAL: Borrar Deposito -->
<script>
$(document).ready(function(){  
	$('#modal_del').on('show.bs.modal', function (event) {    
		  var button   = $(event.relatedTarget)  // Botón que activó el modal
		  var id       = button.data('id')   
		  var codigo   = button.data('codigo')   
		  var modal    = $(this)
		  modal.find('.modal-body #id_del').val(id)
		  modal.find('.modal-body #codigo_del').val(codigo) 
		 
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
                url: "./funciones/mod2_ajax_validar_del_deposito.php",                                                                                                                                                                                                    
                data: "id="+id,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_del").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- PASAR DATOS AL MODAL: Actualizar Deposito -->
<script>
$(document).ready(function(){  
	$('#modal_mdf').on('show.bs.modal', function (event) {    
		  var button    = $(event.relatedTarget)  // Botón que activó el modal
		  var id        = button.data('id')   
		  var codigo    = button.data('codigo_ant')   
		  var codigo_ant= button.data('codigo_ant')   
		  var prov      = button.data('prov')   
		  var dir       = button.data('dir')   
		  var tel       = button.data('tel')   
		  var modal     = $(this)
		  modal.find('.modal-body #id_').val(id)
		  modal.find('.modal-body #codigo_new').val(codigo)
		  modal.find('.modal-body #codigo_ant').val(codigo_ant)
		  modal.find('.modal-body #prov_').val(prov)
		  modal.find('.modal-body #dir_').val(dir)
		  modal.find('.modal-body #tel_').val(tel)
		 
		  // hace la busqueda para mostrar la imagen
		  $("#ver_prov").delay(10).queue(function(n) { 
				$.ajax({
						type: "POST",
						url:  "./funciones/mod2_ajax_prov_upd_depo.php",
						data: "prov="+prov,
						dataType: "html",
						error: function(){
							alert("error petición ajax");
						},
						success: function(data){                                                      
							$("#ver_prov").html(data);
							n();
						}
				});                                           
			});

		  $('.alert').hide();//Oculto alert
		})
	});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
<script language="javascript">
$(document).ready(function(){                         
    var codi; var prov;  var dir;  var tel; var usu;          
    $("#validar_upd").click(function(){
		id   = $("#id_").val();			
		codi_ant = $("#codigo_ant").val();			
		cod  = $("#codigo_new").val();			
		prov_= $("#prov_").val();			
		dir  = $("#dir_").val();			
		tel  = $("#tel_").val();			
		usu  = $("#usuario").val();			

	  	$("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod2_ajax_validar_upd_deposito.php",                                                                                                                                                                                                    
                data: "id="+id+"&cod="+cod+"&cod_ant="+codi_ant+"&prov="+prov_+"&dir="+dir+"&tel="+tel+"&usuario="+usu,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_upd").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Agregar -->	
<script language="javascript">
$(document).ready(function(){                         
    var codi; var prov;  var dir;  var tel; var usu;          
    $("#validar_add").click(function(){
		codi = $("#codigo_").val();			
		prov = $("#prov").val();			
		dir  = $("#dir").val();			
		tel  = $("#tel").val();			
		usu  = $("#usuario").val();			

	  	$("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod2_ajax_validar_add_deposito.php",                                                                                                                                                                                                    
                data: "cod="+codi+"&prov="+prov+"&dir="+dir+"&tel="+tel+"&usuario="+usu,     
              	dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();    }
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
                                                <li class="breadcrumb-item">Depósitos</li>
                                                <li class="breadcrumb-item active" aria-current="page">Depósitos</li>
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

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label><i class="icon-warning"></i> La función permite administrar los diferentes Depositos de la empresa. </label></center>
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
                            
                            <div class="modal-header"><h6 class="modal-title"> Borrar Depósito </h6></div>

                            <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <center><label style="color:red;font: size 30px;"><i class="icon-warning"></i> ¿ Está seguro ? </label></center>
                                        </div><br>
                                        <div class="row" align="center">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <label>Código:</label>
                                                <input type="text"    id="codigo_del" name="codigo_del" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden"  id="id_del"     name="id_del"     >	 
                                            </div>	
                                            <div class="col-md-2"></div>
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
                            
                            <div class="modal-header"><h6 class="modal-title"> Agregar Depósito </h6></div>

                            <form name="add_dep" id="add_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">					
                                    <div class="form-group-sm">                                    
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Código<span class="mandatory">*</span></label>   
                                                <input type="text" id="codigo_" name="codigo_" class="form-control form-control-sm" tabindex="1" required>
                                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $id_user ?>" >
                                            </div>
                                            <div class="col-md-3">
                                                <label>Provincia<span class="mandatory">*</span></label>   
                                                <select id="prov" name="prov" class="form-select prov form-control-sm" tabindex="2" ><?php
                                                    for ($i = 0; $i < count($arr_prov); $i++)
                                                        echo '<option value="'.$arr_prov[$i]['id'].'"'.'>' .$arr_prov[$i]['nombre']. "</option>\n";
                                                    ?>	
                                                </select> 
                                            </div>
                                            <div class="col-md-5">
                                                <label>Dirección<span class="mandatory">*</span></label>   
                                                <input type="text" id="dir" name="dir" class="form-control form-control-sm" tabindex="3" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Teléfono<span class="mandatory">*</span></label>   
                                                <input type="text" id="tel" name="tel" class="form-control form-control-sm" tabindex="4" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>	

                                <div class="modal-footer d-flex center-content-end"><center>					
                                    <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="5">Cancelar</button>		                                    
                                    <button id="validar_add" name="validar_add" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="6" > Agregar </button>
                                    <br /><br />
                                    <div id="mostrar_validar_add" ></div> 
                                </div></center>

                            </form>
                            
                            </div>
                        </div>
                    </div>

                    <!-- Modal: Modificar -->
                    <div id="modal_mdf" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"> Modificar Depósito </h6></div>

                            <form name="mdf_dep" id="mdf_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label >Código <span class="mandatory">*</span></label>
                                            <input type="text"   id="codigo_new" name="codigo_new"   class="form-control form-control-sm" tabindex="1" required>
                                            <input type="hidden" id="codigo_ant" name="codigo_ant" >
                                            <input type="hidden" id="id_"        name="id_"   >
                                            <input type="hidden" id="usuario"    name="usuario" value="<?php echo $id_user ?>" >
                                        </div>
                                        <div class="col-md-3">
                                            <label>Dirección <span class="mandatory">*</span></label>
                                            <input type="text" id="dir_" name="dir_" class="form-control form-control-sm" tabindex="2" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Teléfono <span class="mandatory">*</span></label>
                                            <input type="text" id="tel_" name="tel_" class="form-control form-control-sm" tabindex="3" required>
                                        </div>                                        
                                        <div id="ver_prov"></div>
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
				
                    <!-- FUNCIONES EXTRAS -->
                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 mx-auto layout-spacing">                            
                            <div class="statbox widget box box-shadow">                                
                                <div class="widget-content widget-content-area text-center">
                                    <br/>
                                    <button data-bs-toggle="modal" data-bs-target="#modal_info" class="btn btn-outline-info btn-icon mb-2 me-4" title="Más info.." ><i class="bi bi-exclamation-circle" style="font-size: 1rem;"></i></button>
                                    <?php if($alta == '1') { ?>
                                        <a href="_depositos_tecnicos.php"><button class="btn btn-outline-success btn-icon mb-2 me-4" title="Administrar relacion: Técnico - Depósito" ><i class="bi bi-person-badge-fill" style="font-size: 1rem;"></i></button></a>
                                        <button data-bs-toggle="modal" data-bs-target="#modal_add" class="btn btn-outline-success btn-icon mb-2 me-4" title="Agregar un Depósito" ><i class="bi bi-plus-circle" style="font-size: 1rem;"></i></button>                                        
                                    <?php } ?> 
                                    <br/>                               
                                </div>
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
                                                <th style='text-align:center'> Código   			</th>
                                                <th style='text-align:center'> Provincia			</th>
                                                <th style='text-align:center'> Domicilio 			</th>
                                                <th style='text-align:center'> Tel		 			</th>
                                                <th style='text-align:center'> # Técnicos 			</th>
                                                <th style='text-align:center'> Acciones 	 		</th>";
                                        $tabla.="</tr></thead><tbody>";			
                                        echo $tabla;
                                        for($j=0 ; is_array($arr_dep) && $j<count($arr_dep) ; $j++){
                                            $cur  = $arr_dep[$j];
                                        
                                            $btn_del = ' <button data-bs-toggle="modal" data-bs-target="#modal_del" 
                                                            data-id="'.$cur['id'].'" data-codigo="'.$cur['codigo'].'" 
                                                            class="btn btn-outline-danger btn-icon mb-2 me-4" title="Eliminar un Depósito" >
                                                            <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                                            </button>';

                                            $btn_mdf = '<button data-bs-toggle="modal" data-bs-target="#modal_mdf" 
                                                           data-id="'.$cur['id'].'" data-codigo_ant="'.$cur['codigo'].'" data-prov="'.$cur['fk_provincia'].'" data-dir="'.$cur['domicilio'].'" data-tel="'.$cur['tel'].'"
                                                           class="btn btn-outline-success btn-icon mb-2 me-4" title="Modificar un Depósito">
                                                           <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                                           </button>';

                                            if($baja == '1') { $btn_del_mostrar= $btn_del; } else {  $btn_del_mostrar= ''; }
                                            if($modf == '1') { $btn_mdf_mostrar= $btn_mdf; } else {  $btn_mdf_mostrar= ''; }

                                            $knt_tecnicos = $Tec->get_cantEnDepo($cur['id']);                                           

                                            echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                            . '<td style="text-align:center">'. $cur['codigo']    	."</td>\n"
                                            . '<td style="text-align:center">'. $cur['prov']  		."</td>\n"
                                            . '<td style="text-align:center">'. $cur['domicilio']   ."</td>\n"
                                            . '<td style="text-align:center">'. $cur['tel']   		."</td>\n"
                                            . '<td style="text-align:center">'. $knt_tecnicos  		."</td>\n"
                                            . '<td style="text-align:center">'. $btn_mdf_mostrar . $btn_del_mostrar."</td>\n"
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


</body>
</html>

