<?php 

//include('/usuario.php');		$U  = new Usuario();
include('correo_electronico.php');		$Ce  = new CorreoElectronico();



// recibo datos PERSONALES DEL RESPONSABLE DE LA EMPRESa
if (isset($_POST["dni"]))       { $dni = $_POST["dni"];             } else { $dni = '';       }
if (isset($_POST["nombre"]))    { $nombre = $_POST["nombre"];       } else { $nombre = '';    }
if (isset($_POST["tel"]))       { $tel = $_POST["tel"];             } else { $tel = '';       }
if (isset($_POST["pais"]))      { $pais = $_POST["pais"];           } else { $pais= '';       }
if (isset($_POST["provincia"])) { $provincia = $_POST["provincia"]; } else { $provincia = ''; }

if (isset($_POST["correo"]))    { $correo = $_POST["correo"];       } else { $correo = '';    }
if (isset($_POST["pass1"]))     { $pass1 = $_POST["pass1"];         } else { $pass1 = '';     }
if (isset($_POST["pass2"]))     { $pass2 = $_POST["pass2"];         } else { $pass2 = '';     }

if($dni!='' && $nombre!='' && $tel!='' && $pais!='' && $provincia!='' && $correo!='' && ($pass1 == $pass2) ) $opcion='ok';

if($opcion == 'ok'){
	$codigo = rand(1000,9999);
	// insertar correo y codigo de validacion
	

	// envio el correo
	$asunto     = ' ArgOliva: Creacion de Usuario';
	$msj        = ' <html>
					<head>
    					<meta charset="UTF8" />
  						<title>Creacion de Usuario Sistema ArgOliva</title>
					</head>
					<body>
  						<p>tu codigo de verificacion es: </p>
  						
 						<h2>'.$codigo.'</h2>
  					</body>
					</html>' ;
	$envio=$Ce->envio_correo_new($correo, $asunto, $msj);
	

}else{
// retorno a login
//header('Location: ./login.php');
	$_SESSION['var_retorno_']= 'recupero_trivia_incorrecta_err';$_SESSION['msj_retorno_'] = 'Los datos ingresados para validar son incorrectos. Intente de nuevo.';
	// ?> <script type="text/javascript"> window.location="./"; </script> <?php
}
	
?> <script type="text/javascript">
		var p = "<?php echo $correo ?>";
		window.location="../_confirm.php?p=" + p + ""; 
	</script>
