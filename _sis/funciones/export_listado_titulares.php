<?php
session_start();
header('Content-Type: text/html; charset=UTF-8'); 
require_once('inscriptos.php');
require_once('capacitaciones.php');
date_default_timezone_set('America/Argentina/San_Juan');
$I   = new Inscriptos();
$Cap = new Capacitaciones();

$arr_datos = array();
$nombre_cap= array();

if (isset($_GET["p"])) { $id_curso = $_GET["p"];} else { $id_curso = ''; }

$nombre_cap = $Cap->get_datos_curso_x_id($id_curso); $nombre = $nombre_cap[0]['nombre'];
$arr_datos  = $I->gets_titulares_con_sin_notas($id_curso);

// generar el excel
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

$abc   = array('A','B','C','D','E','F');
$titulo= array('DNI','APELLIDO Y NOMBRE','TELEFONO', 'CORREO','DEPARTAMENTO','NOTA');
$campos= array('dni', 'inscripto_nom', 'telefono', 'correo', 'nombre', 'nota');

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
header('Content-Disposition: attachment;filename='.$fecha.'Listado Titulares-'.$nombre.'.xls');
// header('Content-Disposition: attachment;filename='.$fecha.' Inscriptos al curso.xls');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>

