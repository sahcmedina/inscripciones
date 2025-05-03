<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $id = $_POST['id']; 
	  
	  if(!empty($id)) {	comprobar($id);  }else{
			echo '';
	  }
       
    function comprobar($id) {    
		include('./capacitaciones.php');	
		$Cap     = new Capacitaciones();
		// Traigo el string de la imagen	
		$string= '';
		$string= $Cap->get_imagen_de_un_curso($id);
		
		if($string == ''){ ?>
			<div class="col-md-2">
				<div class="block">
					<div class="thumbnail">
						<div class="thumb">
							<img id="myImg" style="width: 70%; height: 70%;" src="" Alt="Imagen no Disponible">
						</div>
					</div>
				</div>
			</div>
		<?php
		}else{
			$image = base64_encode($string); ?>
			<div class="col-md-2">
				<div class="block">
					<div class="thumbnail">
						<div class="thumb">
							<img id="myImg" style="width: 70%; height: 70%;" src="data:image/jpeg;base64,<?php echo $image ?>">
						</div>
					</div>
				</div>
			</div>
		<?php
		}	
	}     
?>