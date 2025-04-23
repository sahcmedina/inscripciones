<?php

	$id = $_POST['id'];
	include('./comite.php');	
	$C     = new Comite();
	$url= $C->get_imagen_integrante_comite($id);
	$url_ = './images/comite/'.$url;
?>

<div class="col-md-2">
	<div class="block">
		<div class="thumbnail">
			<div class="thumb">
				<img id="img_actual" name="img_actual" src="<?php echo $url_; ?>" width="100" height="100" >
			</div>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="row">
		<div class="col-md-3">
			<label>Cambia Imagen?</label>
			<select id="cambia_img" name="cambia_img" class="form-control" onChange="si_cambia_imagen(this)" tabindex="2">
				<option selected="true" value="No">No</option>
				<option value="Si">Si</option>
			</select> 
		</div> <br>
	<div class="col-md-9">
	<label>Si desea Cambiar la imagen seleccione la opcion Si</label>
</div> <br>
</div> <br>
	<div class="row" >
		<div class="col-md-12" id="mostrar_input" hidden="true" >
			<label>Seleccione la Imagen para mostrar</label>
			<input  type="file" id="url_nueva" name="url_nueva"  tabindex="17" class="form-control" required>
		</div>
	</div>
</div>
