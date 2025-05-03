<?php 
include('usuario.php');	$U   = new Usuario();
session_start();
$fila= array();

// recibo datos
if (isset($_POST["chek"]))    { $arr_datos= $_POST["chek"];     }   else   {  $arr_datos= '';}
if (isset($_POST["idperfil"])){ $idperfil = $_POST["idperfil"]; }   else   {  $idperfil= ''; }

// formateo datos
$arr = array();
$str ='';  
for($m=0 ; $m<count($arr_datos) ; $m++){
	$arr[$m]["id"]= $arr_datos[$m];
	$id_func      = $arr_datos[$m];
	if (isset($_POST[$id_func.'-A']))  $arr[$m]["A"]=$_POST[$id_func.'-A'];   else   $arr[$m]["A"]='0';
	if (isset($_POST[$id_func.'-B']))  $arr[$m]["B"]=$_POST[$id_func.'-B'];	  else   $arr[$m]["B"]='0';
	if (isset($_POST[$id_func.'-M']))  $arr[$m]["M"]=$_POST[$id_func.'-M'];	  else   $arr[$m]["M"]='0';	
}

// borro permisos para ese perfil
$borrar  = $U->del_permiso($idperfil);
					
// grabo permisos nuevos para ese perfil
$c = count($arr);
for($n=0 ; $n<$c ; $n++){
	$next_id_permiso= $U->next_id_permiso();
	$grabar         = $U->add_permiso($next_id_permiso, $arr[$n]["id"], $idperfil, $arr[$n]["A"], $arr[$n]["B"], $arr[$n]["M"]);
}
			
$a_ico= 'success';    $a_tit= 'Perfil Editado';	         $a_sub= '';	
			
$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	  $_SESSION['alert_ico']= $a_ico;

?> <script type="text/javascript"> window.location="../_admin_usuarios.php"; </script>