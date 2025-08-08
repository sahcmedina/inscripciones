<style>
    .btn-export {
        margin-top: 1px;
        margin-bottom: 1px;
        margin-left: 5px; /* Separar hacia la derecha */
        margin-right: 5px; /* Espacio entre el botón de exportar y el selector */
        background-color: #65b688 !important;
	    color: white !important;
    }
    .btn-cantidad {
        margin-top: 1px;
        margin-bottom: 1px;
        margin-left: 5px; /* Separar hacia la derecha */
        margin-right: 5px; /* Espacio entre el botón de exportar y el selector */
        background-color: #e6f4ff !important;
	    color: black !important;
    }
    .btn-cantidad:hover {
        background-color: #f0f0f0;
        color: blue;
        border-color: blue;
    }
</style>

<?php
include('./mod4_ronda_inv.php');    $RI = new RondaInversiones();
if (isset($_POST["b"]))  { $id  = $_POST["b"];  } else { $id  = ''; }
$nombre='todos_los_inscriptos';
if($id ==0){
    $arr_todos = array();
    $arr_todos = $RI->gets_todos_los_inscrip(); 
    
    if(count($arr_todos) > 0){	?>
        <!-- datatable mostrar todos los inscriptos -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <table id="dt_t" class="table dt-table-hover" style="width:100%">
                        <?php
                            $tabla= "<thead><tr class=\"rowHeaders\">			
                                <th style='text-align:center'> id   	 </th>
                                <th style='text-align:center'> Nombre	 </th>
                                <th style='text-align:center'> Telefono  </th>
                                <th style='text-align:center'> Email 	 </th>
                                <th style='text-align:center'> Provincia </th>
                                <th style='text-align:center'> Rol       </th>
                                <th style='text-align:center'> Empresa   </th>
                                <th style='text-align:center'> Ronda     </th>
                                <th style='text-align:center'> Inicio    </th>";
                            $tabla.="</tr></thead><tbody>";			
                            echo $tabla;
                            for($j=0 ; is_array($arr_todos) && $j<count($arr_todos) ; $j++){
                                $cur  = $arr_todos[$j];
                                echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
                                    . '<td style="text-align:center">'. $cur['id']    	."</td>\n"
                                    . '<td style="text-align:center">'. $cur['persona'] ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['tel']     ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['email']   ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['prov']    ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['rol']     ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['emp']     ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['ronda']   ."</td>\n"
                                    . '<td style="text-align:center">'. $cur['f_dia_1'] ."</td>\n"
                                    . "</tr>\n";
                            }
                            echo "</tbody>";
                        ?>  
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN datatable mostrar todos los inscriptos -->
    <?php
    }else{
        echo '<center><span style="font-weight:bold;color:red;">No existen inscriptos para mostrar </span></center>';
    }
}else{
    $arr_inscript_i = array();
    $arr_inscript_i = $RI->gets_inscrip_x_id($id, 'i');
     
    $arr_inscript_o = array();
    $arr_inscript_o = $RI->gets_inscrip_x_id($id, 'o');
    
    $nom= $RI->get_datos_ri_segun_id($id);
    $nom_i = 'inversores_de_'.$nom[0]['nombre'];
    $nom_o = 'oferentes_de_'.$nom[0]['nombre'];
?>
    <!-- TABS -->
    <div class="simple-pill">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active position-relative mb-2 me-4" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-i" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    <span class="btn-text-inner"> Inversores</span>
                    <span class="badge badge-info counter">
                        <?php echo count($arr_inscript_i); ?>
                    </span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link position-relative mb-2 me-4" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-o" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                    <span class="btn-text-inner"> Oferentes</span>
                    <span class="badge badge-info counter">
                        <?php echo count($arr_inscript_o); ?> 
                    </span>
                </button>
            </li>                            
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-i" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                
                <!-- DT Inversores -->
                <?php if(count($arr_inscript_i) > 0){	?>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="dt_i" class="table dt-table-hover" style="width:100%">
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
                                    for($j=0 ; is_array($arr_inscript_i) && $j<count($arr_inscript_i) ; $j++){
                                        $cur  = $arr_inscript_i[$j];
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
                    echo '<center><span style="font-weight:bold;color:red;">No hay Inversores inscriptos </span></center>';
                } ?>
                <!-- Fin - DT Inversores -->

            </div>
            <div class="tab-pane fade" id="pills-o" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                <!-- DT Oferenctes -->
                <?php if(count($arr_inscript_o) > 0){	?>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="dt_o" class="table dt-table-hover" style="width:100%">
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
                                    for($j=0 ; is_array($arr_inscript_o) && $j<count($arr_inscript_o) ; $j++){
                                        $cur  = $arr_inscript_o[$j];
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
                    echo '<center><span style="font-weight:bold;color:red;">No hay Oferentes inscriptos </span></center>';
                } ?>
                <!-- Fin - DT Oferentes -->

            </div>
        </div>

    </div>
    <!-- FIN TABS -->
<?php
}
?>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="./src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/jszip.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/buttons.print.min.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
	
    <!-- Configuracion datatable de todos los inscriptos SCRIPTS -->
    <SCRIPT type="text/javascript" >
        $('#dt_t').DataTable({
           "dom": "<'dt--top-section'<'row'<'col-sm-6 col-sm-3 d-flex justify-content-sm-start justify-content-center'l <'col-sm-12 col-md-6 d-flex'B>><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + 
           "<'table-responsive'tr>" +
           "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { text: 'Total Inscriptos: '+<?php echo count($arr_todos); ?>, 
                      className: 'btn btn-sm btn-cantidad'  
                    },
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
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });
    </SCRIPT>

    <!-- Configuracion datatable de los inversores de una RI SCRIPTS -->
    <SCRIPT type="text/javascript" >
        $('#dt_i').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-sm-6 col-sm-3 d-flex justify-content-sm-start justify-content-center'l <'col-sm-12 col-md-6 d-flex'B>><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + 
           "<'table-responsive'tr>" +
           "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'excel', 
                        className: 'btn btn-success btn-sm btn-export', 
                        title: '',
                        filename: function () {
                            var nombre = '<?php echo $nom_i; ?>';
                            return 'Inscriptos '+nombre;
                        }
                    },
                    { extend: 'print', 
                        className: 'btn btn-success btn-sm btn-export', 
                        title: '', 
                        filename: function () {
                            var nombre = '<?php echo $nom_i; ?>';
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
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });
    </SCRIPT>

    <!-- Configuracion datatable de los oferentes de una RI SCRIPTS -->
    <SCRIPT type="text/javascript" >
        $('#dt_o').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-sm-6 col-sm-3 d-flex justify-content-sm-start justify-content-center'l <'col-sm-12 col-md-6 d-flex'B>><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + 
           "<'table-responsive'tr>" +
           "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'excel', 
                        className: 'btn btn-success btn-sm btn-export', 
                        title: '',
                        filename: function () {
                            var nombre = '<?php echo $nom_o; ?>';
                            return 'Inscriptos '+nombre;
                        }
                    },
                    { extend: 'print', 
                        className: 'btn btn-success btn-sm btn-export', 
                        title: '', 
                        filename: function () {
                            var nombre = '<?php echo $nom_o; ?>';
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
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5 
        });
    </SCRIPT>
