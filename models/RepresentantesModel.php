<?php

class RepresentantesModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getRepresentante($id)
  {
    $sql = "SELECT r.*, d.nombre, d.apellido, d.fecha_nac, d.direccion
    FROM representantes r
    INNER JOIN datos_personales d
    WHERE r.id_datosR = d.id
    AND r.id = $id";
    return $this->select($sql);
  }

  public function getRepresentantes()
  {
    $sql = "SELECT r.id, r.cedula, r.telefono, r.relacion, d.nombre, d.apellido, d.fecha_nac, d.direccion
    FROM representantes r
    INNER JOIN datos_personales d ON r.id_datosR = d.id";

    return $this->selectAll($sql);
  }

  public function registrarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion)
  {
    $sql = "INSERT INTO datos_personales (nombre, apellido, fecha_nac, direccion) VALUES (?, ?, ?, ?)";
    $datos = array($nombre, $apellido, $fechaNacimiento, $direccion);
    return $this->insertar($sql, $datos);
  }

  public function registrarRepresentantes($cedula, $telefono, $relacion, $idDatosR)
  {
    $sql = "INSERT INTO representantes (cedula, telefono, relacion, id_datosR) VALUES (?,?,?,?)";
    $datos = array($cedula, $telefono, $relacion, $idDatosR);
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

  public function modificarRepresentantes($cedula, $telefono, $relacion, $idDatos, $idRepre)
  {
    $sql = "UPDATE representantes 
    SET cedula = ?, telefono = ?, relacion = ?, id_datosR = ?
    WHERE id = ?";
    $datos = array($cedula, $telefono, $relacion, $idDatos, $idRepre);
    return $this->save($sql, $datos);
  }

  public function getVerificar($item, $nombre, $id)
  {
    if ($id > 0) {
      $sql = "SELECT * FROM representantes WHERE $item = '$nombre' AND id != $id";
    } else {
      $sql = "SELECT * FROM representantes WHERE $item = '$nombre'";
    }

    return $this->select($sql);
  }

  public function comprobarE($id)
  {
    $sql = "SELECT r.id AS representante_id, a.id AS alumno_id
    FROM representantes r
    LEFT JOIN alumnos a ON r.id = a.id_representante
    WHERE a.id IS NOT NULL
    AND r.id = $id";
    return $this->select($sql);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM representantes WHERE id = ?";
    $datos = array($id);

    $eliminado = $this->save($sql, $datos);

    $sqlUpdateAI = ["SET @count = 0;", "UPDATE representantes SET id = @count:=@count+1;" , "ALTER TABLE representantes AUTO_INCREMENT = 1;"];

    $this->multiQueryU($sqlUpdateAI);

    return $eliminado;
  }
}