<?php

class RolesModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getRoles()
  {
    $data = $this->selectAll("SELECT * FROM roles");
    return $data;
  }

  public function getRol($id){
    $sql = "SELECT * FROM roles WHERE id = $id";
    return $this->select($sql);
  }

  public function registrar($rol)
  {
    $sql = "INSERT INTO roles (rol) VALUES (?)";
    $datos = array($rol);
    return $this->insertar($sql, $datos);
  }

  public function getVerificar($item, $nombre, $id)
  {
    if ($id > 0) {
      $sql = "SELECT * FROM roles WHERE $item = '$nombre' AND id != $id AND estado = 1";
    } else {
      $sql = "SELECT * FROM roles WHERE $item = '$nombre' AND estado = 1";
    }
    
    return $this->select($sql);
  }

  public function delete($id){
    $sql = "UPDATE roles SET estado = ? WHERE id = ? ";
    $datos = array(0, $id);
    return $this->save($sql, $datos);
  }

  public function reingresar($id){
    $sql = "UPDATE roles SET estado = ? WHERE id = ? ";
    $datos = array(1, $id);
    return $this->save($sql, $datos);
  }

  public function modificar($rol, $id){
    $sql = "UPDATE roles SET rol = ? WHERE id = ?";
    $datos = array($rol, $id);
    return $this->save($sql, $datos);
  }
}
