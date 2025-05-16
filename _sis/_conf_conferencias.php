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
	
    $arr_orga  = array();
	$arr_orga = $Con->gets_all_organismos();
	$id_user  = $U->get_id( $login);

?>

<!DOCTYPE html><html lang="es">

<head>
    <?php 
	require_once('./estructura/cabecera.php');
	require_once('./estructura/librerias_utilizadas.php');
	?>      

<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> 

    <!-- Muestra borde de componentes del Form -->
<style>
    input:focus, select:focus, textarea:focus {
        border: 2px solid #007bff !important;                   /* Borde azul más grueso */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;  /* Sombra suave */
        transition: all 0.3s ease;                                /* Animación suave */
    }
</style>

<style id="jsbin-css">
    td.dt-control {
        text-align:center;
        color:forestgreen;
        cursor: pointer;
    }
    tr.shown td.dt-control {
        text-align:center; 
        color:red;
    }
</style>
<!-- DESDE ACA EMPIEZA LO NUEVO -->
<script language="javascript">

$(document).ready(function () {
    listar();
})
var listar = function(){
    // para verificar los permisos del usuario
    var inputmodf = document.getElementById("permiso_modf");
    var inputbaja = document.getElementById("permiso_baja");
    // Obtener el valor
    var modf = inputmodf.value; // 1: puede modificar 0: no puede modif
    var baja = inputbaja.value; // 1: puede eliminar  0: no puede elim
                    
    var table = $('#dt_conferencias').DataTable({
        initComplete: function () {
        var api = this.api();
        if ( modf==0 ) {
            // oculto columna del boton para modificar y muestro el boton modificar deshabilitado
            api.column(5).visible( false );
            api.column(6).visible( true );
            }else{
                api.column(5).visible( true );
                api.column(6).visible( false );
            };
        if ( baja==0 ) {
            // oculto columna del boton para eliminar y muestro el boton eliminar deshabilitado
            api.column(7).visible( false );
            api.column(8).visible( true );
            }else{
                api.column(7).visible( true );
                api.column(8).visible( false );
            }
        },

        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        // "destroy": true, sirve para re inicializar el datatable.
        ajax:{            
	        "url": "./funciones/mod5_listar_conferencias.php", 
	        "dataSrc":""
    	},	
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ' ',
            },
            { data: 'titulo' },
            { data: 'estado' },
            { data: 'fecha'  },
            { data: 'hora'   },
            {
                className: 'text-center',
                orderable: false,
                data: null,
                defaultContent: '<button data-bs-toggle="modal" data-bs-target="#modal_mdf" class="btnEditar btn btn-outline-success btn-icon mb-2 me-4" title="Editar datos de la Conferencia"><i class="bi bi-pencil" style="font-size: 1rem;"></i></button>',
            },
            {
                 className: 'text-center',
                 orderable: false,
                 data: null,
                 defaultContent: '<button data-bs-toggle="modal" data-bs-target="#" class="btnEditar btn btn-outline-success btn-icon mb-2 me-4" title="No tiene permisos para editar Conferneicas" disabled ><i class="bi bi-pencil" style="font-size: 1rem;"></i></button>',
            },
            {
                className: 'text-center',
                orderable: false,
                data: null,
                defaultContent: '<button data-bs-toggle="modal" data-bs-target="#modal_del" class="btnBorrar btn btn-outline-danger btn-icon mb-2 me-4" title="Eliminar Conferencia"><i class="bi bi-trash" style="font-size: 1rem;"></i></button>',
            },
            {
                className: 'text-center',
                orderable: false,
                data: null,
                defaultContent: '<button data-bs-toggle="modal" data-bs-target="#modal_del" class="btnBorrar btn btn-outline-danger btn-icon mb-2 me-4" title="No tiene permisos para eliminar Conferencias" disabled ><i class="bi bi-trash" style="font-size: 1rem;"></i></button>',
            }
        ],
        columnDefs: [
            { targets: 3, // La columna 2 contiene la fecha
              render: function (data, type, row) {
                return new Date(data).toLocaleDateString('es-ES'); // Formatear a DD/MM/YYYY
                }
            },
            { targets: 2, // La columna 2 contiene estado
              render: function (data, type, row) {
                if(data == 1){
                    if(modf==0){
                        return '<button data-bs-toggle="modal" data-bs-target="#modal_mdfSta" class="btnEditarSta btn btn-outline-warning btn-icon mb-2 me-4" title="Estado actual: Deshabilitado" disabled >Deshabilitado</i></button>';
                    }else{
                        return '<button data-bs-toggle="modal" data-bs-target="#modal_mdfSta" class="btnEditarSta btn btn-outline-warning btn-icon mb-2 me-4" title="Estado actual: Deshabilitado">Deshabilitado</i></button>';
                    }
                }else{
                    if(modf==1){
                        return '<button data-bs-toggle="modal" data-bs-target="#modal_mdfSta" class="btnEditarSta btn btn-outline-success btn-icon mb-2 me-4" title="Estado actual: Habilitado">Habilitado</button>';    
                    }else{
                        return '<button data-bs-toggle="modal" data-bs-target="#modal_mdfSta" class="btnEditarSta btn btn-outline-success btn-icon mb-2 me-4" title="Estado actual: Habilitado" disabled>Habilitado</button>';    
                    }
                } }
            }
        ],
        order: [[1, 'asc']],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sEmptyTable": "Ningún dato disponible",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 5,

    });

    obtener_data_editar("#dt_conferencias tbody", table);
    obtener_data_borrar("#dt_conferencias tbody", table);
    obtener_data_estado("#dt_conferencias tbody", table);

    $('#dt_conferencias tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
};

