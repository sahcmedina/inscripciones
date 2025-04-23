<?php 
session_start();

if (isset($_POST["id"]))    { $id= $_POST["id"];     } else { $id= ''; }

                $opc= 'ok';
if($id=='' )    $opc= 'er';

switch($opc){

    case 'ok':
                include ('usuario.php');   $U = new Usuario();
                // elimino usuario
                $del = $U->del_usuario_segun_id($id);
                // elimino perfil asociado
                $del_p = $U->del_perfil_asociado($id);                              
                if($del && $del_p){   
                    $a_ico= 'success';    $a_tit= 'Usuario Borrado';	         $a_sub= '';	    }
                else{       
                    $a_ico= 'error'; $a_tit= 'Error el Borrar'; 
                    if(!$del){     $a_sub= 'Intente de nuevo, no se pudo borrar el usuario';        }
                    if(!$del_p){   $a_sub= 'Intente de nuevo, no se pudo borrar el perfil';         }
                }
                break; 

    case 'er':
                $a_ico= 'error';      $a_tit= 'Error el Borrar';	$a_sub= 'Intente de nuevo, faltaron datos.'; 
                break;
}

$_SESSION['alert_tit']= $a_tit;  	$_SESSION['alert_sub']= $a_sub; 	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>