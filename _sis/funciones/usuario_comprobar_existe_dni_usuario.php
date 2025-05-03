<?php
      $dni = $_POST['b'];           
      if(!empty($dni)) {	comprobar($dni);                                                              }
      else{       		echo "<label style='font-weight:bold;color:red;'> DNI: Necesario </label>"; 	}
       
      function comprobar($dni) {
            include_once('usuario.php');       $User2 = New Usuario();   
            $existe = $User2->tf_repite_dni($dni);
            if(!$existe){  echo "<label style='font-weight:bold;color:green;'> DNI: Ok </label>";           }
            else{          echo "<label style='font-weight:bold;color:red;'> DNI: Ya existe </label>";     	}
      }     
?>