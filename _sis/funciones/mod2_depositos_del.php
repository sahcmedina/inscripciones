<?php
session_start();

if (isset($_SESSION["var_id"])) 	{ $id= $_SESSION["var_id"];     } else {  $id= '';   }

				$opc= 'ok';
if($id=='' )  	$opc= 'er';

switch($opc){

	case 'ok':	
				include_once('./mod2_depositos.php');	$Dep = new Depositos();
				$del = $Dep->del_deposito($id);
				if($del){	$a_tit= 'Registro borrado';	$a_sub= '';		             $a_ico= 'success';			}
				else{		$a_tit= 'Error al borrar';	$a_sub= 'Intente de nuevo';	 $a_ico= 'error';			}
				break;

	case 'er':
		        $a_tit= 'Error al borrar';	$a_sub= 'Faltan datos, intente de nuevo'; $a_ico= 'error';	
				break;
}
	
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_depositos_.php"; </script>