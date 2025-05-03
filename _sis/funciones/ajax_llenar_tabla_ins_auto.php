<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $var = $_POST['ins_auto_'];     
	  if(!empty($var)) {	comprobar($var);  }else{
			echo '';
	  }
       
    function comprobar($var) {    
		$arr_si_no= array();
		$arr_si_no= ['NO', 'SI'];
	      
	    ?>  			
		<div class="row">
			<center>  <label>Inscripción automática</label></center>
		</div>
		<div class="row">
			<select id="ins_auto" name="ins_auto" class="select-full control" tabindex="9" required >
	     		 <?php
		       	for ($i = 0; $i < count($arr_si_no); $i++)
					echo '<option value="' . $i . '"' . (isset($var) && $i == $var ? ' selected="selected"' : '') . '>' .$arr_si_no[$i]. "</option>\n";?>	
		    </select> 
		</div>
	<?php            
    }     
?>