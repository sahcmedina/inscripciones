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
	
		// Traigo los Dptos	
		$arr_req= array();
		$arr_req= $Cap->gets_requisitos_de_un_curso($id);
		$cont_req =1;
		?>
		<div class="block-inner">
			<h6 class="heading-hr">
				<i class="icon-map"></i> Requisitos para la Capacitación <small class="display-block">Listado de Requisitos</small>
			</h6>
		</div>
		<?php

		if(count($arr_req) == 0){ ?> 
			<CENTER><LABEL>PARA ESTE CURSO NO EXISTEN REQUISITOS QUE CUMPLIR</LABEL></CENTER>
		<?php }else{
			for ($i=0; $i<count($arr_req); $i++ ){ ?>
				<div class="row">
					<div class="col-md-3">
						<label>Requisito <?php echo $cont_req; ?> </label> 
					</div>
					<div class="col-md-7">
						<label>Descripcion</label>
						<input  type="text" id="requisito" name="requisito" value="<?php echo $arr_req[$i]['descripcion']; ?>" class="form-control" tabindex="15" readonly > <br>
					</div>
					<div class="col-md-2"></div>
				</div>
				<?php $cont_req++ ;
			}
		}
	}     
?>