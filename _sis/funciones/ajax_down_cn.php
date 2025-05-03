<?php

if (isset($_POST["dni"]))       { $dni= utf8_decode($_POST["dni"]);        } else { $dni= '';   }
if (isset($_POST["curso"]))     { $curso= utf8_decode($_POST["curso"]);    } else { $curso= ''; }

include('./inscriptos.php'); 		$Insc= new Inscriptos();

$hay_CN =  $Insc->tf_req_CN($dni); 
if($hay_CN){
	$arr_req           = array();
	$arr_req           = $Insc->gets_requisito_x_capacit($dni, $curso,'Certificacion Negativa');											
	$nombre_archivo_pdf= 'Certificado_Negativo_'.$dni.'.'.$arr_req[0]['extension'];
	$archivo_b64_CN    = $arr_req[0]['archivo'];
	$ver_Certif_Neg    ='<a download="'.$nombre_archivo_pdf.'" href="data:application/octet-stream;base64,'.$archivo_b64_CN.'" target="_blank" ?title="Haga clic para ver la poliza." ><IMG src="./images/pdf.png" title="Haga clic para ver el PDF."></a>';
}else{
	$ver_Certif_Neg    = '';
}					

echo $ver_Certif_Neg;

?>