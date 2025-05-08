<?php
session_start();

if (isset($_POST["id_e"])) { $id_e= $_POST["id_e"]; } else { $id_e= '';   }
if (isset($_POST["id_c"])) { $id_c= $_POST["id_c"]; } else { $id_c= '';   }

//echo 'ID EVENTO: '.$id_e.' ID conferencia: '.$id_c; die();

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id_e=='' OR $id_c==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

if($c1== 'er' ){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION['var_id_e'] = $id_e;	$_SESSION['var_id_c'] = $id_c;	
	?> <script type="text/javascript"> window.location="./funciones/mod5_conferencia_del.php"; </script><?php		
}
?>