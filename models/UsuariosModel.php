<?php

class UsuariosModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getUsuarios()
  {
    $sql = "SELECT u.id, u.usuario, u.correo, u.estado, r.id as id_rol, r.rol FROM users u INNER JOIN roles r WHERE u.id_rol = r.id";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getRoles()
  {
    $sql = "SELECT * FROM roles WHERE estado = 1";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function registrar($usuario, $correo, $clave, $rol)
  {
    $sql = "INSERT INTO users (usuario, correo, clave, id_rol) VALUES (?,?,?,?)";
    $datos = array($usuario, $correo, $clave, $rol);
    return $this->insertar($sql, $datos);
  }

  public function delete($id)
  {
    $sql = "UPDATE users SET estado = ? WHERE id = ?";
    $datos = array(0, $id);
    return $this->save($sql, $datos);
  }

  public function getUsuario($id)
  {
    $sql = "SELECT u.id, u.usuario, u.correo, u.estado,
    CASE
        WHEN r.estado = 0 THEN 0
        ELSE r.id
    END AS id_rol,
    r.rol, r.estado AS estadoR
FROM users u
LEFT JOIN roles r ON u.id_rol = r.id
WHERE u.id = $id";
    return $this->select($sql);
  }

  public function accionUser($estado, $id)
  {
    $sql = "UPDATE users SET estado = ? WHERE id = ?";
    $datos = array($estado, $id);
    $data = $this->save($sql, $datos);
    return $data;
  }

  public function getVerificar($item, $nombre, $id)
  {
    if ($id > 0) {
      $sql = "SELECT * FROM users WHERE $item = '$nombre' AND id != $id AND estado = 1";
    } else {
      $sql = "SELECT * FROM users WHERE $item = '$nombre' AND estado = 1";
    }
    
    return $this->select($sql);
  }

  public function modificar($usuario, $correo, $rol, $id)
  {
    $sql = "UPDATE users SET usuario = ?, correo = ?, id_rol = ? WHERE id = ?";
    $datos = array($usuario, $correo, $rol, $id);
    return $this->save($sql, $datos);
  }
}
