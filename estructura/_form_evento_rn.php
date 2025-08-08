<?php
include_once("_sis/funciones/pais_prov.php");           $Pais      = new Pais_prov();
include_once('_sis/funciones/mod3_productos.php');      $Productos = new Productos();
include_once('_sis/funciones/mod3_ronda_neg.php');      $RondaNeg  = new RondaNegocios();

$arr_     = array();
$arr_     = $Eve->gets($id); 
$titulo   = $arr_[0]['titulo'];
$id_evento= $arr_[0]['fk_evento'];

$arr_prov = array();
$arr_prov = $Pais->gets_provincias();

$arr_prod= array();
$arr_prod= $Productos->gets_evento($id_evento);
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
<!-- 2 columnas en productos -->
<style> 
.u-form-checkbox-group-wrapper {
    display: grid; /* Usamos Grid para crear la cuadrícula */
    grid-template-columns: repeat(2, 1fr); /* Definimos 2 columnas, cada una ocupando el mismo espacio (1fr) */
    gap: 3px; /* Espacio entre las celdas de la cuadrícula (entre los checkboxes) */
}
.checkbox-item {
    display: flex; /* Usamos Flexbox para alinear el checkbox y el label dentro de cada celda */
    align-items: center; /* Centramos verticalmente el checkbox y el label */
    gap: 5px; /* Espacio pequeño entre el checkbox y su label */
}
/* Opcional: Ajustes de estilo para el label si es necesario */
.u-form-checkbox-group-wrapper .u-field-label {
    margin-left: 5; /* Aseguramos que el margin left por defecto sea 0 si hay algún estilo previo */
}
</style>

<div class="u-form u-form-1">

    
  <form name='form' id='form' method="POST" action="./estructura/inscriptos_form_rn.php" class="u-inner-form">

    <!-- Productos -->
    <div class="u-form-checkbox-group u-form-group u-form-group-1">
      <label class="u-label">Productos a comercializar:</label>
      <div class="u-form-checkbox-group-wrapper">

        <?php for($i=0 ; $i<count($arr_prod) ; $i++){ ?>
          <div class="checkbox-item"> 
              <input type="checkbox" name="chek[]" id="chek[]" value="<?php echo $arr_prod[$i]['id'] ?>" class="u-field-input" data-calc="" >
              <label class="u-field-label"> <?php echo $arr_prod[$i]['nombre'] ?>  </label>
              <input type="hidden"  id="id" name="id" value="<?php echo $id_evento ?>">
          </div>
        <?php } ?>

      </div>
    </div>

    <!-- Como va a participar && Provincia -->
    <div class="u-form-row">

      <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-2">
        <label for="select-abbf" class="u-label">Como va a participar?</label>
        <div class="u-form-select-wrapper">
          <select id="c_v" name="c_v" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-1">
            <option value="c" data-calc="">Comprar</option>
            <option value="v" data-calc="">Vender </option>
          </select>
          <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
        </div>
      </div>

      <div class="u-form-group u-form-partition-factor-2 u-form-select u-form-group-3">
        <label for="select-29f3" class="u-label">Provincia</label>
        <div class="u-form-select-wrapper">
          <select id="prov" name="prov" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-2" ><?php
            for ($i = 0; $i < count($arr_prov); $i++)
              echo '<option value="'.$arr_prov[$i]['id'].'"'.'>'.$arr_prov[$i]['nombre']."</option>\n";?>
          </select>
          <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve"><polygon class="st0" points="8,12 2,4 14,4 "></polygon></svg>
        </div>
      </div>

    </div>

    <!-- Empresa && CUIT -->
    <div class="u-form-row">

      <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-4">
        <label for="emp" class="u-label">Nombre de la Empresa:</label>
        <input type="text" id="emp" name="emp" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-3" required="">
      </div>
      
      <div class="u-form-email u-form-group u-form-partition-factor-2 u-form-group-5">
        <label for="cuit" class="u-label">CUIT:</label>
        <input type="text" id="cuit" name="cuit" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-4" required="">
      </div>

    </div>

    <!-- Responsable && Telefono && Email -->
    <div class="u-form-row">

      <div class="u-form-group u-form-name u-form-partition-factor-3 u-form-group-6">
        <label for="name-8e54" class="u-label">Persona responsable:</label>
        <input type="text" id="resp" name="resp" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-5" required="">
      </div>
      
      <div class="u-form-group u-form-partition-factor-3 u-form-phone u-form-group-7">
        <label for="phone-84d9" class="u-label">Teléfono:</label>
        <input type="text" id="tel" name="tel" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-6" required="">
      </div>

      <div class="u-form-group u-form-partition-factor-3 u-form-group-8">
        <label for="email" class="u-label">Email:</label>
        <input type="text" placeholder="" id="email" name="email" class="u-border-1 u-border-custom-color-3 u-border-no-left u-border-no-right u-border-no-top u-custom-font u-font-montserrat u-input u-input-rectangle u-none u-input-7">
      </div>
        
    </div>

    <div class="u-align-center u-form-group u-form-submit u-form-group-9">
      <button type="button" onclick="history.back()" class="u-border-none u-btn u-btn-round u-btn-submit u-button-style u-radius u-btn-1" style="background-color: #443C44; color: white;"> Volver </button>		                                    
      <button type="submit" value="submit" class="u-active-custom-color-5 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-color-3 u-hover-custom-color-3 u-radius u-btn-1">Guardar</button>
      <input type="submit" value="submit" class="u-form-control-hidden">
    </div> 

  </form>

</div>