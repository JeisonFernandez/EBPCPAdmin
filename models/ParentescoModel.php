<?php

class ParentescoModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getParentesco()
  {
    $sql = "SELECT * FROM parentesco_alumno";
    $data = $this->selectAll($sql);
    return $data;
  }

  

  public function registrarParentesco( $descripcion)
  {
    $sql = "INSERT INTO parentesco_alumno (relacion) VALUES ( ?)";
    $datos = array( $descripcion);
    return $this->insertar($sql, $datos);
  }

  
  public function eliminarParentesco($id)
  {
    $sql = "DELETE FROM parentesco_alumno WHERE id = ?";
    $datos = array($id);
    return $this->save($sql, $datos);
  }

  

  public function getParent($id)
  {
    $sql="SELECT * FROM parentesco_alumno WHERE id =$id";
    return $this->select($sql);
   
  }


 public function modificarParentesco(  $descripcion, $id)
  {
   
    $sql = "UPDATE parentesco_alumno SET  relacion = ? WHERE id = ?";
    $datos = array( $descripcion, $id); 
    return $this->save($sql, $datos);

  }

  
}
