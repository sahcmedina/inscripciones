<?php
$form  = $_POST['f'];
$dir_form  = $_POST['d'];
if(!empty($form)) {	comprobar($form, $dir_form);  }
       
function comprobar($form, $dir_form) {
  	if ($form == 'form_google'){
		echo '<label>Direccion del Formulario</label>
			  <input type="text" id="dir_form_google" name="dir_form_google" value="'.$dir_form.'" class="form-control" tabindex="2" required >';
	}else{ 
		echo '<label>Formulario Web</label>
			  <input type="text" id="dir_form_google" name="dir_form_google" class="form-control" tabindex="2" readonly>';
	}	
}      
?>


