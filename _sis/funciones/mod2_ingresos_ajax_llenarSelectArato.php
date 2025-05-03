
<?php      
      $tratam_1= $_POST['tra']; 
      $dep     = $_POST['dep']; 
    
      if($tratam_1!='') { comprobar($tratam_1, $dep);  }else{	echo '<center><b><i>No se recibieron datos.</i></b></center>';  }
       
    function comprobar($tratam_1, $dep) { 
		
		if($tratam_1 == 'P'){
			include('./mod2_aratos.php');     $Arato = new Aratos();
			$arr_aratos= array();
			$arr_aratos= $Arato->gets_segun_dep($dep);
		
			?>
			<label>Arato <span class="mandatory">*</span></label>   
			<select id="arato_1" name="arato_1" class="form-select arato_1 form-control-sm" tabindex="3" ><?php
				echo '<option value="0" > Ninguno </option>';
				for ($i = 0; $i < count($arr_aratos); $i++)
					echo '<option value="'.$arr_aratos[$i]['id'].'"'.'>' .$arr_aratos[$i]['codigo']."</option>\n";
				?>	
			</select> 
		<?php 				
		}								
    }     
?>