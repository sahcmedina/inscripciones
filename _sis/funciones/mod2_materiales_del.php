<?php
session_start();

if (isset($_SESSION['var_id'])) { $id = $_SESSION["var_id"]; } else { $id= ''; }

$opc ='ok';
if($id=='')	$opc= 'er';

switch ($opc){
	case 'ok': 
				include("mod2_materiales.php"); $Mat = new Materiales();
				$del_material = $Mat->del_material($id);
				if($del_material) {$a_tit= 'Registro Borrado';	$a_sub= '';												$a_ico= 'success';		}
				else              {$a_tit= 'Error al Borrar';	$a_sub= 'Intente nuevamente, no se pudo eliminar';		$a_ico= 'error';		}
				break;

 	case 'er': 	$a_tit= 'Error al Borrar';	$a_sub= 'Intente nuevamente, ocurrio un error';		$a_ico= 'error'; 			
				break;
}
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_materiales.php"; </script>