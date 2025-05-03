<?php
session_start();

if (isset($_POST["nom"])) 		{ $nom= $_POST["nom"];     		} else {  $nom= '';   		}
if (isset($_POST["ape"]))    	{ $ape  = $_POST["ape"];        } else {  $ape  = '';    	}
if (isset($_POST["dni"])) 		{ $dni= $_POST["dni"];      	} else {  $dni= '';    		}
if (isset($_POST["tel"]))  		{ $tel  = $_POST["tel"];       	} else {  $tel  = '';    	}
if (isset($_POST["email"])) 	{ $email  = $_POST["email"];    } else {  $email  = '';    	}
if (isset($_POST["usuario"]))   { $usu  = $_POST["usuario"];    } else {  $usu = '';    	}
if (isset($_POST["clave"]))   	{ $pass  = $_POST["clave"];     } else {  $pass  = '';    	}
if (isset($_POST["emp"]))   	{ $emp  = $_POST["emp"];        } else {  $emp  = '';     	}
if (isset($_POST["perfil_admin"])){ $perf= $_POST["perfil_admin"];} else {$perf  = '';     	}
$arr_mod_elegidos = $_POST["chek"];

																										            $opc= 'ok';
if($nom=='' OR $ape=='' OR $dni=='' OR $tel=='' OR $email=='' OR $pass=='' OR $emp=='' OR $usu=='' OR $perf=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	
				include('./usuario.php');	$U = new Usuario();
				$arr_func  = array();
				$existe_log= $U->tf_repite_login($usu);	
				$existe_dni= $U->tf_repite_dni($dni);
				if($existe_log OR $existe_dni){	
					
					$_SESSION['var_retorno_']= 'add_er';	
					if($existe_log)		$_SESSION['msj_retorno_']= 'El login existe, pruebe con otro.'; 	
					if($existe_dni)		$_SESSION['msj_retorno_']= 'El DNI existe, pruebe con otro.'; 	
				}else{
					
					$id_cliente  = $U->add_cliente($emp);										// DB.cliente					
					$next_user   = $U->add_usuario_admin($dni, $usu, $pass, $id_cliente);		// DB.usuario_			
					$add_usu_per = $U->add_usuario_persona($dni, $nom, $ape, $tel, $email);		// DB.usuario_persona	
					$id_perf     = $U->next_id_perfil();			
					$descrip_perf= 'Perfil Admin creado para cliente: '.$emp;	
					$add_perf    = $U->add_perfil($id_perf, $perf, $descrip_perf, $id_cliente); // DB.usuario_perfil
					$add_perf_as = $U->add_perfil_asociado($next_user, $id_perf);	 			// DB.usuario_perfil_asociado
					
					// debo dar acceso a las funciones que pertenecen a los modulos elegidos
					for($i=0 ; $i<count($arr_mod_elegidos) ; $i++){
						$id_mod     = $arr_mod_elegidos[$i];
						$add_mod_cli= $U->add_mod_a_cli($id_mod, $id_cliente);
						$arr_func   = $U->gets_func_segun_modulo($id_mod);
						for($j=0 ; $j<count($arr_func) ; $j++){
							$add = $U->add_usuario_permiso_admin($arr_func[$j]['id'], $id_perf);// DB.usuario_permisos
						}
					}
					if($add_perf && $add_usu_per){	$_SESSION['var_retorno_']= 'add_ok';	$_SESSION['msj_retorno_']= '';	}
					else{
						if(!$add_perf){ 			$_SESSION['var_retorno_']= 'add_er';	$_SESSION['msj_retorno_']= 'Error al agregar perfil, consulte con el Administrador.';	}
						if(!$add_usu_per){ 			$_SESSION['var_retorno_']= 'add_er';	$_SESSION['msj_retorno_']= 'Error al agregar persona, consulte con el Administrador.';	}
					}
				}								
				break;

	case 'er':
				$_SESSION['var_retorno_']= 'add_er';	$_SESSION['msj_retorno_']= 'Intente nuevamente, debe completar todos los datos.';
				break;
}
	
?> <script type="text/javascript"> window.location="../_super_admin_usuarios.php"; </script>