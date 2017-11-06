<?php
  require_once('PHPMailer/PHPMailerAutoload.php');

  class email  extends PHPMailer {
    var $tu_email = 'deividscriollo@gmail.com';
    var $tu_nombre = 'Nextbook';
    var $tu_password ='CROnos_1021';

    public function __construct() {
      $this->IsSMTP(); // protocolo de transferencia de correo
      $this->Host = 'smtp.gmail.com';  // Servidor GMAIL
      $this->Port = 465; //puerto
      $this->SMTPAuth = true; // Habilitar la autenticación SMTP
      $this->Username = $this->tu_email;
      $this->Password = $this->tu_password;
      $this->SMTPSecure = 'ssl';  //habilita la encriptacion SSL
       //remitente
      $this->From = $this->tu_email;
      $this->FromName = $this->tu_nombre;
    }

    public function enviar( $para, $nombre, $titulo , $contenido){
      $this->AddAddress( $para ,  $nombre );  // Correo y nombre a quien se envia
      $this->WordWrap = 50; // Ajuste de texto
      $this->IsHTML(true); //establece formato HTML para el contenido
      $this->Subject =$titulo;
      $this->Body    =  $contenido; //contenido con etiquetas HTML
      $this->AltBody =  strip_tags($contenido); //Contenido para servidores que no aceptan HTML
       //envio de e-mail y retorno de resultado
      return $this->Send() ;
   	}

    public function url_() {
  		return $_SERVER['SERVER_NAME'].'/book/';
  	}
  }
?>