<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $dni = $_POST['dni']; 
	  
	  if(!empty($dni)) {	comprobar($dni);  	}
	  else{					echo 'Error';		}
       
    function comprobar($dni) {    
		include('./concursantes.php');		$Conc = new Concursantes();
		$existe= $Conc->tf_esta_dni($dni);
		
		if($existe){ 
			?><label>DNI:<span class="mandatory">*</span></label><font color="red"> (Ya existe)</font><?php
		}else{
			?><label>DNI:<span class="mandatory">*</span></label><font color="green"> (Ok)</font><?php
		}	
	}     
?>