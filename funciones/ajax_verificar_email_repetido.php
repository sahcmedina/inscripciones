<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
      $email = $_POST['correo']; 
	  
	  if(!empty($email)) {	comprobar($email);  	}
	  else{					echo 'Error';		}
       
    function comprobar($email) {    
		include('./concursantes.php');		$Conc = new Concursantes();

		// Correo valido?
		$valido = true;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {	$valido = false;	} 

		// Existe?
		$existe= $Conc->tf_esta_email($email);
		
		if($valido){
			if($existe){ ?><label>Correo Electronico:<span class="mandatory">*</span></label><font color="red"> (Ya existe) </font><?php }
			else{		 ?><label>Correo Electronico:<span class="mandatory">*</span></label><font color="green"> (No se repite) </font><?php      }	
		}else{
			?><label>Correo Electronico:<span class="mandatory">*</span></label><font color="red"> (No es valido) </font><?php
		} 
	}     
?>