<?php 
$preg1=''; $preg2=''; $preg3='';
include('/usuario.php');		$U  = new Usuario();
session_start();

// recibo datos
if (isset($_POST["login"]))       { $login = $_POST["login"];             } else { $login = '';     }
if (isset($_POST["tipo_user"]))   { $tipo_user = $_POST["tipo_user"];     } else { $tipo_user = ''; }

// pregunta: FECHA NAC
if (isset($_POST["fecha_ok"]))    { $fecha_ok = $_POST["fecha_ok"];       } else { $fecha_ok = '';  }
if (isset($_POST["pregunta1"]))   { $fecha = $_POST["pregunta1"];         } else { $fecha= '';      }

// pregunta: DNI
if (isset($_POST["dni_ok"]))      { $dni_ok = $_POST["dni_ok"];           } else { $dni_ok = '';    }
if (isset($_POST["pregunta2"]))   { $dni = $_POST["pregunta2"];           } else { $dni = '';       }

// pregunta: LEGAJO
if (isset($_POST["leg_ok"]))      { $leg_ok = $_POST["leg_ok"];           } else { $leg_ok = '';    }
if (isset($_POST["pregunta3a"]))  { $leg = $_POST["pregunta3a"];          } else { $leg = '';       }

// pregunta: MATRICULA
if (isset($_POST["matri_ok"]))    { $matri_ok = $_POST["matri_ok"];       } else { $matri_ok = '';  }
if (isset($_POST["pregunta3"]))   { $matri = $_POST["pregunta3"];         } else { $matri = '';     }

// PASS
if (isset($_POST["pass1"]))       { $pass1 = $_POST["pass1"];             } else { $pass1 = '';     }
if (isset($_POST["pass2"]))       { $pass2 = $_POST["pass2"];             } else { $pass2 = '';     }

$opcion= 'ok';
if($login=='' OR $tipo_user=='' OR $pass1=='' OR $pass2=='' OR $fecha_ok=='' OR $fecha=='' OR $dni_ok=='' OR $dni=='')	$opcion= 'er';
if($tipo_user == '1'){  if($leg_ok=='' OR $leg=='')     $opcion= 'er';   } // Colaboradores
if($tipo_user == '2'){  if($matri_ok=='' OR $matri=='') $opcion= 'er';   } // Socios

if($opcion == 'ok'){
	
	switch($tipo_user){	
		case '1':	if($leg_ok == $leg)    { $preg3 = true; } else{ $preg3 = false; } 	break;		
		case '2':	if($matri_ok == $matri){ $preg3 = true; } else{ $preg3 = false; } 	break;			
	}
	
	if($dni_ok == $dni)    { $preg2 = true; } else{ $preg2 = false; }
	if($fecha_ok == $fecha){ $preg1 = true; } else{ $preg1 = false; }	
	if($pass1 == $pass2)   { $pass  = true; } else{ $pass  = false; }	
		
	if($preg1 && $preg2 && $preg3 && $pass){
		
		// ingreso
		$id_user = $U->get_id($login);
		$U->upd_pass($pass1, $id_user);
		$U->conectar($login, $pass1); 
	}else{
		
		// retorno a login
		$_SESSION['var_retorno_']= 'recupero_trivia_incorrecta_err';$_SESSION['msj_retorno_'] = 'Los datos ingresados para validar son incorrectos. Intente de nuevo.';
		?> <script type="text/javascript"> window.location="../login.php"; </script> <?php
	}	
}else{
	
	// retorno a login
	$_SESSION['var_retorno_']= 'recupero_clave_err';$_SESSION['msj_retorno_'] = 'Faltaron datos. Intente de nuevo.';
	?> <script type="text/javascript"> window.location="../login.php"; </script> <?php
}