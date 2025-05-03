<?php

	$nombre = $_POST['url'];
	$url_ = './images/sponsor/'.$nombre;
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
