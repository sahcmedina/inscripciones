<?php 
session_start();
include('./usuario.php');	$U  = new Usuario();

// recibo datos
if (isset($_POST["id"]))            { $fk_usuario   = $_POST["id"];      	    } else { $fk_usuario= '';    }
if (isset($_POST["perfil_new"]))    { $fk_perfil_new= $_POST["perfil_new"];     } else { $fk_perfil_new= ''; }

                                                $opc= 'ok';
if($fk_usuario==''  OR  $fk_perfil_new=='')     $opc= 'er';

switch($opc){
    case 'ok':
                $upd= $U->upd_perfil_asociado($fk_perfil_new, $fk_usuario);                                
                if($upd){   $a_ico= 'success';    $a_tit= 'Perfil Editado';	         $a_sub= '';	                                                }
                else{       $a_ico= 'error';      $a_tit= 'Error el Editar';	     $a_sub= 'Intente de nuevo.';    }
                break; 

    case 'er':
                $a_ico= 'error';      $a_tit= 'Error el Editar';	$a_sub= 'Intente de nuevo, faltaron datos.'; 
                break;
}

$_SESSION['alert_tit']= $a_tit;  	$_SESSION['alert_sub']= $a_sub; 	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>