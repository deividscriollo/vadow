<?php

  include_once("conex.php");
  include("constante.php");

  class constante {
    private $login;
    private $contrasena;
    private $cedula;
    private $tipo;
    private $status;

    public function consulta($q) {
      $BaseDato = new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);//declarar el objeto de la clase base de dato
      $result = $BaseDato->Consultas($q);
      return $result;
    }

    public function fetch_array($consulta) {
      return pg_fetch_array($consulta);
    }

    public function num_rows($consulta) {
      return pg_num_rows($consulta);
    }

    public function getTotalConsultas() {
      return $this->total_consultas; 
    }

    public function sqlcon($q) {
      $BaseDato = new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);//declarar el objeto de la clase base de dato
      $result = $BaseDato->Consultas($q);
      if(pg_affected_rows($result) >= 0)
      return 1;
        else
      return 0;
    }

    //generador de id unicos
    function idz(){
      date_default_timezone_set('America/Guayaquil');
      $fecha = date("YmdHis");
      return($fecha.uniqid()); 
    }
    // fin

    // generamos ip del cliente
    function client_ip() {
      $ipaddress = '';
      if ($_SERVER['HTTP_CLIENT_IP'])
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if($_SERVER['HTTP_X_FORWARDED_FOR'])
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if($_SERVER['HTTP_X_FORWARDED'])
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if($_SERVER['HTTP_FORWARDED_FOR'])
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if($_SERVER['HTTP_FORWARDED'])
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if($_SERVER['REMOTE_ADDR'])
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
    }
    // fin

    // generamos edad
    public function edad($fecha) {
      $dias = explode("-", $fecha, 3);
      $dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
      $edad = (int)((time() - $dias) / 31556926 );
      return $edad;
    }
    // fin

    // dias de la semana
    function diaSemana($ano,$mes,$dia) {
      $dia = date("w",mktime(0, 0, 0, $mes, $dia, $ano));
      if ($dia == 1) {
        return 'LUNES';
      } elseif ($dia == 1) {
        return 'LUNES';
      } elseif ($dia == 2) {
        return 'MARTES';
      } elseif ($dia == 3) {
        return 'MIERCOLES';
      } elseif ($dia == 4) {
        return 'JUEVES';
      } elseif ($dia == 5) {
        return 'VIERNES';
      } elseif ($dia == 6) {
        return 'SABADO';
      } elseif ($dia == 7) {
        return 'DOMINGO';
      }  
    }
    // fin
      
    // generamos fecha
    public function fecha() {
      $fecha = date("Y-m-d");
      return $fecha;
    }
    // fin 

    // generamos hora
    public function hora() {
      date_default_timezone_set('America/Guayaquil');
      $hora = date("H:i:s");
      return $hora;
    }
    // fin 

    // generamos fecha_hora
    public function fecha_hora() {
      date_default_timezone_set('America/Guayaquil');
      $fecha = date("Y-m-d H:i:s");
      return $fecha;
    }
    // fin 

    // generamos clave aleatoria
    public function clave_aleatoria() {
      $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      $cad = "";
      for($i = 0; $i < 10; $i++) {
      $cad .= substr($str,rand(0,62),1);
      }
      return $cad;
    }
    // fin

    // generar password aleatorio
    function generaPass() {
      //Se define una cadena de caractares. Te recomiendo que uses esta.
      $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      //Obtenemos la longitud de la cadena de caracteres
      $longitudCadena = strlen($cadena);
       
      //Se define la variable que va a contener la contraseña
      $pass = "";
      //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
      $longitudPass = 10;
       
      //Creamos la contraseña
      for ($i = 1; $i <= $longitudPass; $i++) {
          //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
          $pos = rand(0, $longitudCadena - 1);

          //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
          $pass.= substr($cadena, $pos, 1);
      }
      return $pass;
    }
    // fin
  }
?>