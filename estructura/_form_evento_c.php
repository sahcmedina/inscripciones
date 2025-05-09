<?php

if (isset($_SESSION['ses_id_evento']))     	{ $id= $_SESSION['ses_id_evento']; }    else { $id= '';      }

include("_sis/funciones/mod5_conferencias.php");   $Con = new Conferencias();

$arr_  = array();
$arr_  = $Eve->gets($id); 
$fk_evento= $arr_[0]['fk_evento'];

$arr_localidades = array();
$arr_localidades = $Con->gets_localidades();
?>

<style>  
  /* Contenedor para campos en línea */
  .u-form-row {
      display: flex;
      flex-wrap: wrap;
      margin-left: -10px;
      margin-right: -10px;
  }
  
  /* Estilos para cada grupo de formulario */
  .u-form-group {
      margin-bottom: 20px;
      padding: 0 10px;
      box-sizing: border-box;
  }

  /* Factor de partición para columnas */
  .u-form-partition-factor-2 {     width: 50%;  }
  .u-form-partition-factor-3 {     width: 33.3%;  }
  
  /* En dispositivos móviles, cambia a una columna */
  @media (max-width: 767px) {
      .u-form-partition-factor-2 {         width: 100%;      }
      .u-form-partition-factor-3 {         width: 100%;      }
  }
</style>

<div class="u-form u-form-1">

  <form name="formInsc" id="formInsc" method="post" action="./estructura/inscriptos_form_c.php" class="u-inner-form" role="form" enctype="multipart/form-data">  
    <!-- DNI Apellido Nombre -->
    <div class="u-form-row">

            <input type="hidden" class="form-control" id="idevento" name="idevento" value="<?php echo $arr_[0]['id']; ?>" readonly>
            <input type="hidden" class="form-control" id="fkevento" name="fkevento" value="<?php echo $arr_[0]['fk_evento']; ?>" readonly>

      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-1">
        <label for="dni" class="u-label">DNI</label>
        <input type="text" id="dni" name="dni" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>

      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-2">
        <label for="apellido" class="u-label">Apellido</label>
        <input type="text" id="apellido" name="apellido" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-3">
        <label for="nombre" class="u-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>

    </div> <br>

    <!-- Telefono && Email -->
    <div class="u-form-row">

      <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-4">
        <label for="phone-84d9" class="u-label">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-6" required="">
      </div>

      <div class="u-form-group u-form-partition-factor-2 u-form-group-5">
        <label for="email" class="u-label">Email:</label>
        <input type="text" placeholder="" id="email" name="email" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-7">
      </div>
        
    </div> <br>

    <!-- Empresa Cargo Localidad -->
    <div class="u-form-row">

      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-6">
        <label for="emp" class="u-label">Nombre de la Empresa:</label>
        <input type="text" id="empresa" name="empresa" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
      
      <div class="u-form-email u-form-group u-form-partition-factor-3 u-form-group-7">
        <label for="cuit" class="u-label">Cargo</label>
        <input type="text" id="cargo" name="cargo" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-4" required="">
      </div>

      <div class="u-form-group u-form-partition-factor-3 u-form-select u-form-group-8">
        <label for="select-29f3" class="u-label">Localidad</label>
        <div class="u-form-select-wrapper">
          <select id="localidad" name="localidad" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-2" ><?php
            for ($i = 0; $i < count($arr_localidades); $i++)
              echo '<option value="'.$arr_localidades[$i]['id'].'"'.'>'.$arr_localidades[$i]['nombre']."</option>\n";?>
          </select>
          <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
        </div>
      </div>

    </div> <br>

    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
      <input type="submit" value="submit" class="u-form-control-hidden">
      <button type="button" onclick="history.back()" class="u-border-none u-btn u-btn-round u-btn-submit u-button-style u-radius u-btn-1" style="background-color: #443C44; color: white;"> Volver </button>
      <button type="submit" value="submit" class="u-active-custom-color-5 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-hover-custom-color-3 u-radius u-btn-1">Inscribirse</button>
    </div> 

  </form>

</div>