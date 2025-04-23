<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $var = $_POST['id_cat'];         
        
      if(!empty($var)) {	comprobar($var);  }else{
			echo '';
	  }
       
    function comprobar($var) {    
		
		include('./capacitaciones.php');	
		$Cap     = new Capacitaciones();
	
		// Traigo los Dptos	
		$arr_cat= array();
		$arr_cat= $Cap->gets_all_categorias();
	      
	    ?>  			
		<div class="col-md-3">
				<div><label>Categoria</label></div>
	         		 <select id="categoria" name="categoria" class="select-full" tabindex="9" required >
	         		 <?php
			           	for ($i = 0; $i < count($arr_cat); $i++)
							echo '<option value="' . $arr_cat[$i]['id'] . '"' . (isset($var) && $arr_cat[$i]['id'] == $var ? ' selected="selected"' : '') . '>' .$arr_cat[$i]['nombre']. "</option>\n";?>	
			        </select> 
		</div>	   		 
		<?php            
      }     
?>