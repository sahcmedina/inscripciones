<?php
if (isset($_POST["id"])) { $id          = $_POST["id"]; } else { $id          = ''; }
if (isset($_POST["t"]))  { $titulo      = $_POST["t"];  } else { $titulo      = ''; }
if (isset($_POST["u"]))  { $url         = $_POST["u"];  } else { $url         = ''; }
if (isset($_POST["d"]))  { $descripcion = $_POST["d"];  } else { $descripcion = ''; }
if (isset($_POST["c"]))  { $contenido   = $_POST["c"];  } else { $contenido   = ''; }
$url_ = './images/noticias/'.$url;
?>

<div class="row">
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
		<div class="block">
	   		<div class="thumbnail">
	   			<div class="thumb">
					<img src="<?php echo $url_; ?>" width="100" height="100" >
				</div>
	   		</div>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<center><h3> <?php echo $titulo; ?></h3></center> 
	</div>
</div>

<hr>
<div class="row">
	<div class="col-md-12">
		<label>Descripcion</label>
	    <p><?php echo $descripcion; ?></p> 
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<label>Contenido</label>
		<p> <?php echo $contenido; ?></p> 
	</div>
</div>
