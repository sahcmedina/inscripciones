<?php
session_start();

if (isset($_POST["id"]))     	{ $id= $_POST["id"];      } else { $id= '';   }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

// Control: Esta en uso?


if($c1== 'er' ){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION['var_id'] = $id;	
	?> <script type="text/javascript"> window.location="./funciones/mod2_aratos_del.php"; </script><?php		
}
?>