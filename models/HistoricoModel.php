<?php

class HistoricoModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getHistorico()
  {
    $sql = "SELECT ha.id, 
    ha.fecha_inicio, 
    ha.fecha_fin, 
    ha.estado_anterior, 
    ha.estado_nuevo, 
    a.id AS id_alumno, 
    a.estado AS estado_alumno,
    CONCAT(dp.nombre, ' ', dp.apellido) AS nombre_completo
FROM historico_alumnos ha
INNER JOIN alumnos a ON ha.id_alumno = a.id
INNER JOIN datos_personales dp ON a.id_datosA = dp.id";
    $data = $this->selectAll($sql);
    return $data;
  }

  
  public function eliminarHistorico($id)
  {
    $sql = "DELETE FROM historico_alumnos WHERE id = ?";
    $datos = array($id);
    return $this->save($sql, $datos);
  }

  

  public function getHistory($id)
  {
    $sql="SELECT ha.id, 
    ha.fecha_inicio, 
    ha.fecha_fin, 
    ha.estado_anterior, 
    ha.estado_nuevo, 
    a.id AS id_alumno, 
    a.estado AS estado_alumno,
    CONCAT(dp.nombre, ' ', dp.apellido) AS nombre_completo
FROM historico_alumnos ha
INNER JOIN alumnos a ON ha.id_alumno = a.id
INNER JOIN datos_personales dp ON a.id_datosA = dp.id WHERE ha.id =$id";
    return $this->select($sql);
   
  }


 public function modificarHistorico($fechaInicio, $fechaFin, $id)
  {
   
    $sql = "UPDATE historico_alumnos SET  fecha_inicio = ?, fecha_fin = ? WHERE id = ?";
    $datos = array( $fechaInicio, $fechaFin, $id); 
    return $this->save($sql, $datos);

  }


}
