<?php

	$foto = $_POST['foto_'];
	$url_ = './images/contacto/'.$foto;
?>
<div class="thumb"> 
	<img id="foto" name="foto" src="<?php echo $url_; ?>" width="100" height="100" >
</div>
