<?php
session_start();

if (isset($_POST["id_e"])) { $id_e= $_POST["id_e"]; } else { $id_e= '';   }
if (isset($_POST["id_f"])) { $id_f= $_POST["id_f"]; } else { $id_f= '';   }

// echo 'EVENTO: '.$id_e.' FORO: '.$id_f; die();

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id_e=='' OR $id_f==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

if($c1== 'er'){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION['var_id_e'] = $id_e;	$_SESSION['var_id_f'] = $id_f;	
	?> <script type="text/javascript"> window.location="./funciones/mod6_foro_del.php"; </script><?php		
}
?>