
<?php
      $var = $_POST['prov'];         
        
      if(!empty($var)) {	comprobar($var);  }else{
			echo '';
	  }
       
    function comprobar($var) {    		
		include('./comunes_pais_prov.php'); 	$Pais = new Pais_prov();
		$arr_prov= array();
		$arr_prov= $Pais->gets_provincias();
	      
	    ?>			
		<div class="col-md-3">
		<label>Provincia<span class="mandatory">*</span></label>   
			<select id="prov_" name="prov_" class="form-select prov_ form-control-sm" tabindex="4" required >
	    	<?php
		   		for ($i = 0; $i < count($arr_prov); $i++)
					echo '<option value="' . $arr_prov[$i]['id'] . '"' . (isset($var) && $arr_prov[$i]['id'] == $var ? ' selected="selected"' : '') . '>' .$arr_prov[$i]['nombre']. "</option>\n";?>	
			</select>  
		</div>	
	<?php            
    }     
?>