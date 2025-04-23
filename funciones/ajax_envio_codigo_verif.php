<?php
session_start();

if (isset($_POST["c"]))     	{ $correo= $_POST["c"];    			} else { $correo= ''; 	}
if (isset($_POST["d"]))     	{ $dni= $_POST["d"];       			} else { $dni= '';    	}
if (isset($_POST["a"]))     	{ $ape= $_POST["a"];       			} else { $ape= '';    	}
if (isset($_POST["n"]))     	{ $nom= $_POST["n"];       			} else { $nom= '';    	}
if (isset($_POST["t"]))     	{ $tel= $_POST["t"];       			} else { $tel= '';    	}
if (isset($_POST["p"]))     	{ $pais= $_POST["p"];      			} else { $pais= '';    	}
if (isset($_POST["prov"]))  	{ $prov= $_POST["prov"];       		} else { $prov= '';    	}
if (isset($_POST["prov_arg"]))	{ $prov_arg= $_POST["prov_arg"];    } else { $prov_arg= ''; }
if (isset($_POST["anio"]))	    { $anio= $_POST["anio"];            } else { $anio= '';     }
// echo 'ACA: '.$pais.'-'.$prov.'-'.$prov_arg;die();

// Controles
if($correo=='' OR $dni=='' OR $ape=='' OR $nom=='' OR $tel=='' OR $pais=='')	$op = 'er_1';
else																			$op = 'ok';

if($op == 'ok'){

	// Correo valido?
	if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {	$op = 'er_2';	} 

	// Correo o DNI repetidos?
	include('correo_electronico.php');	$Ce   = new CorreoElectronico();
	include('concursantes.php');		$Conc = new Concursantes();
	$tf_existe_email= $Conc->tf_esta_email($correo);
	$tf_existe_dni  = $Conc->tf_esta_dni($dni);
	if($tf_existe_email OR $tf_existe_dni){	$op = 'er_3';	} 

	// Pais - Provincia
	if($pais == 7){	if($prov_arg==''){	$op = 'er_1';	} }
	else{	   		if($prov==''){		$op = 'er_1';	} }

}

switch($op){

	case 'er_1':	// Error en control: Faltan datos
					$_SESSION['var_retorno_']= 'crear_user_er';		$_SESSION['msj_retorno_']= 'Deben completarse todos los campos.';
					?> <script type="text/javascript"> window.location="./_usuario_concursante_crear.php"; </script><?php 
					break;

	case 'er_2':	// Error en control: Correo invalido
					$_SESSION['var_retorno_']= 'crear_user_er';		$_SESSION['msj_retorno_']= 'El email ingresado no es valido.';
					?> <script type="text/javascript"> window.location="./_usuario_concursante_crear.php"; </script><?php 
					break;

	case 'er_3':	// Error en control: Repite DNI o Email
					if(!$tf_existe_dni &&  $tf_existe_email)	$_SESSION['msj_retorno_']= 'Ese Email ya fue registrado.';
					if( $tf_existe_dni && !$tf_existe_email)	$_SESSION['msj_retorno_']= 'Ese DNI ya fue registrado.';
					if( $tf_existe_dni &&  $tf_existe_email)	$_SESSION['msj_retorno_']= 'Ese DNI y Email ya fueron registrados.';
					$_SESSION['var_retorno_']= 'crear_user_er';			
					?> <script type="text/javascript"> window.location="./_usuario_concursante_crear.php"; </script><?php 
					break;

	case 'ok':		// OK
					$repite = true;
					for($i=0 ; $repite==true ; $i++){
						$codigo        = rand(1000,9999);
						$repite_codigo = $Conc->tf_existe_pin($codigo);
						if($repite_codigo)	$repite= true;
						else                $repite= false;
					}
					// grabo datos en DB
					$add = $Conc->add_responsable($dni, $correo, $nom, $ape, $codigo, $tel, $pais, $prov, $prov_arg, $anio);
			
					if($add){
						// envio email
						$asunto = ' ArgOliva: Creacion de Usuario';
						$msj    = ' <html>
										<head><meta charset="UTF8" /><title>Creacion de Usuario Sistema ArgOliva</title></head>
										<body>
											<p>tu codigo de verificacion es: </p>  						
											<h2>'.$codigo.'</h2>
										</body>
									</html>' ;
						$envio  = $Ce->envio_correo_new($correo, $asunto, $msj);
			
						// muestro campo para ingreso del codigo
						?>			
						<div class="row">
							<div class="col-md-1" ></div>
							<div class="col-md-3" >
								<label>Ingrese Código de Verificación recibido:</label>
								<input type="number" id="cod_verif" name="cod_verif" class="form-control" >
							</div>
							<div class="col-md-2" >
								<button id="validar_pin" name="validar_pin" type="submit" class="btn btn-primary" title="Se va a comprar el codigo ingresado." tabindex="9" > Validar </button>
							</div>
						</div>			
						<?php
			
						$_SESSION['var_retorno_']= 'crear_user_1_ok';	$_SESSION['msj_retorno_']= '';		
			
					}else{
			
						// Error al grabar los datos
						$_SESSION['var_retorno_']= 'crear_user_er';		$_SESSION['msj_retorno_']= 'No se pudo grabar los datos, intente nuevamente.';
						?> <script type="text/javascript"> window.location="./_usuario_concursante_crear.php"; </script><?php 
			
					}		
					break;
	
	default:		break;
					
}

?>