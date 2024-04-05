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

  public function registrar($rol)
  {
    $sql = "INSERT INTO roles (rol) VALUES (?)";
    $datos = array($rol);
    return $this->insertar($sql, $datos);
  }

  public function getVerificar($item, $nombre)
  {
    $sql = "SELECT * FROM roles WHERE $item = '$nombre' AND estado = 1";
    return $this->select($sql);
  }

}
