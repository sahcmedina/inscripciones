<?php
      $nbre  = $_POST['b'];            
      $id_cli= $_POST['id_cli'];            

      if(!empty($nbre)) {	comprobar($nbre, $id_cli);                                                            }
      else{ 			echo "<label style='font-weight:bold;color:red;'> Nombre: Necesario </label>";        }
       
      function comprobar($nbre, $id_cli) {
            include('usuario.php');       $User = New Usuario();
            $existePerfil = $User->tf_repite_perfil($nbre, $id_cli);
	      
            if(!$existePerfil){     echo "<label style='font-weight:bold;color:green;'> Nombre: Disponible </label>";  }
            else{                   echo "<label style='font-weight:bold;color:red;'> Nombre: Ya existe </label>";     }
      }     
?>