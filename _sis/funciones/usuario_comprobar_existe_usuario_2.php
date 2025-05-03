<?php
      $nbre = $_POST['b'];          
      if(!empty($nbre)) {	comprobar($nbre);                                                               }
      else{ 			echo "<label style='font-weight:bold;color:red;'> Usuario: '$nbre' </label>";   }
       
      function comprobar($nbre) {
            include('usuario.php');       $User = New Usuario();
            $arr = array();
            $arr = $User->gets_datos_persona($nbre);
            if(count($arr) == 0 ){  echo "<label style='font-weight:bold;color:green;'> Usuario: Disponible </label>";        }
            else{                   echo "<label style='font-weight:bold;color:red;'> Usuario: Ya existe </label>";     	}
      }     
?>