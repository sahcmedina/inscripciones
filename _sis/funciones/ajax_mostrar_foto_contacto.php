<?php

	$id = $_POST['id'];
	include('./contactos.php');	
	$C     = new Contacto();
	$nombre= $C->get_foto_del_contacto($id);
	$url_ = './images/contacto/'.$nombre;
?>
<div class="col-md-2"></div>
<div class="col-md-2">
	<div class="block">
		<div class="thumbnail">
			<div class="thumb">
				<img id="foto_actual1" name="foto_actual1" src="<?php echo $url_; ?>" width="100" height="100" >
				<?php echo $nombre; ?>
				<input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $nombre; ?>" >
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
			<input  type="file" id="foto" name="foto" accept="image/png, image/jpeg" tabindex="17" class="form-control" required>
		</div>
	</div>
</div>
