<?php
session_start();

if (isset($_SESSION["var_nom"])) 		{ $nom= $_SESSION["var_nom"];     	} else {  $nom= '';   	}
if (isset($_SESSION["var_dni"])) 		{ $dni= $_SESSION["var_dni"];       } else {  $dni= '';   	}
if (isset($_SESSION["var_perf"])) 		{ $perf=$_SESSION["var_perf"];      } else {  $perf= '';   	}
if (isset($_SESSION["var_email"]))      { $email=$_SESSION["var_email"];    } else {  $email= '';   }
if (isset($_SESSION["var_usu"]))        { $usu=$_SESSION["var_usu"];        } else {  $usu= '';     }
if (isset($_SESSION["var_ape"]))        { $ape=$_SESSION["var_ape"];        } else {  $ape= '';     }
if (isset($_SESSION["var_tel"]))        { $tel=$_SESSION["var_tel"];        } else {  $tel= '';     }
if (isset($_SESSION["var_pas"]))        { $pas=$_SESSION["var_pas"];        } else {  $pas= '';     }

                                                                                                    $opc= 'ok';
if($nom=='' OR $ape=='' OR $dni=='' OR $tel=='' OR $email=='' OR $pas=='' OR $perf=='' OR $usu=='') $opc= 'er';

switch($opc){

	case 'ok':
                include_once('./usuario.php');	$U = new Usuario();                	
                $next_user  = $U->add_usuario_admin($dni, $usu, $pas, '0');						
                $add_usu_per= $U->add_usuario_persona($dni, $nom, $ape, $tel, $email);						
                $add_perf   = $U->add_perfil_asociado($next_user, $perf);	
                if($add_perf && $add_usu_per){	$a_ico= 'success';    $a_tit= 'Usuario Agregado';	 $a_sub= '';	}
                else{
                    if(!$add_perf){ 		$a_ico= 'error';	$a_tit= 'Error al Agregar';  $a_sub= 'Al agregar perfil, consulte con el Administrador.';	}
                    if(!$add_usu_per){ 		$a_ico= 'error';	$a_tit= 'Error al Agregar';  $a_sub= 'Al agregar persona, consulte con el Administrador.';	}
                }
				break;

	case 'er':
                $a_ico= 'error';    $a_tit= 'Error al Agregar';	 $a_sub= 'Intente de nuevo, faltan datos';					
                break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>