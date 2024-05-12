<?php

class ProfesoresModel extends Query
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getProfesores()
  {
    $sql = "SELECT p.id, p.cedula, p.telefono, p.correo , g.descripcion as grado, d.nombre, d.apellido, d.fecha_nac, d.direccion
    FROM profesores p
    INNER JOIN datos_personales d ON p.id_datosP = d.id
    INNER JOIN grados g ON p.id_grado = g.id";

    return $this->selectAll($sql);
  }

  public function getGrados()
  {
    $sql = "SELECT * FROM grados";
    return $this->selectAll($sql);
  }

  public function getProfesor($id)
  {
    $sql = "SELECT p.*, d.nombre, d.apellido, d.fecha_nac, d.direccion
    FROM profesores p
    INNER JOIN datos_personales d
    WHERE p.id_datosP = d.id
    AND p.id = $id";
    return $this->select($sql);
  }

  public function getVerificar($item, $nombre, $id)
  {
    if ($id > 0) {
      $sql = "SELECT * FROM profesores WHERE $item = '$nombre' AND id != $id";
    } else {
      $sql = "SELECT * FROM profesores WHERE $item = '$nombre'";
    }

    return $this->select($sql);
  }

  public function registrarDatosPersonales($nombre, $apellido, $fecha, $direccion)
  {
    $sql = "INSERT INTO datos_personales (nombre, apellido, fecha_nac, direccion) VALUES (?, ?, ?, ?)";
    $datos = array($nombre, $apellido, $fecha, $direccion);
    return $this->insertar($sql, $datos);
  }

  public function registrarProfesores($cedula, $telefono, $correo, $grado, $idDatosP)
  {
    $sql = "INSERT INTO profesores (cedula, telefono, correo, id_grado, id_datosP) VALUES (?,?,?,?,?)";
    $datos = array($cedula, $telefono, $correo, $grado, $idDatosP);
    return $this->insertar($sql, $datos);
  }

  public function modificarDatosPersonales($nombre, $apellido, $fecha, $direccion, $id)
  {
    $sql = "UPDATE datos_personales 
    SET nombre = ?, apellido = ?, fecha_nac = ?, direccion = ?
    WHERE id = ?";
    $datos = array($nombre, $apellido, $fecha, $direccion, $id);
    return $this->save($sql, $datos);
  }

  public function modificarProfesores($cedula, $telefono, $correo, $grado, $idDatos, $idProfe)
  {
    $sql = "UPDATE profesores 
    SET cedula = ?, telefono = ?, correo = ?, id_grado = ?, id_datosP = ?
    WHERE id = ?";
    $datos = array($cedula, $telefono, $correo, $grado, $idDatos, $idProfe);
    return $this->save($sql, $datos);
  }
}