<?php 
session_start();
include('concursantes.php');		$Conc  = new Concursantes();

// recibo datos 
if (isset($_POST["dni"]))          { $dni = $_POST["dni"];             } else { $dni = '';   }
if (isset($_POST["cod_verif"]))    { $pin = $_POST["cod_verif"];       } else { $pin = '';   }
if (isset($_POST["anio"]))         { $anio= $_POST["anio"];            } else { $anio= '';   }
// echo 'ACA: '.$dni.'-'.$anio.'-'.$pin;die();
										$opcion= 'er';
if($dni!='' && $pin!='' && $anio!='') 	$opcion= 'ok';

if($opcion == 'ok'){

	// comparo pin con el de la DB (si esta bien --> Form 2)
	$tf_pin_ingresado  = $Conc->tf_validar_pin($dni, $anio, $pin);

	if($tf_pin_ingresado){

		// A Form 2
		$_SESSION['user_creado_dni'] = $dni;
		$_SESSION['user_creado_anio']= $anio;
		?> <script type="text/javascript"> window.location="../_usuario_concursante_crear_next.php";  </script><?php 
	}else{

		// A Form 1
		$_SESSION['user_pin_erroneo']= 1;
		$_SESSION['user_creado_dni'] = $dni;
		$_SESSION['user_creado_anio']= $anio;		
		$_SESSION['var_retorno_']= 'pin_add_er';	$_SESSION['msj_retorno_']= 'Código ingresado incorrecto.';	
		?> <script type="text/javascript"> window.location="../_usuario_concursante_crear.php";  </script><?php 
	}	

}else{
	
	// retorno a Form 1
	$_SESSION['user_pin_erroneo']= 1;
	$_SESSION['user_creado_dni'] = $dni;
	$_SESSION['user_creado_anio']= $anio;		
	$_SESSION['var_retorno_']= 'pin_add_er';	$_SESSION['msj_retorno_']= 'El código no fue ingresado.';	
	?> <script type="text/javascript"> window.location="../_usuario_concursante_crear.php";  </script><?php 
}

