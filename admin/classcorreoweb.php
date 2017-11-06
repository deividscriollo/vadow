<?php 
require_once('PHPMailer/class.phpmailer.php');
/**
* correo por david criollo
*/
class email{
	function enviar($correo, $nombre, $titulo, $html){
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$body = $html;//contenido con etiquetas HTML
		//defino el email y nombre del remitente del mensaje
		$mail->SetFrom('webmaster@nextbook.ec', 'NextBook');
		$mail->AddReplyTo("webmaster@nextbook.ec","NextBook");
		$mail->AddAddress($correo, $nombre);// adrees + name destinatario
		//Añado un asunto al mensaje
		$mail->Subject = $proceso;
		//Puedo definir un cuerpo alternativo del mensaje, que contenga solo texto
		$mail->AltBody = "una iniciativa de business group";
		//inserto el texto del mensaje en formato HTML
		$mail->MsgHTML($body);
		return $mail->Send() ;
	}
	function url_(){
		return 'http://www.nextbook.ec/';
	}
}

?>