var obtener_data_editar = function(tbody, table){
    $(tbody).on("click", "button.btnEditar", function(){
        var data   = table.row($(this).parents("tr")).data();
        var titulo        = $("#modal_mdf #titulo").val(data.titulo),
            id_evento     = $("#modal_mdf #id_evento").val(data.id_evento),
            id_conferencia= $("#modal_mdf #id_conferencia").val(data.id_conferencia),
            disertante    = $("#modal_mdf #disertante").val(data.disertante);
            id_organismo  = $("#modal_mdf #id_organismo").val(data.id_organismo);
            fecha         = $("#modal_mdf #fecha").val(data.fecha);
            hora          = $("#modal_mdf #hora").val(data.hora);
            modalidad     = $("#modal_mdf #modalidad").val(data.modalidad);
            cupo          = $("#modal_mdf #cupo").val(data.cupo);
            f_inscrip_dsd = $("#modal_mdf #f_inscrip_dsd").val(data.f_inscrip_dsd);
            f_inscrip_hst = $("#modal_mdf #f_inscrip_hst").val(data.f_inscrip_hst);
            lugar         = $("#modal_mdf #lugar").val(data.lugar);
            //estado        = $("#modal_mdf #estado").val(data.estado);
    });
};

var obtener_data_borrar = function(tbody, table){
    $(tbody).on("click", "button.btnBorrar", function(){
        var data = table.row($(this).parents("tr")).data();
        var id_evento      = $("#modal_del #id_evento").val(data.id_evento),
            id_conferencia = $("#modal_del #id_conferencia").val(data.id_conferencia),
            titulo         = $("#modal_del #titulo").val(data.titulo);
    });
}

var obtener_data_estado = function(tbody, table){
    $(tbody).on("click", "button.btnEditarSta", function(){
        var data   = table.row($(this).parents("tr")).data();
        var titulo        = $("#modal_mdfSta #titulo").val(data.titulo),
            //id_evento     = $("#modal_mdfSta #id_evento").val(data.id_evento),
            id_conferencia= $("#modal_mdfSta #id_conferencia").val(data.id_conferencia),
            fecha         = $("#modal_mdfSta #fecha").val(data.fecha);
            hora          = $("#modal_mdfSta #hora").val(data.hora);
            modalidad     = $("#modal_mdfSta #modalidad").val(data.modalidad);
            cupo          = $("#modal_mdfSta #cupo").val(data.cupo);
            estado        = $("#modal_mdfSta #estado").val(data.estado);
    });
};
    
/* Formatting function for row details - modify as you need */
function format(d) {
    // `d` is the original data object for the row
    return (
        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Modalidad:</td>' +
        '<td>' +
        d.modalidad +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Cupo:</td>' +
        '<td>' +
        d.cupo +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Lugar:</td>' +
        '<td>' +
        d.lugar +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Inicio Inscripción:</td>' +
        '<td>' +
        d.f_inscrip_dsd +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Fin Inscripción:</td>' +
        '<td>' +
        d.f_inscrip_hst +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Disertante:</td>' +
        '<td>' +
        d.disertante +
        '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Organismo:</td>' +
        '<td>' +
        d.organismo +
        '</td>' +
        '</tr>' +
        '</table>'
    );
}

