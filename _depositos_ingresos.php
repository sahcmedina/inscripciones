<?php
	require_once('./estructura/cookies_datsUser_msjBienvenida_version.php');

	// consultar permisos del usuario (logueado) a la funcion
	$datos_f = array();
	$datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
	$alta    = $datos_f[0]['alta'];
	$baja    = $datos_f[0]['baja'];
	$modf    = $datos_f[0]['modificacion'];
		
	// ------------------------------ FUNCION ------------------------------ //	
    include('./funciones/mod2_depositos.php');      $Depo  = new Depositos();
    include('./funciones/mod2_proveedores.php');    $Prov  = new Proveedores();
    include('./funciones/mod2_materiales.php');     $Mat   = new Materiales();

    $id_depo                 = $_SESSION["depo_elegido"];
    $_SESSION["depo_elegido"]= $id_depo;

    $nbre_depo = $Depo->get_nombre($id_depo);

	$arr_sino   = array('no','si');
	
	// recibo el id del perfil
	$idperfil   = $_POST['idperfil'];	

	$arr_funcion= array();
	$arr_funcion= $U->gets_funciones_segun_perfil($idperfil, $id_empresa_logueada);
	$nbre_perfil= $U->get_nbre_perfil($idperfil);
    $id_user    = $U->get_id( $login);

	$arr_dep    = array();
	$arr_dep    = $Depo->gets();

    $arr_prov   = array();
	$arr_prov   = $Prov->gets();

    $arr_codigos= array();
	$arr_codigos= $Mat->gets();
    
    $arr_aratos= array();
	$arr_aratos= $Mat->gets();

    $arr_cant   = array('1','2','3','4','5');
    $arr_tratamiento= array('M','P');

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

    <!-- MOSTRAR Y OCULTAR CAMPOS SEGUN LO QUE SE SELECCIONE -->	
    <script language="javascript">
        function select_tratamiento(selectTag){
            if(selectTag.value == 'P' ){
                document.getElementById('mostrar_arato_1').hidden = false;
            }else{
                document.getElementById('mostrar_arato_1').hidden = true;
            }	 		
        }		
    </script>

    <!-- AJAX: BUSCO EN LA DB, LOS @ DEL AREA ELEGIDA -->	
    <script language="javascript">
    $(document).ready(function(){                         
        var tra; var dep;   
        $("#tratam_1").change(function(e){
                tra = $("#tratam_1").val();                         
                dep = $("#dep").val();                                   
                
                $("#llenar_select_arato_1").delay(50).queue(function(n) {                                                 
                        $.ajax({
                            type: "POST",
                            url: "./funciones/mod2_ingresos_ajax_llenarSelectArato.php",
                            data: "tra="+tra+"&dep="+dep,     dataType: "html",
                            error: function(){ alert("error petición ajax");   },
                            success: function(data){  $("#llenar_select_arato_1").html(data);    n();}
                    });                                           
                });                                
        });                              
    });
    </script>
	
    <!-- Validacion de datos por AJAX para AGREGAR  -->           
    <script language="javascript">
    $(document).ready(function(){                         
        var dep;        var prov;  var fk_depo; 
        var cant_mat_1; var cod_1; var tratam_1; var arato_1;          
        $("#validar_add").click(function(){
            dep   = $("#dep").val();         prov = $("#prov").val();   user = $("#fk_user_").val();    fk_depo= $("#fk_depo_").val();
            cant_1= $("#cant_mat_1").val();  cod_1= $("#cod_1").val();  trat_1 = $("#tratam_1").val();  ara_1 = $("#arato_1").val();
            
            $("#mostrar_validar_add").delay(15).queue(function(n) {                                                 
                $.ajax({
                    type: "POST",
                    url: "./funciones/mod2_ingresos_ajax_validar_add.php",
                    data: "dep="+dep+"&prov="+prov+"&cant_1="+cant_1+"&cod_1="+cod_1+"&trat_1="+trat_1+"&ara_1="+ara_1+"&user="+user+"&fk_depo="+fk_depo,
                    dataType: "html",
                    error: function(){	        alert("error petición ajax");                    },
                    success: function(data){ 	$("#mostrar_validar_add").html(data);  	n();	 } 
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
                                                <li class="breadcrumb-item"> Depósitos </li>
                                                <li class="breadcrumb-item"><a href="_depositos_inventario.php" title="ir">Inventario</a></li>
                                                <li class="breadcrumb-item" aria-current="page"><a href="_depositos_inventario.php" title="ir"> <b><font color='red'><?php echo $nbre_depo ?></font></b> </a></li>
                                                <li class="breadcrumb-item active" aria-current="page"> Ingreso de Materiales</li>
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
                                <!-- <div class="panel-heading"><h7 class="panel-title"><i class="icon-table"></i><center><?php echo ' Permisos del Perfil:  <b>'.$nbre_perfil.'</b> ' ?></center></h7> -->
                                <br/>

                                <div class="modal-content">
                                <form name="add_dep" id="add_dep" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                    <div class="modal-body with-padding">

                                        <div class="form-group-sm">                                    
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Depósito<span class="mandatory">*</span></label>   
                                                    <select id="dep" name="dep" class="form-select dep form-control-sm" autocomplete="off" tabindex="3" ><?php
                                                        for ($i = 0; $i < count($arr_dep); $i++)
                                                            echo '<option value="'.$arr_dep[$i]['id'].'"'.'>' .$arr_dep[$i]['codigo'].' - P170'. "</option>\n";
                                                        ?>	
                                                    </select> 
                                                    <input type="hidden" id="fk_user_" name="fk_user_" value="<?php echo $id_user ?>" >
                                                    <input type="hidden" id="fk_depo_" name="fk_depo_" value="<?php echo $id_depo ?>" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Proveedor<span class="mandatory">*</span></label>   
                                                    <select id="prov" name="prov" class="form-select prov form-control-sm" tabindex="3" ><?php
                                                        for ($i = 0; $i < count($arr_prov); $i++)
                                                            echo '<option value="'.$arr_prov[$i]['id'].'"'.'>' .$arr_prov[$i]['nombre']."</option>\n";
                                                        ?>	
                                                    </select> 
                                                </div>
                                            </div>
                                        </div><br/>    

                                        <!-- 1° Material -->
                                        <div class="form-group-sm">                                    
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-1">1° Material</div>
                                                <div class="col-md-2">
                                                    <label># cant<span class="mandatory"> *</span></label>   
                                                    <input type="number" id="cant_mat_1" name="cant_mat_1" min=0 value=0 class="form-control form-control-sm" tabindex="2" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Código<span class="mandatory"> *</span></label>   
                                                    <select id="cod_1" name="cod_1" class="form-select cod_1 form-control-sm" tabindex="3" ><?php
                                                        echo '<option value="0" >Elija..</option>\n';
                                                        for ($i = 0; $i < count($arr_codigos); $i++)
                                                            echo '<option value="'.$arr_codigos[$i]['id'].'"'.'>' .$arr_codigos[$i]['codigo'].' - '.$arr_codigos[$i]['nombre']. "</option>\n";
                                                        ?>	
                                                    </select> 
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Tratamiento <span class="mandatory"> *</span></label>   
                                                    <select id="tratam_1" name="tratam_1" class="form-select tratam_1 form-control-sm" tabindex="3" ><?php
                                                        for ($i = 0; $i < count($arr_tratamiento); $i++)
                                                            echo '<option value="'.$arr_tratamiento[$i].'"'.'>' .$arr_tratamiento[$i]."</option>\n";
                                                        ?>	
                                                    </select>  
                                                </div>                    
                                                <div class="col-md-2" >                          
                                                    <div id="llenar_select_arato_1"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer d-flex justify-content-center"><center><br/>					
                                        <!-- <button class="btn btn-dark" data-bs-dismiss="modal" tabindex="4">Cancelar</button>		                                     -->
                                        <button id="validar_add" name="validar_add" type="button" class="btn btn-success" title="Se va a validar si se puede agregar." tabindex="5" > Agregar </button>
                                        <br /><br />
                                        <div id="mostrar_validar_add" ></div> 
                                    </div></center>
                                
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

    <!-- SELECT CON BUSQUEDA -->
    <script type="text/javascript">
        new TomSelect("#dep",{      create: false, sortField: { field: "text", direction: "asc" }});
        new TomSelect("#prov",{     create: false, sortField: { field: "text", direction: "asc" }});
        new TomSelect("#cod_1",{    create: false, sortField: { field: "text", direction: "asc" }});
        new TomSelect("#tratam_1",{ create: false, sortField: { field: "text", direction: "asc" }});
    </script>

    
</body>
</html>

