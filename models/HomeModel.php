<?php
 
  class HomeModel extends Query{
    public function __construct() {
      parent::__construct();
    }

    public function getUsuario(string $usuario){
      return $this->select("SELECT * FROM users WHERE usuario = '$usuario' AND estado = 1");
    }
  }