</script>

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
		titulo   = $("#modal_add #titulo").val();
        dis      = $("#modal_add #disertante").val();
        org      = $("#modal_add #organismo").val();
        fecha    = $("#modal_add #fecha").val();
        hora     = $("#modal_add #hora").val();
        mod      = $("#modal_add #modalidad").val();
        cupo     = $("#modal_add #cupo").val();
        i_inicio = $("#modal_add #insc_inicio").val();
        i_final  = $("#modal_add #insc_final").val();
        lugar    = $("#modal_add #lugar").val();
        usr      = $("#modal_add  #id_user").val();
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

<!-- AJAX: Validar datos por ajax - Antes de Cambiar el estado -->	
<script language="javascript">
$(document).ready(function(){                         
    var id; var state;          
    $("#validar_upd_sta").click(function(){
		id    = $("#modal_mdfSta #id_conferencia").val();			
		state = $("#modal_mdfSta #estado").val();
        id_usr= $("#modal_mdfSta #id_usr").val();			
		
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

<!-- AJAX: Validar datos por ajax - Antes de Actualizar -->	
<script language="javascript">
$(document).ready(function(){                         
    var id_e; var id_f; var titulo; var dis; var org; var fecha; var hora; var mod; var cupo; var i_inicio; var i_final;
    var lugar; var usr;   
    $("#validar_upd").click(function(){
		id_e      = $("#modal_mdf #id_evento").val();
        id_c      = $("#modal_mdf #id_conferencia").val();			
		titulo    = $("#modal_mdf #titulo").val();
        dis       = $("#modal_mdf #disertante").val();
        org       = $("#modal_mdf #id_organismo").val();
        fecha     = $("#modal_mdf #fecha").val();			
		hora      = $("#modal_mdf #hora").val();			
		mod       = $("#modal_mdf #modalidad").val();			
		cupo      = $("#modal_mdf #cupo").val();
        i_inicio  = $("#modal_mdf #f_inscrip_dsd").val();			
		i_final   = $("#modal_mdf #f_inscrip_hst").val();
        lugar     = $("#modal_mdf #lugar").val();
        usr       = $("#modal_mdf #id_user").val();

	  	$("#mostrar_validar_upd").delay(15).queue(function(n) {                                                 
            $.ajax({
                type: "POST",
                url: "./funciones/mod5_ajax_validar_upd_conferencia.php",                                                                                                                                                                                                    
                data: "id_e="+id_e+"&id_c="+id_c+"&titulo="+titulo+"&dis="+dis+"&org="+org+"&fecha="+fecha+"&hora="+hora+"&mod="+mod+"&cupo="+cupo+"&i_inicio="+i_inicio+"&i_final="+i_final+"&lugar="+lugar+"&id_user="+usr,
                dataType: "html",
                error: function(){	        alert("error petición ajax");           		},
                success: function(data){ 	$("#mostrar_validar_upd").html(data);  	n();    }
            });                                           
        });                                
    });              
});
</script>

<!-- AJAX: Validar datos por ajax - Antes de Borrar el Foro -->	
<script language="javascript">
$(document).ready(function(){                         
    var id_e; var id_f; var baja;          
    $("#validar_del").click(function(){
		id_e = $("#modal_del #id_evento").val();
        id_c = $("#modal_del #id_conferencia").val();
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

<!-- FIN DE DESDE ACA EMPIEZA LO NUEVO  -->

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
                                        
                                        <nav class="breadcrumb-style-five" aria-label="breadcrumb">
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
                                                <input type="text"   id="titulo" name="titulo" class="form-control form-control-sm" tabindex="1" readonly >	 
                                                <input type="hidden" id="id_evento" name="id_evento" >
                                                <input type="hidden" id="id_conferencia"   name="id_conferencia" >
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

                    <!-- Modal: Modificar Estado -->
                    <div id="modal_mdfSta" class="modal animated fadeInDown" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            
                            <div class="modal-header"><h6 class="modal-title"><i class="bi bi-repeat" style="font-size: 1rem;"></i> Modificar Estado de la Conferencia  </h6></div>

                            <form name="mdfsta" id="mdfsta" class="form-horizontal validate" method="post" action="#" enctype="multipart/form-data" >
                                
                                <div class="modal-body with-padding">
                                    					
                                    <div class="form-group-sm">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <center><label style="color:red;font: size:100px;"><i class="bi bi-exclamation-triangle" style="font-size: 1rem;"></i>  ¿ Está seguro de cambiar el Estado de esta Conferencia ?  <i class="bi bi-exclamation-triangle" style="font-size: 1rem;"></i></label></center>
                                                </div>
                                                <div class="col-md-3"></div>
                                        </div> <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Titulo<span class="mandatory">*</span></label>   
                                                <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" tabindex="1" readonly>
                                                <input type="hidden" id="estado" name="estado" >
                                                <input type="hidden" id="id_conferencia" name="id_conferencia" >
                                                <input type="hidden" id="id_usr"     name="id_usr" value="<?php echo $id_user; ?>" >
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
                                            <div class="col-md-3" >
                                                <label>Cupo<span class="mandatory">*</span></label>   
                                                <input type="text" id="cupo" name="cupo" class="form-control form-control-sm" tabindex="5" readonly>
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
                                                    <input type="text" id="titulo" name="titulo" class="form-control form-control-sm" tabindex="1" required>
                                                    <input type="hidden" id="id_evento"      name="id_evento">
                                                    <input type="hidden" id="id_conferencia" name="id_conferencia">
                                                    <input type="hidden" id="id_user"        name="id_user" value="<?php echo $id_user; ?>" >
                                                </div>
                                            </div>  <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Disertante<span class="mandatory">*</span></label>
                                                    <input type="text" id="disertante" name="disertante" class="form-control form-control-sm" tabindex="2" required>
                                                </div>
                                                <div class="col-md-6" id="div_select_org_mdf"> 
                                                    <label>Organismo Organizador<span class="mandatory">*</span></label>
                                                    <select id="id_organismo" name="id_organismo" class="form-select form-control-sm" tabindex="3" required >
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
                                                    <select id="modalidad" name="modalidad" class="form-select form-control-sm" onChange="show_divmdf(this)" tabindex="6" required>
                                                        <option value="OnLine">OnLine</option>
                                                        <option value="Presencial">Presencial</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="divcupomdf" name="divcupomdf">
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
                                                    <input type="date" id="f_inscrip_dsd" name="f_inscrip_dsd" class="form-control form-control-sm" tabindex="8" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Final<span class="mandatory">*</span></label>
                                                    <input type="date" id="f_inscrip_hst"  name="f_inscrip_hst"  class="form-control form-control-sm" tabindex="9" required>
                                                </div>
                                            </div> <br>
                                            <div class="row" id="divlugarmdf" name="divlugarmdf">
                                                <div class="col-md-12">
                                                    <label>Lugar<span class="mandatory">*</span></label>   
                                                    <input type="text" id="lugar" name="lugar" class="form-control form-control-sm" tabindex="10" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer"><center>					
                                    <button type="button" tabindex="11" class="btn btn-dark" onclick="window.location.href='./_conf_conferencias.php'" tabindex="11">Cancelar</button>
                                        <button id="validar_upd" name="validar_upd" type="button" class="btn btn-success" title="Se va a validar si se puede modificar." tabindex="12"> Modificar </button>
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
                            <input type="hidden" id="permiso_modf" name="permiso_modf" value="<?php echo $modf; ?>">
                            <input type="hidden" id="permiso_baja" name="permiso_baja" value="<?php echo $baja; ?>">
                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        
                            <div class="widget-content widget-content-area br-8">
                                <table id="dt_conferencias" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Titulo</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th aling='center'>Modificar</th>
                                            <th aling='center'>Modificar</th>
                                            <th aling='center'>Eliminar</th>
                                            <th aling='center'>Eliminar</th>
                                        </tr>
                                    </thead>
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

    <!-- Pone foco en el primer componente del Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalAdd = document.getElementById('modal_add');
            modalAdd.addEventListener('shown.bs.modal', function () {   document.getElementById('titulo').focus();        });
            
            var modalUpd = document.getElementById('modal_mdf');
            modalUpd.addEventListener('shown.bs.modal', function () {   document.getElementById('titulo').focus();     });
        });
    </script> 

</body>
</html>

