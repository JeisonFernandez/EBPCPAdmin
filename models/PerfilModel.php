<?php
 
  class PerfilModel extends Query{
    public function __construct(){
      parent::__construct();
    }

    public function verificar($claveActual, $id){

      $sql = "SELECT * FROM users WHERE id = $id";
      $user = $this->select($sql);
      $clave = $user['clave'];
      $verificarClave = password_verify($claveActual,  $clave);
      
      return $verificarClave;
    }

    public function changePass($claveNew, $id){
      $hashed = password_hash($claveNew, PASSWORD_DEFAULT);

      $sql = "UPDATE users SET clave = ? WHERE id = ?";
      $datos = array($hashed, $id);

      return $this->save($sql, $datos);
    }
  }