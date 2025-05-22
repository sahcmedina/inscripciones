<?php

include("_sis/funciones/mod6_foros.php");   $For = new Foros();

if (isset($_SESSION['ses_id_evento'])) { $id_evento = $_SESSION['ses_id_evento']; } else{ $id_evento = ''; }
if (isset($_SESSION['ses_fk_evento'])) { $fk_evento = $_SESSION['ses_fk_evento']; } else{ $fk_evento = ''; };
if (isset($_SESSION['ses_dni']))     	 { $dni       = $_SESSION['ses_dni'];       } else{ $dni       = ''; };

$arr_inscrip   = array();
$estado=''; $btn_estado =''; $estado_select='';
$apellido =''; $nombre  ='';  $telefono ='';
$email    =''; $empresa ='';  $cargo    ='';
$localidad = ''; $esta='';

$arr_inscrip = $For->tf_dni_inscripto_evento($dni, $fk_evento); // ya esta inscripto ???
if(count($arr_inscrip) > 0){
  $estado='readonly'; $btn_estado ='disabled'; $estado_select='disabled'; $esta='si';
  $apellido = $arr_inscrip[0]['apellido']; $nombre  =$arr_inscrip[0]['nombre'];  $telefono =$arr_inscrip[0]['telefono'];
  $email    = $arr_inscrip[0]['email'];    $empresa =$arr_inscrip[0]['empresa']; $cargo    =$arr_inscrip[0]['cargo'];
  $localidad = $arr_inscrip[0]['localidad'];
}else{
  $arr_inscrip = $For->get_datos_dni_inscripto($dni);
  if(count($arr_inscrip)>0){
    // YA ESTA INSCRIPOTO EN OTRO FORO. MUESTROS LOS INPUT CON SUS DATOS EN MODO EDITABLES.
    $apellido = $arr_inscrip[0]['apellido']; $nombre  =$arr_inscrip[0]['nombre'];  $telefono =$arr_inscrip[0]['telefono'];
    $email    = $arr_inscrip[0]['email'];    $empresa =$arr_inscrip[0]['empresa']; $cargo    =$arr_inscrip[0]['cargo'];
    $localidad = $arr_inscrip[0]['localidad'];
  }
}
$arr_localidades = array();
$arr_localidades = $For->gets_localidades();
?>

<!DOCTYPE html><html style="font-size: 16px;" lang="es">
  
<head>

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

</header>
<body>
  

<br>

<div class="u-form u-form-1">


  <form name="formInsc" id="formInsc" method="post" action="./estructura/inscriptos_form_f.php" class="u-inner-form" role="form" enctype="multipart/form-data">

    <!-- DNI Apellido Nombre -->
    <?php if($esta =='si'){ ?>
    <div class="u-form-row">
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-1"></div>
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-2">      
      <center>
        <h2 class="u-align-center u-custom-font u-font-montserrat u-text u-text-default u-text-1"><span style="font-weight: 300;">Ya se encuentra Inscripto en este Foro</span></h2>
      </center>
      </div>
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-3"></div>
    </div> <br>
    <?php } ?>
    <div class="u-form-row">
      
            <input type="hidden" id="fkevento" name="fkevento" value="<?php echo $fk_evento; ?>" >
      
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-1">
        <label for="dni" class="u-label">DNI</label>
        <input type="text" id="dni" name="dni" value="<?php echo $dni;?>" readonly class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
    
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-2">
        <label for="apellido" class="u-label">Apellido</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $apellido;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-3">
        <label for="nombre" class="u-label">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>

    </div> <br>

    <!-- Telefono && Email -->
    <div class="u-form-row">

      <div class="u-form-group u-form-partition-factor-2 u-form-phone u-form-group-4">
        <label for="phone-84d9" class="u-label">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $telefono;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-6" required="">
      </div>

      <div class="u-form-group u-form-partition-factor-2 u-form-group-5">
        <label for="email" class="u-label">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-7">
      </div>
        
    </div> <br>

    <!-- Empresa Cargo Localidad -->
    <div class="u-form-row">

      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-6">
        <label for="emp" class="u-label">Nombre de la Empresa:</label>
        <input type="text" id="empresa" name="empresa" value="<?php echo $empresa;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
      
      <div class="u-form-email u-form-group u-form-partition-factor-3 u-form-group-7">
        <label for="cuit" class="u-label">Cargo</label>
        <input type="text" id="cargo" name="cargo" value="<?php echo $cargo;?>" <?php echo $estado; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-4" required="">
      </div>

      <div class="u-form-group u-form-partition-factor-3 u-form-select u-form-group-8">
        <label for="select-29f3" class="u-label">Localidad</label>
        <div class="u-form-select-wrapper">
          <select id="localidad" name="localidad" <?php echo $estado_select; ?> class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-2" ><?php
            for ($i = 0; $i < count($arr_localidades); $i++)
              echo '<option value="' . $arr_localidades[$i]['id'] . '"' . (isset($localidad) && $arr_localidades[$i]['id'] == $localidad ? ' selected="selected"' : '') . '>' . $arr_localidades[$i]['nombre'] . "</option>\n";?>
          </select>
          <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
        </div>
      </div>

    </div> <br> 

    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
      <input type="submit" value="submit" class="u-form-control-hidden">
      <button type="button" onclick="window.location.href='./index.php'" class="u-btn-1 u-border-none u-btn-round u-button-style u-btn-canceled u-hover-custom-color-4 u-radius" style="background-color: #443C44; color: white;"> Volver </button> 
      <button type="submit" value="submit" <?php echo $btn_estado; ?> class="u-active-custom-color-5 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-hover-custom-color-3 u-radius u-btn-1">Inscribirse</button>
    </div> 

  </form>

</div>

</body>
</html>