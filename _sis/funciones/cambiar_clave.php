<?php 
session_start();
require_once('usuario.php');	$Usua = new Usuario();

if (isset($_POST["new_pass"]))   { $new_pass = $_POST["new_pass"];      } else { $new_pass = '';   }
if (isset($_POST["id_user_2"]))  { $id_user_ = $_POST["id_user_2"];     } else { $id_user_ = '';   }

$opc= 'ok';
if($new_pass=='' OR $id_user_=='')  $opc= 'er';

switch ($opc){
    case 'ok': 
                $upd = $Usua->upd_pass($new_pass, $id_user_);
                if($upd){   $a_ico= 'success';	$a_tit= 'Contraseña cambiada';	        $a_sub= '';                                         }
                else{       $a_ico= 'error'; 	$a_tit= 'Error al cambiar Contraseña';	$a_sub= 'Ocurrio un error. Intente de nuevo.';      }            
                break;

    case 'er':  $a_ico= 'error'; 	$a_tit= 'Error al cambiar Contraseña';	  $a_sub= 'Faltaron datos. Intente de nuevo.';         
                break;

    default  :  break; 
}
$_SESSION['alert_tit']= $a_tit; 	$_SESSION['alert_sub']= $a_sub;	   $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../principal.php"; </script>