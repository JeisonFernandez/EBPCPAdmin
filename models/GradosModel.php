<?php

class GradosModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getGrados()
  {
    $sql = "SELECT 
        id,
        grado,
        seccion,
        descripcion,
        duracion,
        CONCAT(grado, ' ', seccion) AS grado_descr
    FROM 
        grados";
    $data = $this->selectAll($sql);
    return $data;
  }

  

  public function registrarGrados($grado, $seccion, $descripcion, $duracion)
  {
    $sql = "INSERT INTO grados (grado, seccion, descripcion, duracion) VALUES (?, ?, ?, ?)";
    $datos = array($grado, $seccion, $descripcion, $duracion);
    return $this->insertar($sql, $datos);
  }

  
  public function eliminarGrados($id)
  {
    $sql = "DELETE FROM grados WHERE id = ?";
    $datos = array($id);
    return $this->save($sql, $datos);
  }

  

  public function getGrado($id)
  {
    $sql="SELECT * FROM grados
     WHERE id =$id";
    return $this->select($sql);
   
  }


 public function modificarGrados( $grado, $seccion, $descripcion, $duracion, $id)
  {
   
    $sql = "UPDATE grados SET grado = ?, seccion = ?, descripcion = ?, duracion = ? WHERE id = ?";
    $datos = array($grado, $seccion, $descripcion, $duracion, $id); 
    return $this->save($sql, $datos);

  }

  
}
