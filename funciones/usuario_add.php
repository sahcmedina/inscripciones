<?php
session_start();

if (isset($_POST["nom"])) 		{ $nom= $_POST["nom"];     		} else {  $nom= '';   		}
if (isset($_POST["ape"]))    	{ $ape  = $_POST["ape"];        } else {  $ape  = '';    	}
if (isset($_POST["dni"])) 		{ $dni= $_POST["dni"];      	} else {  $dni= '';    		}
if (isset($_POST["tel"]))  		{ $tel  = $_POST["tel"];       	} else {  $tel  = '';    	}
if (isset($_POST["email"])) 	{ $email  = $_POST["email"];    } else {  $email  = '';    	}
if (isset($_POST["usuario"]))   { $usu  = $_POST["usuario"];    } else {  $usu = '';    	}
if (isset($_POST["clave"]))   	{ $pass  = $_POST["clave"];     } else {  $pass  = '';    	}
if (isset($_POST["perfil"]))   	{ $perfil  = $_POST["perfil"];  } else {  $perfil  = '';  	}
if (isset($_POST["id_cli"]))   	{ $id_cli  = $_POST["id_cli"];  } else {  $id_cli  = '';  	}

   	 
// verifico que no faltan datos
																													   $opc= 'ok';
if($nom=='' OR $ape=='' OR $dni=='' OR $tel=='' OR $email=='' OR $pass=='' OR $perfil=='' OR $usu=='' OR $id_cli=='')  $opc= 'er';

switch($opc){

	case 'ok':	
				include('./usuario.php');	$U = new Usuario();
				$existe_log= $U->tf_repite_login($usu);	
				if($existe_log){
					$_SESSION['var_retorno_']= 'user_add_er';	$_SESSION['msj_retorno_']= 'El login existe, pruebe con otro.'; 
				}else{
					// $next_user  = $U->add_usuario($dni, $usu, $pass);						
					$next_user  = $U->add_usuario_admin($dni, $usu, $pass, $id_cli);						
					$add_usu_per= $U->add_usuario_persona($dni, $nom, $ape, $tel, $email);						
					$add_perf   = $U->add_perfil_asociado($next_user, $perfil);	
					if($add_perf && $add_usu_per){	$_SESSION['var_retorno_']= 'user_add_ok';	$_SESSION['msj_retorno_']= '';	}
					else{
						if(!$add_perf){ 			$_SESSION['var_retorno_']= 'user_add_er';	$_SESSION['msj_retorno_']= 'Error al agregar perfil, consulte con el Administrador.';	}
						if(!$add_usu_per){ 			$_SESSION['var_retorno_']= 'user_add_er';	$_SESSION['msj_retorno_']= 'Error al agregar persona, consulte con el Administrador.';	}
					}
				}								
				break;

	case 'er':
				$_SESSION['var_retorno_']= 'user_add_er';	$_SESSION['msj_retorno_']= 'Intente nuevamente, debe completar todos los datos.';
				break;
}
	
// retorno
?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>