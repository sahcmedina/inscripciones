<?php
      $nbre = $_POST['b'];           
      if(!empty($nbre)) {	comprobar($nbre);                                                                   }
      else{       		echo "<label style='font-weight:bold;color:red;'> Usuario: Necesario </label>"; 	}
       
      function comprobar($nbre) {
            include_once('usuario.php');       $User2 = New Usuario();
            $existe = $User2->tf_repite_login($nbre);
            if(!$existe){  echo "<label style='font-weight:bold;color:green;'> Usuario: Disponible </label>";     }
            else{          echo "<label style='font-weight:bold;color:red;'> Usuario: Ya existe </label>";     	}
      }     
?>