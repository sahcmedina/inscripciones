<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('conexion_pdo.php');
class CorreoElectronico {
	
	/**
	TABLAS AFECTADAS: 
	* 	(actualización) 
	*   (consulta) 
	*/
	
	/**
	ESTADOS: 
	* 	() 
	*/	
	
	function envio_correo($destinatario, $asunto, $mensaje){		
		require_once ("../mail/class.phpmailer.php");
		require_once ("../mail/class.smtp.php");
		require_once ("../mail/PHPMailerAutoload.php");
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet   = 'UTF-8';
		$mail->SMTPAuth  = true;
		
		// (configuracion 1)
		// $mail->SMTPSecure= "ssl";
		// $mail->Host      = "mail.colegiomedico.org.ar";
		// $mail->Port      = 465;
		// $mail->Username  = 'intranet@colegiomedico.org.ar'; 
		// $mail->Password  = 'c1m9s5j4sj1954UR';
		// $mail->FromName  = 'Sistema ArgOliva';
		// $mail->From      = 'intranet@colegiomedico.org.ar';		
		
		//$mail->Password  = 'wg*FjE39rF';
		//$mail->Username  = 'rodolfo.leon@colegiomedico.org.ar';
		//$mail->From      = 'rodolfo.leon@colegiomedico.org.ar';

		// (configuracion 2)
		$mail->SMTPSecure= "tls";
		$mail->Host      = "smtp.colegiomedico.org.ar";
		$mail->Port      = 587; 
		$mail->Username  = 'intranet@colegiomedico.org.ar';
		$mail->Password  = 'c1m9s5j4sj1954UR';
		$mail_remitente  = 'intranet@colegiomedico.org.ar';
		$mail->FromName  = 'Sistema ArgOliva';
		$mail->From      = $mail_remitente;

		$mail->AddAddress($destinatario);
		
		$mail->Subject   = $asunto;
		$mail->AltBody   = $mensaje;
		$mail->MsgHTML($mensaje);
		if(!$mail->Send()) {  echo $mail->ErrorInfo;}
	}

	function envio_correo_new($destinatario, $asunto, $mensaje){			

		include_once ('../PHPMailer/Exception.php');
		include_once ('../PHPMailer/PHPMailer.php');
		include_once ('../PHPMailer/SMTP.php');

		$return= '';

		$mail2            = new PHPMailer();
		$mail2->SMTPDebug = 0;
		$mail2->IsSMTP();
		$mail2->CharSet   = 'UTF-8';
		$mail2->SMTPAuth  = true;

		$mail2->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		$mail2->SMTPSecure= "tls";
		$mail2->Host      = "smtp.mail.yahoo.com.ar";
		$mail2->Port      = 587; 
		$mail2->Username  = 'miguelangel_medina@yahoo.com.ar';
		$mail2->Password  = 'icwpgzkzmhwlopyc';
		$mail2->setFrom('miguelangel_medina@yahoo.com.ar', 'ArgOliva - Gob. San Juan');
		
		$mail2->AddAddress($destinatario);
		$mail2->isHTML(true);
		$mail2->Subject   = $asunto;
		$mail2->AltBody   = $mensaje;
		$mail2->MsgHTML($mensaje);
		
		if(!$mail2->Send()) {  $return= $mail2->ErrorInfo;}
		
		return $return;
	}

	function tf_correo_valido($email){		
		$mail_correcto = 0;
		//compruebo unas cosas primeras
	   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
	    	if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
	        	//miro si tiene caracter .
	         	if (substr_count($email,".")>= 1){
		            //obtengo la terminacion del dominio
		            $term_dom = substr(strrchr ($email, '.'),1);
		            //compruebo que la terminación del dominio sea correcta
		            if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
		            	//compruebo que lo de antes del dominio sea correcto
		               	$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
		               	$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
		               	if ($caracter_ult != "@" && $caracter_ult != "."){
		                	$mail_correcto = 1;
		               	}
		            }
		        }
	      	}
	   }
	   if ($mail_correcto)
	      return true;
	   else
	      return false;
	}
	
}
?>