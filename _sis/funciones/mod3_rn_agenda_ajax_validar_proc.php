<?php
session_start();

if (isset($_POST["id"]))     	{ $id= $_POST["id"];      } else { $id= '';   }
if (isset($_POST["usu"]))     	{ $usu= $_POST["usu"];    } else { $usu= '';  }

// Control: Faltan datos?
$c1= 'ok';	$er1= '';
if($id=='' OR $usu==''){	$c1= 'er';	$er1= 'Faltan datos. '; }

if($c1== 'er' ){
	echo "<center><label style='font-weight:bold;color:red;'> Errores: ".$er1." </label></center>"; 

}else{
	$_SESSION['var_id_rn'] = $id;	
	$_SESSION['var_usu_rn']= $usu;	
	?> <script type="text/javascript"> window.location="./procesos/crear_agenda_rn.php"; </script><?php		
}
?>