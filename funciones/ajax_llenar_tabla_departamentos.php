<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $var = $_POST['id_depto'];         
        
      if(!empty($var)) {	comprobar($var);  }else{
			echo '';
	  }
       
    function comprobar($var) {    
		
		include('./capacitaciones.php');	
		$Cap     = new Capacitaciones();
	
		// Traigo los Dptos	
		$arr_depto= array();
		$arr_depto= $Cap->gets_departamentos();
	      
	    ?>
		<div class="col-md-3">  			
			<label>Departamento</label>
	    	<select id="departamento" name="departamento" class="select-full" tabindex="9" required >
	    	<?php
		   		for ($i = 0; $i < count($arr_depto); $i++)
					echo '<option value="' . $arr_depto[$i]['id'] . '"' . (isset($var) && $arr_depto[$i]['id'] == $var ? ' selected="selected"' : '') . '>' .utf8_encode($arr_depto[$i]['nombre']). "</option>\n";?>	
			</select> 
		</div>   		 
	<?php            
    }     
?>