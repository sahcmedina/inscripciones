<?php
session_start();
header('Content-Type: text/html; charset=UTF-8'); 
require_once('inscriptos.php');
date_default_timezone_set('America/Argentina/San_Juan');
$Ins   = new Inscriptos();

$arr_datos     = array();
$arr_datos     = $Ins->gets_lista_negra();
$upp = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ');
$low = array('á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ');

$op=0;
if (count($arr_datos)<= 0) { $op=1 ;}
	else{
	 	for ($t=0; $t<count($arr_datos); $t++) {
			$arr_datos[$t]['apellido'] = str_replace($low, $upp, strtoupper($arr_datos[$t]['apellido']));
	 		$arr_datos[$t]['nombre']   = str_replace($low, $upp, strtoupper($arr_datos[$t]['nombre']));
	 	}
	}

switch ($op){
	case '1':
		$_SESSION['var_retorno_']= 'exl_datos_er';		$_SESSION['msj_retorno_']= 'No existen datos para Exportar';
		?>
			<script type="text/javascript">
				window.location="../_admin_lista_negra.php";
			</script>
		<?php
	break;
	case '0': // generar el excel
		// Crea un nuevo objeto PHPExcel
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

		$abc   = array('A','B','C','D','E','F','G','H','I');

		$titulo= array('DNI','APELLIDO','NOMBRE','DEPARTAMENTO','CAPACITACION','TELEFONO','EMAIL','DESDE','HASTA');
		//ln.*, c.nombre AS capaci, ins.dni, ins.apellido, ins.nombre, ins.correo, ins.telefono, d.nombre AS dpto_cap, d2.nombre AS dpto_pers
		$campos= array('dni', 'apellido', 'nombre', 'dpto_cap', 'capaci', 'telefono', 'correo', 'f_ini', 'f_fin');

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
		$objPHPExcel->getActiveSheet()->setTitle('ListaNegra');

		// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
		$objPHPExcel->setActiveSheetIndex(0);

		// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fecha.'Lista Negra Completa.xls');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	break;
}
?>

