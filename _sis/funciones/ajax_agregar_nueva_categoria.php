<!-- <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
<?php
$opcion  = $_POST['o'];  
if(!empty($opcion)) {	comprobar($opcion);  }
       
function comprobar($opcion) {
  	if ($opcion == 'a'){
		echo '<label>Agregar Nueva Categoria</label>
			  <input  type="text" id="add_categoria" name="add_categoria" class="form-control" tabindex="2" required>';
	}else{ 
		echo '<label hidden>Agregar Nueva Categoria</label>
			  <input  type="hidden" id="add_categoria" name="add_categoria" class="form-control" tabindex="2">';
	}	
}      
?>