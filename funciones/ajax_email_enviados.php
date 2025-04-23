<?php

if (isset($_POST["id"]))       { $id= utf8_decode($_POST["id"]);        } else { $id= '';   }

if(!empty($id)) {	gets_detalles($id);  }else{
	echo '<div id="ver_email_enviados_ajax" ><label style="font-weight:bold;color:red;"> No hay datos registrados, consulte con el Administrador del Sistema </label></div>'; 
  }

function gets_detalles($id) { 
	?>
	<SCRIPT type="text/javascript" >
	  $(document).ready(function() {
		  $("#dt_enviados").dataTable({
		  });					             
	  });
  </script>
  
  <?php
	include('./email.php'); 			$Email= new Email();

	// listado de emails enviados
	$arr_email_enviados= array();
	$arr_email_enviados= $Email->gets_cuerpo_email_enviados($id);
  
  ?>
  <hr />
	  <table id="dt_enviados" class="table table-striped table-bordered" class="datatable">
			  <?php 
			  
			  $tabla= "<thead><tr class=\"rowHeaders\">
						<th style='text-align:center'> Persona      	</th>
						<th style='text-align:center'> DNI  			</th>
						<th style='text-align:center'> Email			</th>
						<th style='text-align:center'> Estado del envio </th>";
			  $tabla.="</tr></thead><tbody>";			
			  echo $tabla;
			  $acum =0;								
			  for($j=0 ; is_array($arr_email_enviados) && $j<count($arr_email_enviados) ; $j++){
				  $cur  = $arr_email_enviados[$j];

				  switch($cur['estado_envio']){
					case '0': $estado= 'ok'; 			break;
					case '1': $estado= 'error'; 		break;
					default : $estado= 'sin novedad'; 	break;
				  }
				  
				  echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
					  . '<td style="text-align:center">'. $cur['persona']		   	."</td>\n"
					  . '<td style="text-align:center">'. $cur['fk_inscripto'] 	   	."</td>\n"
					  . '<td style="text-align:center">'. $cur['email'] 	       	."</td>\n"
					  . '<td style="text-align:center">'. $estado					."</td>\n"
					  . "</tr>\n";
			  }
			  echo "</tbody>";?>
	  </table>	  
  <?php
}  

?>