<?php
session_start();
header('Content-Type: text/html; charset=UTF-8'); 
require_once('capacitaciones.php');
date_default_timezone_set('America/Argentina/San_Juan');
$Cap   = new Capacitaciones();

if (isset($_POST["id_curso"])) { $id      = $_POST["id_curso"];} else { $id      = ''; }
if (isset($_POST["chek_to"]))  { $chek_to = $_POST["chek_to"]; } else { $chek_to = ''; }

if (isset($_POST["chek_no"]))  { $chek_no = $_POST["chek_no"]; } else { $chek_no = ''; }
if (isset($_POST["chek_ti"]))  { $chek_ti = $_POST["chek_ti"]; } else { $chek_ti = ''; }
if (isset($_POST["chek_su"]))  { $chek_su = $_POST["chek_su"]; } else { $chek_su = ''; }
if (isset($_POST["chek_ba"]))  { $chek_ba = $_POST["chek_ba"]; } else { $chek_ba = ''; }

$arr_datos_aux = array(); $arr_datos     = array();
$upp = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ');
$low = array('á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ');
$op = 0;

if($id == ""){ $op =1;}; // falta seleccionar un curso

if($chek_to == ""){
	if($chek_no == "" and $chek_ti == "" and $chek_su == "" and $chek_ba == "") { $op =2;} // falta seleccionar alguna opcion de 	
	else {
		$arr_datos_aux = $Cap->gets_inscriptos_por_id($id);
		if (count($arr_datos_aux) <= 0) { $op=3 ;} // no hay datos para importar
		else {
			$ind=0;
			if ($chek_no == 'n') {
				for ($i=0; $i<count($arr_datos_aux); $i++) {
					if ($arr_datos_aux[$i]['estado'] == 'n') {
						$arr_datos[$ind]['dni']          		= $arr_datos_aux[$i]['dni'];
						$arr_datos[$ind]['apellido']     		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['apellido']));
						$arr_datos[$ind]['nombre']       		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['nombre']));
						$arr_datos[$ind]['sexo']         		= $arr_datos_aux[$i]['sexo'];
						$arr_datos[$ind]['nom_depto']    		= $arr_datos_aux[$i]['nom_depto'];
						$arr_datos[$ind]['dir_nro']      		= $arr_datos_aux[$i]['dir_nro'];
						$arr_datos[$ind]['dir_calle']    		= $arr_datos_aux[$i]['dir_calle'];
						$arr_datos[$ind]['correo']       		= $arr_datos_aux[$i]['correo'];
						$arr_datos[$ind]['telefono']     		= $arr_datos_aux[$i]['telefono'];
						$arr_datos[$ind]['f_nacimiento'] 		= $arr_datos_aux[$i]['f_nacimiento'];
						$arr_datos[$ind]['estado']      		= 'No Visto';
						$arr_datos[$ind]['nivel_alcanzado']     = $arr_datos_aux[$i]['nivel_alcanzado'];
						$arr_datos[$ind]['titulo_especialidad'] = $arr_datos_aux[$i]['titulo_especialidad'];
						$arr_datos[$ind]['ocupacion']       	= $arr_datos_aux[$i]['ocupacion'];
						$arr_datos[$ind]['trabajo_actual']      = $arr_datos_aux[$i]['trabajo_actual'];
						$arr_datos[$ind]['trabajo_actual_hs']   = $arr_datos_aux[$i]['trabajo_actual_hs'];
						$arr_datos[$ind]['conoce_rubro']      	= $arr_datos_aux[$i]['conoce_rubro'];
						$arr_datos[$ind]['capacit_ant']    		= $arr_datos_aux[$i]['capacit_ant'];
						$arr_datos[$ind]['capacit_ant_cual']    = $arr_datos_aux[$i]['capacit_ant_cual'];
						$ind++;
					}
				}
			}
			if ($chek_ti == 't') {
				for ($i=0; $i<count($arr_datos_aux); $i++) {
					if ($arr_datos_aux[$i]['estado'] == 't') {
						$arr_datos[$ind]['dni']          		= $arr_datos_aux[$i]['dni'];
						$arr_datos[$ind]['apellido']     		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['apellido']));
						$arr_datos[$ind]['nombre']      		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['nombre']));
						$arr_datos[$ind]['sexo']         		= $arr_datos_aux[$i]['sexo'];
						$arr_datos[$ind]['nom_depto']    		= $arr_datos_aux[$i]['nom_depto'];
						$arr_datos[$ind]['dir_nro']      		= $arr_datos_aux[$i]['dir_nro'];
						$arr_datos[$ind]['dir_calle']   		= $arr_datos_aux[$i]['dir_calle'];
						$arr_datos[$ind]['correo']       		= $arr_datos_aux[$i]['correo'];
						$arr_datos[$ind]['telefono']     		= $arr_datos_aux[$i]['telefono'];
						$arr_datos[$ind]['f_nacimiento'] 		= $arr_datos_aux[$i]['f_nacimiento'];
						$arr_datos[$ind]['estado']    			= 'Titular';
						$arr_datos[$ind]['nivel_alcanzado']     = $arr_datos_aux[$i]['nivel_alcanzado'];
						$arr_datos[$ind]['titulo_especialidad'] = $arr_datos_aux[$i]['titulo_especialidad'];
						$arr_datos[$ind]['ocupacion']       	= $arr_datos_aux[$i]['ocupacion'];
						$arr_datos[$ind]['trabajo_actual']      = $arr_datos_aux[$i]['trabajo_actual'];
						$arr_datos[$ind]['trabajo_actual_hs']   = $arr_datos_aux[$i]['trabajo_actual_hs'];
						$arr_datos[$ind]['conoce_rubro']      	= $arr_datos_aux[$i]['conoce_rubro'];
						$arr_datos[$ind]['capacit_ant']    		= $arr_datos_aux[$i]['capacit_ant'];
						$arr_datos[$ind]['capacit_ant_cual']    = $arr_datos_aux[$i]['capacit_ant_cual'];
						$ind++;
					}
				}
			}
			if ($chek_su == 's') {
				for ($i=0; $i<count($arr_datos_aux); $i++) {
					if ($arr_datos_aux[$i]['estado'] == 's') {
						$arr_datos[$ind]['dni']          		= $arr_datos_aux[$i]['dni'];
						$arr_datos[$ind]['apellido']     		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['apellido']));
						$arr_datos[$ind]['nombre']       		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['nombre']));
						$arr_datos[$ind]['sexo']         		= $arr_datos_aux[$i]['sexo'];
						$arr_datos[$ind]['nom_depto']    		= $arr_datos_aux[$i]['nom_depto'];
						$arr_datos[$ind]['dir_nro']      		= $arr_datos_aux[$i]['dir_nro'];
						$arr_datos[$ind]['dir_calle']    		= $arr_datos_aux[$i]['dir_calle'];
						$arr_datos[$ind]['correo']       		= $arr_datos_aux[$i]['correo'];
						$arr_datos[$ind]['telefono']     		= $arr_datos_aux[$i]['telefono'];
						$arr_datos[$ind]['f_nacimiento'] 		= $arr_datos_aux[$i]['f_nacimiento'];
						$arr_datos[$ind]['estado']    			= 'Suplente';
						$arr_datos[$ind]['nivel_alcanzado']     = $arr_datos_aux[$i]['nivel_alcanzado'];
						$arr_datos[$ind]['titulo_especialidad'] = $arr_datos_aux[$i]['titulo_especialidad'];
						$arr_datos[$ind]['ocupacion']       	= $arr_datos_aux[$i]['ocupacion'];
						$arr_datos[$ind]['trabajo_actual']      = $arr_datos_aux[$i]['trabajo_actual'];
						$arr_datos[$ind]['trabajo_actual_hs']   = $arr_datos_aux[$i]['trabajo_actual_hs'];
						$arr_datos[$ind]['conoce_rubro']      	= $arr_datos_aux[$i]['conoce_rubro'];
						$arr_datos[$ind]['capacit_ant']    		= $arr_datos_aux[$i]['capacit_ant'];
						$arr_datos[$ind]['capacit_ant_cual']    = $arr_datos_aux[$i]['capacit_ant_cual'];
						$ind++;
					}
				}
			}
			if ($chek_ba == 'b') {
				for ($i=0; $i<count($arr_datos_aux); $i++) {
					if ($arr_datos_aux[$i]['estado'] == 'b') {
						$arr_datos[$ind]['dni']					= $arr_datos_aux[$i]['dni'];
						$arr_datos[$ind]['apellido']     		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['apellido']));
						$arr_datos[$ind]['nombre']       		= str_replace($low, $upp, strtoupper($arr_datos_aux[$i]['nombre']));
						$arr_datos[$ind]['sexo']         		= $arr_datos_aux[$i]['sexo'];
						$arr_datos[$ind]['nom_depto']			= $arr_datos_aux[$i]['nom_depto'];
						$arr_datos[$ind]['dir_nro']      		= $arr_datos_aux[$i]['dir_nro'];
						$arr_datos[$ind]['dir_calle']    		= $arr_datos_aux[$i]['dir_calle'];
						$arr_datos[$ind]['correo']       		= $arr_datos_aux[$i]['correo'];
						$arr_datos[$ind]['telefono']     		= $arr_datos_aux[$i]['telefono'];
						$arr_datos[$ind]['f_nacimiento'] 		= $arr_datos_aux[$i]['f_nacimiento'];
						$arr_datos[$ind]['estado']              = 'De Baja';
						$arr_datos[$ind]['nivel_alcanzado']     = $arr_datos_aux[$i]['nivel_alcanzado'];
						$arr_datos[$ind]['titulo_especialidad'] = $arr_datos_aux[$i]['titulo_especialidad'];
						$arr_datos[$ind]['ocupacion']           = $arr_datos_aux[$i]['ocupacion'];
						$arr_datos[$ind]['trabajo_actual']      = $arr_datos_aux[$i]['trabajo_actual'];
						$arr_datos[$ind]['trabajo_actual_hs']   = $arr_datos_aux[$i]['trabajo_actual_hs'];
						$arr_datos[$ind]['conoce_rubro']        = $arr_datos_aux[$i]['conoce_rubro'];
						$arr_datos[$ind]['capacit_ant']         = $arr_datos_aux[$i]['capacit_ant'];
						$arr_datos[$ind]['capacit_ant_cual']    = $arr_datos_aux[$i]['capacit_ant_cual'];
						$ind++;
					}
				}
			}
			if (count($arr_datos)<= 0) {$op=3 ;}
		}
	}
}else{
	$arr_datos = $Cap->gets_inscriptos_por_id($id);
	if (count($arr_datos)<= 0) { $op=3 ;}
	else{
		for ($t=0; $t<count($arr_datos); $t++) {
			$arr_datos[$t]['apellido'] = str_replace($low, $upp, strtoupper($arr_datos[$t]['apellido']));
			$arr_datos[$t]['nombre']   = str_replace($low, $upp, strtoupper($arr_datos[$t]['nombre']));
			switch ($arr_datos[$t]['estado']) {
				case 'n': $arr_datos[$t]['estado'] = 'No Visto'; break;
				case 't': $arr_datos[$t]['estado'] = 'Titular';  break;
				case 's': $arr_datos[$t]['estado'] = 'Suplente'; break;
				case 'b': $arr_datos[$t]['estado'] = 'De Baja';  break;
			}
		}	
	}
}	

