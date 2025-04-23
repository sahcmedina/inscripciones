<?php 
session_start();
include('inscriptos.php');	$I = new Inscriptos();
// hago toda esta primera parte por si hay errores descarga un txt indiando cuales son los dni con errores
date_default_timezone_set('America/Argentina/San_Juan');

// recibo datos
$url = $_FILES['url']['name'];
if (isset($_POST["id_curso_xls"])) { $id_curso = $_POST["id_curso_xls"]; } else { $id_curso = ''; }
if (isset($_POST["id_user_xls"]))  { $id_user  = $_POST["id_user_xls"];  } else { $id_user  = ''; }	

// subo archivo
$directorio = "../up/".$_FILES['url']['name']; 
move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
$archivo= file($directorio);  

// borrar todos los registros de la tabla inscriptos_capacitacion_notas_error de una capacitación
$del = $I->del_reg_errores_de_notas($id_curso);

$contador = 0;
$contar_er = 0;
// recorro el archivo
foreach ($archivo as $line => $linea){ 	
	// // // leo una linea y separo el DNI y la Nota
	list($dni, $nota) = explode(';', $linea);
	// busco el dni en la tabla inscriptos_capacitaciones con el dni / id_curso / estado = t / estado_capacitacion = 1
	$esta = $I->tf_existeInscripto_en_capacitacion($dni, $id_curso);
	if($esta){
		// busco en la tabla inscriptos_capacitacion_nota por si ya le cargaron alguna nota.
		$tiene_nota = $I->tf_ya_tiene_nota($dni, $id_curso);
		if($tiene_nota){
			$motivo = 'Ya tiene Nota en esta Capacitacion' ;
			// guardo los datos en la tabla inscriptos_capacitacion_notas_error
			$grabar_error = $I->add_error_asignar_nota($id_curso, $dni, $motivo);
			$contar_er++; 	//cuento los errores
		}else{
			$grabar= $I->add_nota($id_curso,$dni,$nota,$id_user);
			$contador++;
		}
	}else{
		$motivo= 'No esta Inscripto en esta Capacitacion'; 
		// guardo los datos en la tabla inscriptos_capacitacion_notas_error
		$grabar_error = $I->add_error_asignar_nota($id_curso, $dni, $motivo);
		$contar_er++;	//cuento los errores
	}
	
}
// borro el excel que esta en la carpeta UP
unlink($directorio);

if ($contar_er == 0){
	$_SESSION['var_retorno_']= 'notas_add_ok';
	if ($contador == 1){$_SESSION['msj_retorno_']= 'Se cargo: '.$contador. ' sola nota' ;} 
	else {$_SESSION['msj_retorno_']= 'Se cargaron: '.$contador. ' notas' ;}
}else{
	$_SESSION['var_retorno_']= 'notas_add_er';
	$_SESSION['msj_retorno_']= 'Verifique el archivo descargado para ver errores';
}
?>
<script type="text/javascript">
	var p = "<?php echo $id_curso; ?>";
	window.location="../_admin_inscriptos.php?p=" + p +""; 
</script>
