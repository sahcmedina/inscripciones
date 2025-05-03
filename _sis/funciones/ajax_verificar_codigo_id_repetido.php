<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $cod_id = $_POST['cod_id']; 
	  
	  if(!empty($cod_id)) {	comprobar($cod_id);  	}
	  else{					echo 'Error';		}
       
    function comprobar($cod_id) {    
		include('./concursantes.php');		$Conc = new Concursantes();
		$existe= $Conc->tf_existe_codigo_id($cod_id);
		
		if($existe){ 
			?><label>Código de Identificación:<span class="mandatory">*</span></label><font color="red"> (Ya existe)</font><?php
		}else{
			?><label>Código de Identificación:<span class="mandatory">*</span></label><font color="green"> (Ok)</font><?php
		}	
	}     
?>