switch ($op){
	case '1': // falta seleccionar un curso
		$_SESSION['var_retorno_']= 'exl_curso_er';		$_SESSION['msj_retorno_']= 'Falta seleccionar un curso';
		?>
			<script type="text/javascript">
				var p = "<?php echo $id ?>";
				window.location="../_admin_inscriptos.php?p=" + p + "";
			</script>
		<?php	
	break;
	case '2': // falta seleccionar al menos un estado para exportar 
		$_SESSION['var_retorno_']= 'exl_estado_er';		$_SESSION['msj_retorno_']= 'Falta seleccionar al menos un estado para exportar'; 
		?>
			<script type="text/javascript">
				var p = "<?php echo $id ?>";
				window.location="../_admin_inscriptos.php?p=" + p + "";
			</script>
		<?php
	break;
	case '3': // no existen datos para exportar con esos estado seleccionados
		$_SESSION['var_retorno_']= 'exl_datos_er';		$_SESSION['msj_retorno_']= 'No existen datos para Exportar';
		?>
			<script type="text/javascript">
				var p = "<?php echo $id ?>";
				window.location="../_admin_inscriptos.php?p=" + p + "";
			</script>
		<?php
	break;
	case '0': // generar el excel
		// Crea un nuevo objeto PHPExcel
		$nombre_cap    = $Cap->get_datos_curso_x_id($id); $nombre = $nombre_cap[0]['nombre'];
		
		include ('./PHPExcel18/Classes/PHPExcel.php');
		$objPHPExcel = new PHPExcel();

		// Establecer propiedades
		$objPHPExcel->getProperties()
		->setCreator("Cattivo")
		->setLastModifiedBy("Cattivo")
		->setTitle("Excel generado desde GSJ")
		->setSubject("Documento Excel")
		->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
		->setKeywords("Excel Office 2007 openxml php")
		->setCategory("Excel");

		for($t=0; $t<count($arr_datos); $t++){
			switch ($arr_datos[$t]['nivel_alcanzado']){
				case '1': $arr_datos[$t]['nivel_alcanzado'] = 'Primario (Incompleto)';      break;
				case '2': $arr_datos[$t]['nivel_alcanzado'] = 'Primario (Completo)';        break;
				case '3': $arr_datos[$t]['nivel_alcanzado'] = 'Secundario (Incompleto)';    break;
				case '4': $arr_datos[$t]['nivel_alcanzado'] = 'Secundario (Completo)';      break;
				case '5': $arr_datos[$t]['nivel_alcanzado'] = 'Terciario (Incompleto)';     break;
				case '6': $arr_datos[$t]['nivel_alcanzado'] = 'Terciario (Completo)';       break;
				case '7': $arr_datos[$t]['nivel_alcanzado'] = 'Universitario (Incompleto)'; break;
				case '8': $arr_datos[$t]['nivel_alcanzado'] = 'Universitario (Completo)';   break;
				Default:  $arr_datos[$t]['nivel_alcanzado'] =  'Sin Información'; break;
			}
			switch ($arr_datos[$t]['trabajo_actual']){
				case 'desem': $arr_datos[$t]['trabajo_actual'] = 'Desempleado';            break;
				case 'indep': $arr_datos[$t]['trabajo_actual'] = 'De forma Independiente'; break;
				case 'depen': $arr_datos[$t]['trabajo_actual'] = 'De forma Dependiente';   break;
				Default:      $arr_datos[$t]['trabajo_actual'] = 'Sin Información'; break;
			}
			switch ($arr_datos[$t]['conoce_rubro']){
				case '0': $arr_datos[$t]['conoce_rubro'] = 'No';              break;
				case '1': $arr_datos[$t]['conoce_rubro'] = 'Si';              break;
				Default : $arr_datos[$t]['conoce_rubro'] = 'Sin Información'; break;
			}
			switch ($arr_datos[$t]['capacit_ant']){
				case '0': $arr_datos[$t]['capacit_ant'] = 'No';              break;
				case '1': $arr_datos[$t]['capacit_ant'] = 'Si';              break;
				Default : $arr_datos[$t]['capacit_ant'] = 'Sin Información'; break;
			}
		}
		
		$abc   = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S');

		$titulo= array('DNI','APELLIDO','NOMBRE','SEXO','DEPARTAMENTO','DIRECCION NRO','DIRECCION CALLE','CORREO','TELEFONO','FECHA NAC.','ESTADO', 'NIVEL ALCANZADO',
		               'TITULO ESPECIALIDAD','OCUPACION','TRABAJO ACTUAL','TRABAJO ACTUAL HR','CONOCE RUBRO','CAPACITACION ANTERIOR','CAP. ANTERIOR CUAL');
		//i.dni, i.apellido, i.nombre, i.sexo, d.nombre AS nom_depto, i.dir_nro, dir_calle, i.correo, i.telefono, i.f_nacimiento, ic.estado
		// e.nivel_alcanzado, e.titulo_especialidad, e.ocupacion, e.trabajo_actual, e.trabajo_actual_hs, e.conoce_rubro, e.capacit_ant, e.capacit_ant_cual
		$campos= array('dni', 'apellido', 'nombre', 'sexo', 'nom_depto', 'dir_nro', 'dir_calle', 'correo', 'telefono', 'f_nacimiento', 'estado',
		'nivel_alcanzado', 'titulo_especialidad', 'ocupacion', 'trabajo_actual', 'trabajo_actual_hs', 'conoce_rubro', 'capacit_ant', 'capacit_ant_cual');

		// titulos
		for ($m=0 ; $m<count($titulo) ; ++$m) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($abc[$m].'1',$titulo[$m]);
		}

		// filas
		$celda= array();
		$valor= array();
		$f    = 2;
		for ($j=0 ; $j<count($arr_datos) ; ++$j) {
			for ($i=0 ; $i<count($campos) ; ++$i) {
				array_push($celda, $abc[$i].$f);
				array_push($valor, $arr_datos[$j][$campos[$i]]);
			}
			++$f;
		}
		$kknt = count($celda);
		for ($i=0 ; $i<$kknt ; ++$i) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda[$i],$valor[$i]);
		}
		$fecha= date("Y-m-d H:i:s");
		// Renombrar Hoja
		$objPHPExcel->getActiveSheet()->setTitle('Inscriptos');

		// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
		$objPHPExcel->setActiveSheetIndex(0);

		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fecha.' '.$nombre.'.xls');
		// header('Content-Disposition: attachment;filename='.$fecha.' Inscriptos al curso.xls');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	break;
}
?>

