<?php
      $var = $_POST['dep'];        
        
      if(!empty($var)) {	comprobar($var);  }else{
			echo '';
	  }
       
    function comprobar($var) {    		
		include('./mod2_depositos.php'); 	$Dep = new Depositos();
		$arr_dep= array();
		$arr_dep= $Dep->gets();
	    
	    ?>			
		<div class="col-md-3">
		<label>Depositos<span class="mandatory">*</span></label>   
			<select id="dep_" name="dep_" class="form-select dep_ form-control-sm" tabindex="2" required>	
	    	<?php
		   		for ($i = 0; $i < count($arr_dep); $i++)
					echo '<option value="' . $arr_dep[$i]['id'] . '"' . (isset($var) && $arr_dep[$i]['id'] == $var ? ' selected="selected"' : '') . '>' .$arr_dep[$i]['codigo'].' - P170'."</option>\n";?>	
			</select>  
		</div>	
	<?php            
    }     
?>