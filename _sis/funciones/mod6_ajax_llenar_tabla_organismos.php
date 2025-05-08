<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>

<?php
include('./mod6_foros.php'); $For = new Foros();
$var = $_POST['id_org']; 
	  
// Traigo los ORGANISMOS	
$arr_org= array();
$arr_org= $For->gets_all_organismos();
	      
?>
<label>Organismo Organizador<span class="mandatory">*</span></label>
<select id="organismomdf" name="organismomdf" class="form-select form-control-sm" tabindex="3" required >
	<?php
        for ($i = 0; $i < count($arr_org); $i++)
			echo '<option value="' . $arr_org[$i]['id'] . '"' . (isset($var) && $arr_org[$i]['id'] == $var ? ' selected="selected"' : '') . '>' .$arr_org[$i]['organismo']. "</option>\n";
	?>
</select>		

