<?php 
session_start();
include('inscriptos.php');	$I = new Inscriptos();

// recibo el id de la capacitacion
$id_curso         = $_GET['p'];
// hago la consulta para traer los datos
$datos = array();
$datos = $I->gets_errores_capacitacion($id_curso);
$saltoLinea="\r\n";
$string ='';

//Genero el txt.
header('Content-Type: text/html; charset=UTF-8'); 
$basedir = dirname(__FILE__) ;
// Tipo MIME del archivo
header('Content-Type: text/plain');

// Indica que lo descargue
date_default_timezone_set('America/Argentina/San_Juan');
$fecha= date("Y-m-d H:i:s");
header('Content-Disposition: attachment; filename='.$fecha.'Informe_importar_notas.txt');

for($i=0; $i<count($datos); $i++){
	$string.= $datos[$i]['fk_inscripto'].' - '.$datos[$i]['motivo'].$saltoLinea;
}

print($string);

?>

