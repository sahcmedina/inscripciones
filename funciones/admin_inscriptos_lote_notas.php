<?php 
session_start();	

include('usuario.php');		$U   = new Usuario();
include('inscriptos.php');	$Insc= new Inscriptos();

$datos     = array();
$arr_dts   = array();
$arr       = array();
$resto     = '';
$id_user   = $_SESSION['sesion_UserFoto'];

// recibo datos
$id_curso  = $_SESSION['sesion_idCurso_'];
$arr_datos = $_POST["chek"];
for($m=0 ; $m<count($arr_datos) ; $m++){

	$arr[$m]["dni"] = $arr_datos[$m];

	$nota           = $_POST[$arr[$m]["dni"].'-nota'];
	if($nota == 0){
		$arr[$m]["nota"]= $nota;	
	}
	else{
		list($nota_, $resto)= explode('>',$nota);
		$arr[$m]["nota"]= $nota_;
	}
}

// proceso
for($mm=0 ; $mm<count($arr) ; $mm++){
	$dni = $arr[$mm]["dni"];
	$nota= $arr[$mm]["nota"];
	if($nota > 0)	$add = $Insc->add_nota( $id_curso, $dni, $nota, $id_user);
}

$_SESSION['var_retorno_']= 'notas_add_ok';
$_SESSION['msj_retorno_']= '';

// retorno
?>
<script type="text/javascript">
    var p = "<?php echo $id_curso ?>";
    window.location="../_admin_inscriptos.php?p=" + p + ""; 
</script>