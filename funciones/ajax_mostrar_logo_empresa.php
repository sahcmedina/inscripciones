<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script> -->

<!-- <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css"> -->

<!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
<!-- <script type="text/javascript" src="js/application.js"></script> -->

<!-- <script type="text/javascript">
 function si_cambia_imagen(selectTag){
 	if(selectTag.value == 'No' ){
 		document.getElementById('mostrar_input').hidden = true;	
 	}else{
 		document.getElementById('mostrar_input').hidden = false;		
 	}	 		
 }
</script> -->

<?php

	$id = $_POST['id'];
	include('./sponsor.php');	
	$S     = new Sponsor();
	$nombre= $S->get_logo_de_una_empresa($id);
	$url_ = './images/sponsor/'.$nombre;
?>
<div class="col-md-2"></div>
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
			<select id="cambia_img" name="cambia_img" class="form-control" onChange="si_cambia_imagen(this)" tabindex="9">
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
			<input  type="file" id="logo" name="logo" accept="image/png, image/jpeg" tabindex="10" class="form-control" required>
		</div>
	</div>
</div>
