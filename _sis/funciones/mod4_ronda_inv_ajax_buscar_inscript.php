<?php
include('./mod4_ronda_inv.php');    $RI = new RondaInversiones();

if (isset($_POST["b"]))  { $id  = $_POST["b"];  } else { $id  = ''; }  

$arr_inscript_i = array();
$arr_inscript_i = $RI->gets_inscrip_x_id($id, 'i'); 

$arr_inscript_o = array();
$arr_inscript_o = $RI->gets_inscrip_x_id($id, 'o');     
?>

<!-- TABS -->
<div class="simple-pill">

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-i" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Inversores</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-o" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Oferentes</button>
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


    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="./src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/jszip.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="./src/plugins/src/table/datatable/button-ext/buttons.print.min.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
	
    <SCRIPT type="text/javascript" >
        $('#dt_i').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' }
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
            "pageLength": 5 
        });
    </SCRIPT>

    <SCRIPT type="text/javascript" >
        $('#dt_o').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' }
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
            "pageLength": 5 
        });
    </SCRIPT>
