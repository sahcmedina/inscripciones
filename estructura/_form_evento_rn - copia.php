<?php

if (isset($_SESSION['ses_id_evento']))     	{ $id= $_SESSION['ses_id_evento']; }    else { $id= '';      }

include("_sis/funciones/pais_prov.php");    $Pais= new Pais_prov();

$arr_  = array();
$arr_  = $Eve->gets($id); 
$titulo= $arr_[0]['titulo'];

$arr_prov = array();
$arr_prov = $Pais->gets_provincias();

?>


<div class="u-form u-form-1">
  <!-- <form action="https://forms.nicepagesrv.com/v2/form/process" class="u-clearfix u-form-spacing-28 u-form-vertical u-inner-form" source="email" name="form" style="padding: 0px;"> -->
  
    <!-- <form name="form" id="form" method="post" class="u-clearfix u-form-spacing-28 u-form-vertical u-inner-form" style="padding: 0px;" action="../_sis/funciones/inscriptos_form_rn.php" > -->
    
    <!-- <form name="form" id="form" method="post" class="u-clearfix u-form-spacing-28 u-form-vertical u-inner-form" style="padding: 0px;" action="./estructura/inscriptos_form_rn.php" > -->

    <form action="./estructura/inscriptos_form_rn.php" class="u-clearfix u-form-spacing-28 u-form-vertical u-inner-form" method="post" name="form" style="padding: 0px;">

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
          <option value="c" data-calc="">Comprar</option>
          <option value="v" data-calc="">Vender </option>
        </select>
        <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
      </div>
    </div>

    <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3">
      <label for="select-29f3" class="u-label">Provincia</label>
      <div class="u-form-select-wrapper">
        <select id="prov" name="prov" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-2" ><?php
          for ($i = 0; $i < count($arr_prov); $i++)
            echo '<option value="'.$arr_prov[$i]['id'].'"'.'>'.$arr_prov[$i]['nombre']."</option>\n";?>
        </select>
        <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
      </div>
    </div>
    
    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-4">
      <label for="emp" class="u-label">Nombre de la Empresa:</label>
      <input type="text" id="emp" name="emp" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
    </div>
    
    <div class="u-form-email u-form-group u-form-partition-factor-2 u-form-group-5">
      <label for="cuit" class="u-label">CUIT:</label>
      <input type="text" id="cuit" name="cuit" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-4" required="">
    </div>
    
    <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-6">
      <label for="name-8e54" class="u-label">Persona responsable:</label>
      <input type="text" id="resp" name="resp" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-5" required="">
    </div>
    
    <div class="u-form-group u-form-partition-factor-3 u-form-phone u-form-group-7">
      <label for="phone-84d9" class="u-label">Teléfono:</label>
      <input type="text" id="tel" name="tel" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-6" required="">
    </div>
    
    <div class="u-form-group u-form-partition-factor-3 u-form-group-8">
      <label for="email" class="u-label">Email:</label>
      <input type="text" placeholder="" id="email" name="email" class="u-border-2 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-7">
    </div>
    
    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
      <button type="submit" value="submit" class="u-active-custom-color-5 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-hover-custom-color-3 u-radius u-btn-1">Enviar</button>
    </div>

    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
      <a href="./estructura/inscriptos_form_rn.php" class="u-active-custom-color-5 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-hover-custom-color-3 u-radius u-btn-1">Ir </a>
      <input type="submit" value="submit" class="u-form-control-hidden">
    </div> 


    <!-- <div class="u-form-send-message u-form-send-success">Gracias! Tu mensaje ha sido enviado.</div> -->
    <!-- <div class="u-form-send-error u-form-send-message">No se puede enviar su mensaje. Por favor, corrija los errores y vuelva a intentarlo.</div> -->
    <!-- <input type="hidden" value="" name="recaptchaResponse"> -->
    <!-- <input type="hidden" name="formServices" value="bd81a2eb-7b10-7091-0f17-69e434a8b6e5"> -->

  </form>
</div>