<?php 
  $arr_2 = array();
  $arr_2 = $Eve->gets_activos(); 
  $knt   = count($arr_2);  
?>

<section class="u-clearfix u-grey-5 u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-section-4" id="sec-b096">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="data-layout-selected u-clearfix u-layout-wrap u-layout-wrap-1">
          <div class="u-gutter-0 u-layout">
            <div class="u-layout-row">
              <div class="u-size-17">
                <div class="u-layout-col">
                  <div class="u-container-style u-hidden-sm u-hidden-xs u-image u-layout-cell u-left-cell u-size-60 u-image-1" data-image-width="2560" data-image-height="2445" data-animation-name="customAnimationIn" data-animation-duration="1000" data-animation-delay="0">
                    <div class="u-container-layout u-container-layout-1"></div>
                  </div>
                </div>
              </div>
              <div class="u-size-43">
                <div class="u-layout-col">
                  <div class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-container-style u-gradient u-hover-feature u-layout-cell u-right-cell u-size-60 u-white u-layout-cell-2" data-animation-name="customAnimationIn" data-animation-duration="1000" data-animation-delay="0">
                    <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-container-layout-2">
                      <h2 class="u-align-center u-custom-font u-font-montserrat u-text u-text-1">Agenda de &nbsp;<b style="">EVENTOS</b>
                      </h2>
                      <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-default u-text-2">A continuación podrás ver todos los eventos que tenemos para invitarte, acompañanos... </p>
                      <div class="u-expanded-width u-table u-table-responsive u-table-1">
                        <table class="u-table-entity u-table-entity-1">
                          <colgroup>
                            <col width="15.2%"><col width="26%"><col width="42.2%"><col width="16.6%">
                          </colgroup>
                          <thead class="u-align-center u-custom-font u-font-montserrat u-table-header u-table-header-1">
                            <tr>
                              <th class="u-border-2 u-border-grey-75 u-border-no-left u-border-no-right u-table-cell">Fecha</th>
                              <th class="u-border-2 u-border-grey-75 u-border-no-left u-border-no-right u-table-cell">TIPO</th>
                              <th class="u-border-2 u-border-grey-75 u-border-no-left u-border-no-right u-table-cell">Evento</th>
                              <th class="u-border-2 u-border-grey-75 u-border-no-left u-border-no-right u-table-cell">MÁS INFO</th>
                            </tr>
                          </thead>
                          <tbody class="u-align-center u-custom-font u-font-montserrat u-table-body">

                            <?php 
                              for($i=0 ; $i<count($arr_2) ; $i++){
                                $titulo = $arr_2[$i]['titulo'];
                                $fecha  = $arr_2[$i]['fecha'];
                                $mes    = $arr_2[$i]['mes'];
                                $dia    = $arr_2[$i]['dia'];
                                $tipo   = $arr_2[$i]['tipo'];
                                $lugar  = $arr_2[$i]['lugar'];
                                $id     = $arr_2[$i]['id'];
                                switch($tipo){
                                  case 'RN': $tipo_= 'Ronda de Negocios';   break;                     case 'RI': $tipo_= 'Ronda de Inversión';  break;    
                                  case 'C' : $tipo_= 'Conferencias';        break;                     case 'F' : $tipo_= 'Foro';                break;    
                                }
                                switch($mes){
                                  case '01': $mes_= 'Ene';   break;                                    case '07': $mes_= 'Jul';  break;    
                                  case '02': $mes_= 'Feb';   break;                                    case '08': $mes_= 'Ago';  break;    
                                  case '03': $mes_= 'Mar';   break;                                    case '09': $mes_= 'Sep';  break;    
                                  case '04': $mes_= 'Abr';   break;                                    case '10': $mes_= 'Oct';  break;    
                                  case '05': $mes_= 'May';   break;                                    case '11': $mes_= 'Nov';  break;    
                                  case '06': $mes_= 'Jun';   break;                                    case '12': $mes_= 'Dic';  break;    
                                }
                        
                              ?>
                            <tr style="height: 39px;">
                              <td class="u-table-cell"><?php echo $mes_.' - '.$dia ?></td>
                              <td class="u-table-cell"><?php echo $tipo_           ?></td>
                              <td class="u-table-cell"><?php echo $titulo          ?></td>
                              <td class="u-table-cell"><a href="./evento.php?i=<?php echo $id; ?>" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1" style="border-radius: 10px !important; font-size: 10px !important;">Inscribirme </a></td>
                            </tr>

                            <?php } ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
</section>  