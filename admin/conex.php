<?php
  class BaseDeDato {
    private $Servidor;
    private $Puerto;
    private $Nombre;
    private $Usuario;
    private $Clave;

    function __construct($Servidor, $Puerto, $Nombre, $Usuario, $Clave) {
      $this -> Servidor = $Servidor;
      $this -> Puerto = $Puerto;
      $this -> Nombre = $Nombre;
      $this -> Usuario = $Usuario;
      $this -> Clave = $Clave;
    }

    function Conectar() {
      $BaseDato = pg_connect("host=$this->Servidor port=$this->Puerto dbname=$this->Nombre user=$this->Usuario password=$this->Clave");
      return $BaseDato;
    }

    function Consultas($Consulta) {
      $Valor = $this -> Conectar();
      if (!$Valor)
        return 0; //Si no se pudo conectar
      else {
        //Valor es resultado de base de dato y Consulta es la Consulta a realizar
        $Resultado = pg_query($Valor, $Consulta);
        return $Resultado; // retorna si fue afectada una fila
      }
    }
  }
?>