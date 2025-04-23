<?php 
session_start();

if (isset($_POST["chek"]))          { $arr_datos= $_POST["chek"];            } else {  $arr_datos= '';  }
if (isset($_POST["p_descripcion"])) { $descrip  = $_POST["p_descripcion"];   } else {  $descrip  = '';  }
if (isset($_POST["p_nombre"]))      { $perfil   = $_POST["p_nombre"];        } else {  $perfil   = '';  }
if (isset($_POST["id_cli"]))        { $id_cli   = $_POST["id_cli"];          } else {  $id_cli   = '';  }

// verifico que no falten datos
if($descrip!='' && $perfil!='' && $id_cli!='' && count($arr_datos)>0){

	include('./usuario.php');	$U   = new Usuario();
	$arr = array();
	$str ='';  
	for($m=0 ; $m<count($arr_datos) and is_array($arr_datos) ; $m++){
		// formateo datos
		$arr[$m]["id"]= $arr_datos[$m];
		$id_func      = $arr_datos[$m];
		if (isset($_POST[$id_func.'-A']))  $arr[$m]["A"]=$_POST[$id_func.'-A']; 	 else   $arr[$m]["A"]='0';
		if (isset($_POST[$id_func.'-B']))  $arr[$m]["B"]=$_POST[$id_func.'-B'];	     else   $arr[$m]["B"]='0';
		if (isset($_POST[$id_func.'-M']))  $arr[$m]["M"]=$_POST[$id_func.'-M'];	     else   $arr[$m]["M"]='0';	
	}

	// reviso que no se repita perfil para ese cliente
	$existe= $U->tf_repite_perfil($perfil, $id_cli);
	if(!$existe){
		
		// grabo el nuevo perfil
		$next_id_perfil = $U->next_id_perfil();
		$grabar         = $U->add_perfil($next_id_perfil, $perfil, $descrip, $id_cli);
					
		// grabo permisos para ese nuevo perfil
		$c = count($arr);
		for($n=0 ; $n<$c ; $n++){
			$next_id_permiso= $U->next_id_permiso();
			$grabar         = $U->add_permiso($next_id_permiso, $arr[$n]["id"], $next_id_perfil, $arr[$n]["A"], $arr[$n]["B"], $arr[$n]["M"]);
		}

		$a_ico= 'success';    $a_tit= 'Perfil Agregado';	         $a_sub= '';
		
	}else{	
		$a_ico= 'error';      $a_tit= 'Error al Agregar Perfil';	 $a_sub= 'El Perfil existe, pruebe con otro.'; 	}
			
}else{	
	    $a_ico= 'error';      $a_tit= 'Error al Agregar Perfil';	 $a_sub= 'Intente de nuevo, se deben completar todos los campos.';
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>