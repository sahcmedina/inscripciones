<?php      
    if (isset($_POST["cod_mat"]))  { $cod_mat= $_POST["cod_mat"];  } else {  $cod_mat= '';  }
	if (isset($_POST["destino"]))  { $destino= $_POST["destino"];  } else {  $destino= '';  }
	if (isset($_POST["depo_log"])) { $depo_log=$_POST["depo_log"]; } else {  $depo_log= ''; }
    
      if($cod_mat!='' && $destino!='' && $depo_log!='') { comprobar($cod_mat, $destino, $depo_log);  }else{	echo '<center><b><i>No se recibieron datos.</i></b></center>';  }
       
    function comprobar($cod_mat, $destino, $depo_log) { 
		include('./mod2_ingresos.php');     $Ing = new Ingresos();
		$arr_mat = array();
		$arr_mat = $Ing->gets_materialEnDepo($cod_mat, $depo_log);

		?>
			<label>Origen <span class="mandatory">*</span></label>   
			<select id="origen" name="origen" class="form-select origen form-control-sm" tabindex="5" ><?php
				for ($i=0; $i < count($arr_mat); $i++)
						echo '<option value="'.$arr_mat[$i]['tabla'].'-'.$arr_mat[$i]['id'].'"'.'>' .'Deposito: '.$arr_mat[$i]['dep'].' - Cant: '.$arr_mat[$i]['total']."</option>\n";
				?>	
			</select> 
		<?php 						
    }     
?>