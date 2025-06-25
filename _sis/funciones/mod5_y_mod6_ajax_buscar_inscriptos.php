<?php
date_default_timezone_set('America/Argentina/San_Juan');
include('./mod5_conferencias.php');	$Con  = new Conferencias();
include('./mod6_foros.php');	    $For  = new Foros();

// recibo los datos id del evento y el tipo de evento F o C.
if (isset($_POST["b"]))  { $id  = $_POST["b"];  } else { $id  = ''; }
if (isset($_POST["e"]))  { $ev  = $_POST["e"];  } else { $ev  = ''; }

// --------------------- FUNCION ------------------------------------
$inscriptos = array(); $nombre=''; $evento='';
// Si selecciono la opcion "Elija..." llega el valor 0 es decir No selecciono ninguna conferencia o foro
if($id > 0){
    switch ($ev) {
        case 'F':
            $nombre= 'al Foro '.$For->get_nombre_evento_segun_id($id); 
            $evento = 'este Foro';
            $inscriptos= $For->gets_inscriptos_foro_segun_id($id);        
        break;
        case 'C':
            $nombre= 'a la Conferencia '.$Con->get_nombre_evento_segun_id($id); 
            $evento = 'esta Conferencia'; 
            $inscriptos= $Con->gets_inscriptos_conferencia_segun_id($id);
        break;
    }
    if(count($inscriptos) > 0){		// SI HAY DATOS MUESTRO EL DATATABLE SINO MUESTRO UN MENSAJE.
    
    ?>
        <style>
            .btn-export {
                margin-top: 1px;
                margin-bottom: 1px;
                margin-left: 5px; /* Separar hacia la derecha */
                margin-right: 5px; /* Espacio entre el botón de exportar y el selector */
                background-color: #65b688 !important;
		        color: white !important;
            }
        </style>
        <!-- muestro el datatable -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <table id="dt_inscriptos" class="table dt-table-hover" style="width:100%">
                            <?php
                            $tabla= "<thead><tr class=\"rowHeaders\">			
                                <th style='text-align:center'> id   	 </th>
                                <th style='text-align:center'> Apellido	 </th>
                                <th style='text-align:center'> Nombre 	 </th>
                                <th style='text-align:center'> DNI 	     </th>
                                <th style='text-align:center'> Telefono  </th>
                                <th style='text-align:center'> Email     </th>
                                <th style='text-align:center'> Empresa   </th>
                                <th style='text-align:center'> Cargo     </th>
                                <th style='text-align:center'> Localidad </th>";
                            $tabla.="</tr></thead><tbody>";			
                            echo $tabla;
                            for($j=0 ; is_array($inscriptos) && $j<count($inscriptos) ; $j++){
                                $cur  = $inscriptos[$j];
                                echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                    . '<td style="text-align:center">'. $cur['id']    	."</td>\n"
                                    . '<td style="text-align:center">'. $cur['apellido']  ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['nombre'] ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['dni'] ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['telefono']  ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['email']."</td>\n"
                                    . '<td style="text-align:center">'. $cur['empresa']."</td>\n"
                                    . '<td style="text-align:center">'. $cur['cargo']."</td>\n"
                                    . '<td style="text-align:center">'. $cur['departamento']."</td>\n"
                                    . "</tr>\n";
                            }
                            echo "</tbody>";
                        ?>  
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }else{
        echo '<center><span style="font-weight:bold;color:red;">No hay Inscriptos en '.$evento.'</span></center>';
    }
}else{
    switch ($ev) {
        case 'F': echo '<center><span style="font-weight:bold;color:red;">Por Favor seleccione un Foro del selector.</span></center>';
        break;
        case 'C': echo '<center><span style="font-weight:bold;color:red;">Por Favor seleccione una Conferencia del selector.</span></center>';
        break;
    }
}
?>



<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- <script src="./src/plugins/src/table/datatable/datatables.js"></script>-->
<script src="./src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="./src/plugins/src/table/datatable/button-ext/jszip.min.js"></script>
<script src="./src/plugins/src/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="./src/plugins/src/table/datatable/button-ext/buttons.print.min.js"></script>
<!-- <script src="./src/plugins/src/table/datatable/custom_miscellaneous.js"></script> -->
<!-- END PAGE LEVEL SCRIPTS -->
	
<SCRIPT type="text/javascript" >
    $('#dt_inscriptos').DataTable({
    "dom": "<'dt--top-section'<'row'<'col-sm-6 col-sm-3 d-flex justify-content-sm-start justify-content-center'l <'col-sm-12 col-md-6 d-flex'B>><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + 
           "<'table-responsive'tr>" +
           "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        buttons: {
            buttons: [
                { extend: 'excel', 
                  className: 'btn btn-success btn-sm btn-export', 
                  title: '',
                  filename: function () {
                    var nombre = '<?php echo $nombre; ?>';
                    return 'Inscriptos '+nombre;
                  }
                },
                { extend: 'print', 
                  className: 'btn btn-success btn-sm btn-export', 
                  title: '', 
                  filename: function () {
                    var nombre = '<?php echo $nombre; ?>';
                    return 'Inscriptos '+nombre;
                  } 
                }
            ]
        },
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
        "pageLength": 10 
    });
</SCRIPT>
