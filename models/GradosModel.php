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

    $eliminado = $this->save($sql, $datos);

    $sqlUpdateAI = ["SET @count = 0;", "UPDATE grados SET id = @count:=@count+1;" , "ALTER TABLE grados AUTO_INCREMENT = 1;"];

    $this->multiQueryU($sqlUpdateAI);

    return $eliminado;
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

  public function comprobarE($id)
  {
    $sql = "SELECT g.id as id_grados, p.id as id_profes
    FROM grados g
    INNER JOIN profesores p
    ON g.id = p.id_grado
    WHERE g.id = $id";
    return $this->select($sql);
  }
}
