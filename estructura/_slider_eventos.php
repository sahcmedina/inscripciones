<?php 
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
  
  include('./_sis/funciones/eventos.php'); 	$Eve = new Eventos();
  $arr_ = array();
  $arr_ = $Eve->gets_activos(); 
  $knt  = count($arr_);
  
?>

<!-- Modal -->
<div class="modal fade" id="ModalValidar" name="ModalValidar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" >Ingrese DNI para validar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="form_del_user" id="form_del_user" class="form-horizontal validate" method="post" action="./evento.php" enctype="multipart/form-data" >
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label for="dni" class="u-label">DNI</label>
              <input type="text" id="dni" name="dni" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="" tabindex="1">
            </div>
          </div> <br>
          <div class="row">
            <div class="col-md-5">
              <input type="hidden" id="id_evento" name="id_evento" class="form-control" />
              <input type="hidden" id="fk_evento" name="fk_evento" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" tabindex="2" >Cerrar</button>
          <button type="submit" class="btn btn-danger" tabindex="3">Validar</button>
        </div>
      </form>
    </div>
  </div>
</div>


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
                    $lugar  = $arr_[$i]['lugar'];
                    $id_1     = $arr_[$i]['id'];
                    $fkevento_1 = $arr_[$i]['fk_evento'];
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
                      <br>Lugar: <?php echo $lugar ?>
                    </p>
                      <?php if($tipo == 'C' OR $tipo == 'F'){ ?>
                        <button type="button" class="btn u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1" data-bs-toggle="modal" data-bs-target="#ModalValidar" data-idevento="<?php echo $id_1 ?>" data-fkevento="<?php echo $fkevento_1 ?>"> Inscribirme </button>
                      <?php }else{ ?>
                      <a href="./evento.php?i=<?php echo $id_1; ?>" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1">Inscribirme </a>
                      <?php } ?>
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
                    $id_2     = $arr_[$j]['id'];
                    $fkevento_2 = $arr_[$j]['fk_evento'];
                    $titulo_2 = $arr_[$j]['titulo'];
                    $fecha_2  = $arr_[$j]['fecha'];
                    $lugar_2  = $arr_[$j]['lugar'];
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
                        <br>Lugar: <?php echo $lugar_2 ?>
                      </p>
                      <?php if($tipo_2 == 'C' OR $tipo_2 == 'F'){ ?>
                        <button type="button" class="btn u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1" data-bs-toggle="modal" data-bs-target="#ModalValidar" data-idevento="<?php echo $id_2 ?>" data-fkevento="<?php echo $fkevento_2 ?>"> Inscribirme </button></a>
                      <?php }else{ ?>
                        <a href="./evento.php?i=<?php echo $id_2; ?>" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-radius u-text-body-alt-color u-btn-1">Inscribirme </a>
                      <?php } ?>
                        
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

<!-- Pasar datos al modal para MOSTRALOS haciendo consulta por ajax -->

<script language="javascript">
const ModalValidar = document.getElementById('ModalValidar');
  ModalValidar.addEventListener('show.bs.modal', function (event) {
    const boton = event.relatedTarget;
      
    const idevento = boton.getAttribute('data-idevento');
    const fkevento = boton.getAttribute('data-fkevento');
      
    const id_eventoModal = document.getElementById('id_evento');
    const fk_eventoModal = document.getElementById('fk_evento');
      
    id_eventoModal.value = idevento;
    fk_eventoModal.value = fkevento;
  });
</script>


