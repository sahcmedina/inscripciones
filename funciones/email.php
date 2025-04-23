<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {	

	function enviar_correo($email, $titulo, $mensaje){			

		include_once ('./PHPMailer/Exception.php');
		include_once ('./PHPMailer/PHPMailer.php');
		include_once ('./PHPMailer/SMTP.php');

		$return           = '';

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
		
		$mail2->AddAddress($email);

		// $cant_email = count($arr_mail);
		// for($i=0; $i<$cant_email; $i++) {
		// 	$mail2->AddAddress($arr_mail[$i]['email']);
		// }

		$mail2->isHTML(true);
		$mail2->Subject   = $titulo;
		$mail2->AltBody   = $mensaje;
		$mail2->MsgHTML($mensaje);
		
		if(!$mail2->Send()) {  $return= $mail2->ErrorInfo;}
		
		return $return;
	}
	
	function enviar_correo_OLD($arr_mail, $titulo, $mensaje){			

		include_once ('./PHPMailer/Exception.php');
		include_once ('./PHPMailer/PHPMailer.php');
		include_once ('./PHPMailer/SMTP.php');

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
		$mail2->Username  = 'email@email.com';
		$mail2->Password  = 'pass';
		$mail2->setFrom('email@email.com', 'Programa ATP - Gob. San Juan');
		
		$cant_email = count($arr_mail);
		for($i=0; $i<$cant_email; $i++) {
			$mail2->AddAddress($arr_mail[$i]['email']);
		}

		$mail2->isHTML(true);
		$mail2->Subject   = $titulo;
		$mail2->AltBody   = $mensaje;
		$mail2->MsgHTML($mensaje);
		
		if(!$mail2->Send()) {  $return= $mail2->ErrorInfo;}
		
		return $return;
	}
	
	function gets_lotes_email_enviados(){
		include('conexion_pdo.php');
		$query_= "SELECT *, date_format(fecha_hs, '%d/%m/%Y') AS f_, date_format(fecha_hs, '%H:%i') AS hs_ FROM inscriptos_capacitacion_email_lote ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_cuerpo_email_enviados($id){
		include('conexion_pdo.php');
		$query_= "SELECT e.*, concat(i.apellido,', ',i.nombre) AS persona 
				  FROM inscriptos_capacitacion_email_cuerpo AS e
				  	   INNER JOIN inscriptos AS i ON i.dni = e.fk_inscripto
				  WHERE e.fk_lote= :fk_lote";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_lote', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
}
?>