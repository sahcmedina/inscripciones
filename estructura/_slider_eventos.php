<?php 

  echo '1 - ACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA. ';
  include('._sis/funciones/eventos.php'); 	$Eve = new Eventos();
  $arr_ = array();
  $arr_ = $Eve->gets_activos(); 
  $knt  = count($arr_);
  echo '2 - ACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA. '.$knt;

?>

<section class="u-carousel u-carousel-duration-1000 u-slide u-block-71ab-1" id="carousel-9f8a" data-interval="5000" data-u-ride="carousel">

  <ol class="u-absolute-hcenter u-carousel-indicators u-block-71ab-2">
          <li data-u-target="#carousel-9f8a" class="u-active u-grey-30 u-shape-circle" style="width: 10px; height: 10px;" data-u-slide-to="0"></li>
          <li data-u-target="#carousel-9f8a" class="u-grey-30 u-shape-circle" style="width: 10px; height: 10px;" data-u-slide-to="1"></li>
  </ol>

  <div class="u-carousel-inner" role="listbox">

  <!-- Slider 1 -->
  <?php
    if($knt >0){ ?>
      
        <div class="u-active u-align-center u-carousel-item u-clearfix u-image u-shading u-section-3-1">
            <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
              <h2 class="u-align-center u-custom-font u-font-montserrat u-text u-text-1" data-animation-name="customAnimationIn" data-animation-duration="1500" data-animation-delay="0">Próximos Eventos</h2>
              <div class="u-expanded-width u-list u-list-1">
                <div class="u-repeater u-repeater-1">

                <?php 
                for($i=0 ; $i<3 ; $i++){

                  if($i < $knt){
                    $titulo = $arr_[$i]['titulo'];
                    $fecha  = $arr_[$i]['fecha'];
                    $tipo   = $arr_[$i]['tipo'];
                    $id     = $arr_[$i]['id'];
                    switch($tipo){
                      case 'RN': $tipo_= 'Ronda de Negocios';   break;    
                      case 'RI': $tipo_= 'Ronda de Inversión';  break;    
                      case 'C' : $tipo_= 'Conferencias';        break;    
                      case 'F' : $tipo_= 'Foro';                break;    
                    }
          
                ?>
                <div class="u-container-style u-list-item u-radius u-repeater-item u-shape-round u-white u-list-item-1" data-animation-name="customAnimationIn" data-animation-duration="1500">
                  <div class="u-container-layout u-similar-container u-valign-bottom-xl u-valign-top-lg u-valign-top-md u-valign-top-sm u-valign-top-xs u-container-layout-1">
                    <h4 class="u-align-center u-text u-text-2"> <?php echo $titulo ?> </h4>
                    <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-default u-text-3"> Tipo de Evento: <?php echo $tipo_ ?> 
                      <br><?php echo $fecha ?>
                      <br>Lugar
                    </p>
                    <a href="./evento.php?i=<?php echo $id; ?>" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1">Inscribirme </a>
                  </div>
                </div>

                <?php } 
                } 
                ?>  

                </div>
              </div>
            </div>
          </div>
  <?php } ?>


  <!-- Slider 2 -->
  <?php
    if($knt >3){ ?>
      
      <div class="u-align-center u-carousel-item u-clearfix u-image u-shading u-section-3-2" data-image-width="6000" data-image-height="4000">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <h2 class="u-align-center u-custom-font u-font-montserrat u-text u-text-1" data-animation-name="customAnimationIn" data-animation-duration="1500" data-animation-delay="0">Próximos Eventos</h2>
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">

                <?php 
                for($j=3 ; $j<6 ; $j++){

                  if($j < $knt){
                    $titulo_2 = $arr_[$j]['titulo'];
                    $fecha_2  = $arr_[$j]['fecha'];
                    $tipo_2   = $arr_[$j]['tipo'];
                    switch($tipo_2){
                      case 'RN': $tipo_2_= 'Ronda de Negocios';   break;    
                      case 'RI': $tipo_2_= 'Ronda de Inversión';  break;    
                      case 'C' : $tipo_2_= 'Conferencias';        break;    
                      case 'F' : $tipo_2_= 'Foro';                break;    
                    }
              
                  ?>
                  <div class="u-container-style u-list-item u-radius u-repeater-item u-shape-round u-white u-list-item-1" data-animation-name="customAnimationIn" data-animation-duration="1500">
                    <div class="u-container-layout u-similar-container u-valign-bottom-xl u-valign-top-lg u-valign-top-md u-valign-top-sm u-valign-top-xs u-container-layout-1">
                      <h4 class="u-align-center u-text u-text-2"> <?php echo $titulo_2 ?> </h4>
                      <p class="u-align-left u-custom-font u-font-montserrat u-text u-text-default u-text-3"> Tipo de Evento: <?php echo $tipo_2_ ?> 
                        <br><?php echo $fecha_2 ?>
                        <br>Lugar
                      </p>
                      <a href="" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1">Inscribirme </a>
                    </div>
                  </div>

                  <?php 
                  }   
                } 
              ?>  

                </div>
              </div>
            </div>
          </div>
  <?php } ?>

  </div>
        
  <a class="u-absolute-vcenter u-carousel-control u-carousel-control-prev u-text-grey-30 u-block-71ab-3" href="#carousel-9f8a" role="button" data-u-slide="prev"><span aria-hidden="true">
      <svg class="u-svg-link" viewBox="0 0 477.175 477.175"><path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225
                c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"></path></svg></span><span class="sr-only">Previo</span>
  </a>

  <a class="u-absolute-vcenter u-carousel-control u-carousel-control-next u-text-grey-30 u-block-71ab-4" href="#carousel-9f8a" role="button" data-u-slide="next"><span aria-hidden="true">
      <svg class="u-svg-link" viewBox="0 0 477.175 477.175"><path d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5
                c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z"></path></svg></span><span class="sr-only">Siguiente</span>
  </a>

</section>