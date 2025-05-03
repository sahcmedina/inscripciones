<?php 

session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('versionado.php');	$Ve = new Versionado();

if (isset($_POST["ver"]))      	{ $ver       = $_POST["ver"];      	} else { $ver= ''; 		}
if (isset($_POST["rev"]))    	{ $rev = $_POST["rev"];    			} else { $rev = ''; 	}
if (isset($_POST["proyecto"]))	{ $proyecto = $_POST["proyecto"];	} else { $proyecto= ''; }
if (isset($_POST["fun"]))   	{ $fun    = $_POST["fun"];   		} else { $fun   = ''; 	}
if (isset($_POST["tipo"]))		{ $tipo = $_POST["tipo"];			} else { $tipo= ''; 	}
if (isset($_POST["titulo"]))    { $titulo  = $_POST["titulo"];		} else { $titulo= ''; 	}
if (isset($_POST["desc"]))  	{ $desc   = $_POST["desc"];  		} else { $desc  = ''; 	}

$opcion     = 'ok';
if($ver=='' OR $rev=='' OR $proyecto=='' OR $fun=='' OR $tipo=='' OR $titulo=='' OR $desc=='')	$opcion = 'er';

switch($opcion){
	case 'er': 	
				$_SESSION['var_retorno_']= 'version_add_er';	$_SESSION['msj_retorno_']= 'Intente nuevamente. No pueden faltar datos.';
				break;

	case 'ok': 	
				$add = $Ve->add_version($ver, $rev, $proyecto, $fun, $tipo, $titulo, $desc);
				if($add){	$_SESSION['var_retorno_']= 'version_add_ok';	$_SESSION['msj_retorno_']= '';										}
				else{		$_SESSION['var_retorno_']= 'version_add_er';	$_SESSION['msj_retorno_']= 'Error en DB, intente nuevamente.';		}
				break;
}

// retorno
?><script type="text/javascript"> window.location="../_admin_versionado.php"; </script>