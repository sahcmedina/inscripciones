<?php
	$url = $_POST['url'];
	$url_ = './images/comite/'.$url;
?>

<div class="col-md-2">
	<div class="block">
		<div class="thumbnail">
			<div class="thumb">
				<img id="img_actual" name="img_actual" src="<?php echo $url_; ?>" width="20" height="20" >
			</div>
		</div>
	</div>
</div>
