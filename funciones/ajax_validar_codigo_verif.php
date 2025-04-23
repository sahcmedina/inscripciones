<?php
session_start();

if (isset($_POST["d"]))     	{ $dni= $_POST["d"];       			} else { $dni= '';    	}
if (isset($_POST["a"]))     	{ $anio= $_POST["a"];    			} else { $anio= ''; 	}
if (isset($_POST["p"]))     	{ $pin= $_POST["p"];       			} else { $pin= '';    	}

// echo 'ACA: '.$dni.'-'.$anio.'-'.$pin;die();

if($dni=='' OR $anio=='' OR $pin=='' )	$op = 0;
else									$op = 1;

if($op == 0){
	echo "<center><label style='font-weight:bold;color:red;'> Deben completarse todos los campos. </label></center>"; 

}else{

	include('concursantes.php');		$Conc = new Concursantes();

	// Verifico si es PIN correcto
	$pin_valido = $Conc->tf_validar_pin($dni, $anio, $pin);

	if($pin_valido){
		?><div class="col-md-2" id='mostrar_validar_codigo_2'>
			<button id="a_form2" name="a_form2" type="submit" class="btn btn-primary" title="Se va a comprar el codigo ingresado." tabindex="9" > Siguiente </button>
		</div><?php
	}else{
		echo "<center><label style='font-weight:bold;color:red;'> Ocurrio un error, por favor intente de nuevo. </label></center>"; 
	}
	
	// controlo si existe DNI o @ en la DB
	$tf_existe_email= $Conc->tf_esta_email($correo);
	$tf_existe_dni  = $Conc->tf_esta_dni($dni);

	if(!$tf_existe_email && !$tf_existe_dni){

		// grabo datos en DB
		$codigo = rand(1000,9999); // OJO - OJO - OJO - OJO - validar que no se repita el pin
		$add    = $Conc->add_responsable($dni, $correo, $nom, $ape, $codigo, $tel, $pais, $prov, $prov_arg, $anio);

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
			<!-- <div class="row">
				<div class="col-md-5" >
					<div>Ingrese Código de Verificacion recibido</div>
					<input type="number" id="cod_verif" name="cod_verif" class="form-control" >
				</div>
			</div><br /> -->

			<div class="row">
				<div class="col-md-1" ></div>
				<div class="col-md-4" >
					<div>Ingrese Código de Verificacion recibido</div>
					<input type="number" id="cod_verif" name="cod_verif" class="form-control" >
				</div>
				<div class="col-md-2">
					<button id="next" name="next" type="submit" class="btn btn-primary" title="Se va a comprar el codigo ingresado." tabindex="9" > Validar </button>
				</div>
			</div>
			
			<?php
			// $_SESSION['var_retorno_']= 'crear_user_1_ok';		$_SESSION['msj_retorno_']= '';		

		}else{

			echo "<center><label style='font-weight:bold;color:red;'> Ocurrio un error, por favor intente de nuevo. </label></center>"; 
		}		

	}else{
		if($tf_existe_email)					echo "<center><label style='font-weight:bold;color:red;'> Ese Email ya fue registrado. </label></center>"; 
		if($tf_existe_dni)						echo "<center><label style='font-weight:bold;color:red;'> Ese DNI ya fue registrado. </label></center>"; 
		if($tf_existe_dni && $tf_existe_email)	echo "<center><label style='font-weight:bold;color:red;'> Ese DNI y Email ya fueron registrados. </label></center>"; 
	}
	
	
}
?>