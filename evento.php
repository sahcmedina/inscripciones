<?php

  if (isset($_GET['i']))     	{ $id= $_GET['i']; }    else { $id= '';      }

  include('_sis/funciones/eventos.php'); 	$Eve = new Eventos();
  $arr_  = array();
  $arr_  = $Eve->gets($id); 
  $titulo= $arr_[0]['titulo'];

?>

<!DOCTYPE html>
<html style="font-size: 16px;" lang="es"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Nuestros trabajos, nos encanta hacer, Trabajos recientes, Creatividad con el poder de transformar">
    <meta name="description" content="">
    <title>evento</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="evento.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 7.7.3, nicepage.com">
    <meta name="referrer" content="origin">
    
    
    
    
    
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "",
		"logo": "images/logo.png"
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="evento">
    <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
  <body data-path-to-root="./" data-include-products="false" class="u-body u-xl-mode" data-lang="es"><header class="u-clearfix u-header u-sticky u-sticky-c45e u-white u-header" id="header"><div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <a href="#" class="u-image u-logo u-image-1" data-image-width="646" data-image-height="92" target="_blank">
          <img src="images/logo.png" class="u-logo-image u-logo-image-1">
        </a>
        <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-2" src="images/ciudadanodigital.png" alt="" data-image-width="201" data-image-height="72" data-href="#" data-target="_blank">
      </div><style class="u-sticky-style" data-style-id="c45e">.u-sticky-fixed.u-sticky-c45e, .u-body.u-sticky-fixed .u-sticky-c45e {
box-shadow: 5px 5px 20px 0 rgba(0,0,0,0.4) !important
}</style></header>
    <section class="u-align-center u-clearfix u-container-align-center u-grey-10 u-section-1" src="" id="carousel_ef82">
      <img class="u-expanded-width u-image u-image-1" src="images/Vector.png" data-image-width="1440" data-image-height="441">
      <img class="u-image u-image-round u-radius u-image-2" src="images/blanco.jpg" alt="" data-image-width="6000" data-image-height="4000">
      <h2 class="u-align-center u-custom-font u-font-montserrat u-text u-text-default u-text-1"><span style="font-weight: 400;"> Ministerio de</span> Producción, Trabajo e Innovación
      </h2>
      <img class="u-image u-image-default u-preserve-proportions u-image-3" src="images/F.svg" alt="" data-image-width="16" data-image-height="29">
      <img class="u-image u-image-default u-preserve-proportions u-image-4" src="images/X.svg" alt="" data-image-width="26" data-image-height="24">
      <img class="u-image u-image-default u-preserve-proportions u-image-5" src="images/instagram.svg" alt="" data-image-width="24" data-image-height="24">
      <img class="u-image u-image-default u-preserve-proportions u-image-6" src="images/youtube.svg" alt="" data-image-width="27" data-image-height="19">
    </section>
    <section class="u-clearfix u-grey-10 u-section-2" id="block-1">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-container-style u-expanded-width u-group u-radius u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <div class="custom-expanded u-align-center u-container-align-center u-container-style u-custom-color-4 u-group u-radius u-group-2">
              <div class="u-container-layout u-container-layout-2">
                <h1 class="u-custom-font u-font-montserrat u-text u-text-white u-text-1"><?php echo $titulo ?> </h1>
              </div>
            </div>
            <div class="u-container-style u-group u-white u-group-3">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-container-layout-3">
                <p class="u-text u-text-2">Tipo de Evento:<br>
                  <br>Fecha:&nbsp;<br>
                  <br>Lugar:
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-grey-10 u-section-3" id="sec-9946">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-sheet-1">
        <div class="u-container-style u-expanded-width u-group u-radius u-shape-round u-white u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <div class="custom-expanded u-align-center u-container-align-center u-container-style u-custom-color-4 u-group u-radius u-group-2">
              <div class="u-container-layout u-container-layout-2">
                <h1 class="u-custom-font u-font-montserrat u-text u-text-white u-text-1">Formulario de inscripción</h1>
              </div>
            </div>
            <div class="u-container-style u-group u-white u-group-3">
              <div class="u-container-layout u-container-layout-3">
                <div class="u-form u-form-1">
                  <form action="https://forms.nicepagesrv.com/v2/form/process" class="u-clearfix u-form-spacing-28 u-form-vertical u-inner-form" source="email" name="form" style="padding: 0px;">
                    <div class="u-form-checkbox-group u-form-group u-form-group-1">
                      <label class="u-label">Productos a comercializar:</label>
                      <div class="u-form-checkbox-group-wrapper">
                        <div class="u-input-row">
                          <input id="field-c404" type="checkbox" name="checkbox-1[]" value="Item 1 lllllllllllllll kkkkkkkkkkkkkkkkkkk nnnnnnnnnnnnnn" class="u-field-input" checked="checked" data-calc="">
                          <label class="u-field-label" for="field-c404">Item 1 lllllllllllllll kkkkkkkkkkkkkkkkkkk nnnnnnnnnnnnnn</label>
                        </div>
                        <div class="u-input-row">
                          <input id="field-d13d" type="checkbox" name="checkbox-1[]" value="Item 2 ffffffffff ddddddddddddddddddddddddd" class="u-field-input" data-calc="">
                          <label class="u-field-label" for="field-d13d">Item 2 ffffffffff ddddddddddddddddddddddddd</label>
                        </div>
                        <div class="u-input-row">
                          <input id="field-e77f" type="checkbox" name="checkbox-1[]" value="Item 3 mmmm ddddddddddd ssssssssssss" class="u-field-input" data-calc="">
                          <label class="u-field-label" for="field-e77f">Item 3 mmmm ddddddddddd ssssssssssss</label>
                        </div>
                        <div class="u-input-row">
                          <input id="field-0695" type="checkbox" name="checkbox-1[]" value="item4" class="u-field-input" data-calc="">
                          <label class="u-field-label" for="field-0695">item4</label>
                        </div>
                      </div>
                    </div>
                    <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-2">
                      <label for="select-abbf" class="u-label">Como va a participar?</label>
                      <div class="u-form-select-wrapper">
                        <select id="select-abbf" name="select" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-1">
                          <option value="Item 1" data-calc="">Item 1</option>
                          <option value="Item 2" data-calc="">Item 2</option>
                          <option value="Item 3" data-calc="">Item 3</option>
                        </select>
                        <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
                      </div>
                    </div>
                    <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3">
                      <label for="select-29f3" class="u-label">Provincia</label>
                      <div class="u-form-select-wrapper">
                        <select id="select-29f3" name="select-1" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-2">
                          <option value="Item 1" data-calc="">Item 1</option>
                          <option value="Item 2" data-calc="">Item 2</option>
                          <option value="Item 3" data-calc="">Item 3</option>
                        </select>
                        <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
                      </div>
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-4">
                      <label for="name-8e54" class="u-label">Nombre de la Empresa:</label>
                      <input type="text" id="name-8e54" name="name-2" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
                    </div>
                    <div class="u-form-email u-form-group u-form-partition-factor-2 u-form-group-5">
                      <label for="email-c6a3" class="u-label">CUIT:</label>
                      <input type="email" id="email-c6a3" name="email" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-4" required="">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-6">
                      <label for="name-8e54" class="u-label">Persona responsable:</label>
                      <input type="text" id="name-8e54" name="name-1" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-5" required="">
                    </div>
                    <div class="u-form-group u-form-partition-factor-3 u-form-phone u-form-group-7">
                      <label for="phone-84d9" class="u-label">Teléfono:</label>
                      <input type="tel" pattern="\+?\d{0,3}[\s\(\-]?([0-9]{2,3})[\s\)\-]?([\s\-]?)([0-9]{3})[\s\-]?([0-9]{2})[\s\-]?([0-9]{2})" id="phone-84d9" name="phone" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-6" required="">
                    </div>
                    <div class="u-form-group u-form-partition-factor-3 u-form-group-8">
                      <label for="text-de71" class="u-label">Email:</label>
                      <input type="text" placeholder="" id="text-de71" name="text" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-7">
                    </div>
                    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
                      <a href="#" class="u-active-custom-color-4 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-custom-font u-font-montserrat u-hover-custom-color-4 u-radius u-btn-1">Enviar </a>
                      <input type="submit" value="submit" class="u-form-control-hidden">
                    </div>
                    <div class="u-form-send-message u-form-send-success">Gracias! Tu mensaje ha sido enviado.</div>
                    <div class="u-form-send-error u-form-send-message">No se puede enviar su mensaje. Por favor, corrija los errores y vuelva a intentarlo.</div>
                    <input type="hidden" value="" name="recaptchaResponse">
                    <input type="hidden" name="formServices" value="bd81a2eb-7b10-7091-0f17-69e434a8b6e5">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    
    <footer class="u-align-center u-clearfix u-container-align-center u-footer u-grey-80 u-valign-bottom-lg u-valign-bottom-md u-valign-bottom-sm u-valign-bottom-xs u-footer" id="footer"><div class="data-layout-selected u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
          <div class="u-layout-row">
            <div class="u-container-style u-layout-cell u-size-13 u-layout-cell-1">
              <div class="u-container-layout u-container-layout-1">
                <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-1" src="images/Logo-San-Juan-Blanco.svg" alt="" data-image-width="180" data-image-height="71" data-href="#" data-target="_blank">
              </div>
            </div>
            <div class="u-container-style u-layout-cell u-size-5 u-layout-cell-2">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-container-layout-2">
                <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-2" src="images/pilares.svg" alt="" data-image-width="45" data-image-height="46" data-href="#" data-target="_blank">
              </div>
            </div>
            <div class="u-container-style u-layout-cell u-size-32 u-layout-cell-3">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-container-layout-3">
                <p class="u-align-left u-small-text u-text u-text-variant u-text-1"> Centro CívicoAvenida Libertador General San Martín 750 Oeste | C.P: 5400 | San Juan | Argentina Conmutador:&nbsp;(0264) 459 2201<br>5º piso Núcleo 4 - ingreso 3<br>Horarios de Atención de 7:30hs a 13:30hs
                </p>
              </div>
            </div>
            <div class="u-container-style u-layout-cell u-size-10 u-layout-cell-4">
              <div class="u-container-layout u-container-layout-4">
                <div class="u-expanded-width u-list u-list-1">
                  <div class="u-repeater u-repeater-1">
                    <div class="u-container-align-center u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-5">
                        <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-3" src="images/Face-abajo.svg" alt="" data-image-width="16" data-image-height="29" data-href="#" data-target="_blank">
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-6">
                        <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-4" src="images/X-abajo.svg" alt="" data-image-width="150" data-image-height="138" data-href="#" data-target="_blank">
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-7">
                        <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-5" src="images/Insta-abajo.svg" alt="" data-image-width="150" data-image-height="150" data-href="#" data-target="_blank">
                      </div>
                    </div>
                    <div class="u-container-style u-list-item u-repeater-item">
                      <div class="u-container-layout u-similar-container u-container-layout-8">
                        <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-6" src="images/Youtube-abajo.svg" alt="" data-image-width="150" data-image-height="106" data-href="#" data-target="_blank">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div></footer>
  
</body></html>