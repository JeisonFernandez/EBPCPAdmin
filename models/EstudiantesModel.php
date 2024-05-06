<?php

class EstudiantesModel extends Query
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getEstudiantes()
  {
      $sql="SELECT 
    alumnos.id, 
    alumnos.talla_camisa,
    alumnos.talla_pantalon, 
    alumnos.peso, 
    alumnos.altura, 
    alumnos.estado,
    alumnos.id_datosA,
    CONCAT(
        datos_representantes.nombre, ' ', 
        datos_representantes.apellido, ' -C.I: ', 
        representantes.cedula, ' -Tlf: ', 
        representantes.telefono, ' -Relacion: ', 
        parentesco_alumno.relacion 
    ) AS representante_info, 
    grados.descripcion AS nombre_grado, 
    grados.descripcion AS descripcion_grado, 
    CONCAT(datos_alumnos.nombre, ' ', datos_alumnos.apellido) AS nombre_completo, 
    datos_alumnos.fecha_nac AS fecha_nacimiento_alumno, 
    datos_alumnos.direccion AS direccion_alumno 
FROM 
    alumnos 
JOIN 
    representantes ON alumnos.id_representante = representantes.id 
JOIN 
    parentesco_alumno ON representantes.relacion = parentesco_alumno.id  

JOIN 
    datos_personales AS datos_representantes ON representantes.id_datosR = datos_representantes.id 
JOIN 
    grados ON alumnos.id_grado = grados.id 
JOIN 
    datos_personales AS datos_alumnos ON alumnos.id_datosA = datos_alumnos.id WHERE estado='cursando'";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getEstudianteByID($id){
    $sql = "SELECT 
    alumnos.id, 
    alumnos.talla_camisa,
    alumnos.talla_pantalon, 
    alumnos.peso, 
    alumnos.altura, 
    alumnos.estado,
    alumnos.id_datosA,
    CONCAT(
        datos_representantes.nombre, ' ', 
        datos_representantes.apellido, ' -C.I: ', 
        representantes.cedula, ' -Tlf: ', 
        representantes.telefono, ' -Relacion: ', 
        representantes.relacion
    ) AS representante_info, 
    grados.descripcion AS nombre_grado, 
    grados.descripcion AS descripcion_grado, 
    CONCAT(datos_alumnos.nombre, ' ', datos_alumnos.apellido) AS nombre_completo, 
    datos_alumnos.fecha_nac AS fecha_nacimiento_alumno, 
    datos_alumnos.direccion AS direccion_alumno 
FROM 
    alumnos 
JOIN 
    representantes ON alumnos.id_representante = representantes.id 
JOIN 
    datos_personales AS datos_representantes ON representantes.id_datosR = datos_representantes.id 
JOIN 
    grados ON alumnos.id_grado = grados.id 
JOIN 
    datos_personales AS datos_alumnos ON alumnos.id_datosA = datos_alumnos.id WHERE estado='cursando' AND alumnos.id = $id";
    return $this->select($sql);
  }


  public function getGrados()
  {
    $sql = "SELECT * FROM grados ";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getRepresentantes()
  {
    $sql = "SELECT representantes.id, representantes.cedula, representantes.telefono, representantes.relacion, datos_personales.nombre as nombre, datos_personales.apellido as nombre
    FROM representantes
    INNER JOIN datos_personales ON representantes.id_datosR = datos_personales.id ";
    $data = $this->selectAll($sql);
    return $data;
  }

 
  public function buscarRepresentantes($query)
  {
      $sql = "SELECT representantes.id, representantes.cedula, representantes.telefono, representantes.relacion, datos_personales.nombre, datos_personales.apellido
              FROM representantes
              INNER JOIN datos_personales ON representantes.id_datosR = datos_personales.id
              WHERE datos_personales.nombre LIKE '%$query%' OR datos_personales.apellido LIKE '%$query%' OR representantes.cedula LIKE '%$query%'";
      return $this->selectAll($sql);
  }


  public function registrarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion)
  {
    $sql = "INSERT INTO datos_personales (nombre, apellido, fecha_nac, direccion) VALUES (?, ?, ?, ?)";
    $datos = array($nombre, $apellido, $fechaNacimiento, $direccion);
    return $this->insertar($sql, $datos);
  }

  public function registrarEstudiante($talla_camisa, $talla_pantalon, $peso, $altura, $estado, $idRepresentante, $idGrado, $idDatosA)
  {
    $sql = "INSERT INTO alumnos (talla_camisa, talla_pantalon, peso, altura, estado, id_representante, id_grado, id_datosA) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
    $datos = array($talla_camisa, $talla_pantalon, $peso, $altura, $estado, $idRepresentante, $idGrado, $idDatosA);
    return $this->insertar($sql, $datos);
  }

  public function eliminarEstudiante($id)
  {
    $sql = "DELETE FROM alumnos WHERE id = ?";
    $datos = array($id);
    return $this->save($sql, $datos);
  }

  public function eliminarDatosPersonales($id)
  {
    $sql = "DELETE FROM datos_personales WHERE id=?";
    $datos = array($id);
    return $this->save($sql, $datos);
  }

  public function getEstudiante($id)
  {
    $sql="SELECT 
    alumnos.id, 
    alumnos.talla_camisa,
    alumnos.talla_pantalon, 
    alumnos.peso, 
    alumnos.altura, 
    alumnos.estado, 
    alumnos.id_grado,
    alumnos.id_datosA,
    CONCAT(
        representantes.id, ') ', 
        datos_representantes.nombre, ' ', 
        datos_representantes.apellido 
    ) AS representante_info, 
    grados.descripcion AS nombre_grado, 
    grados.descripcion AS descripcion_grado, 
    datos_alumnos.nombre AS nombre_alumno, 
    datos_alumnos.apellido AS apellido_alumno, 
    datos_alumnos.fecha_nac AS fecha_nacimiento_alumno, 
    datos_alumnos.direccion AS direccion_alumno 
FROM 
    alumnos 
JOIN 
    representantes ON alumnos.id_representante = representantes.id 
JOIN 
    parentesco_alumno ON representantes.relacion = parentesco_alumno.id  
JOIN 
    datos_personales AS datos_representantes ON representantes.id_datosR = datos_representantes.id 
JOIN 
    grados ON alumnos.id_grado = grados.id 
JOIN 
    datos_personales AS datos_alumnos ON alumnos.id_datosA = datos_alumnos.id WHERE alumnos.id =$id";
    return $this->select($sql);
   
  }


  public function getDatosPersonales($id){
    $sql="SELECT id_datosA FROM `alumnos` WHERE id=$id";
    $data = $this->select($sql);
    return $data;
  }

 public function modificarDatosPersonales( $nombre, $apellido, $fechaNacimiento, $direccion, $id)
  {
   
    $sql = "UPDATE datos_personales SET nombre = ?, apellido = ?, fecha_nac = ?, direccion = ? WHERE id = ?";
    $datos = array($nombre, $apellido, $fechaNacimiento, $direccion, $id); 
    return $this->save($sql, $datos);

  }

  public function modificarEstudiante( $talla_camisa, $talla_pantalon, $peso, $altura, $estado, $idRepresentante, $idGrado,$id)
  {
    $sql = "UPDATE alumnos SET talla_camisa = ?, talla_pantalon = ?, peso = ?, altura = ?, estado = ?, id_representante = ?, id_grado = ? WHERE id = ?";
    $datos = array($talla_camisa, $talla_pantalon, $peso, $altura, $estado, $idRepresentante, $idGrado, $id);
    return $this->save($sql, $datos);
  }

  public function agregarHistorico($idAlumno, $fechaInicio, $estadoAnterior, $estadoNuevo)
  {
      $sql = "INSERT INTO historico_alumnos (id_alumno, fecha_inicio, fecha_fin, estado_anterior, estado_nuevo) VALUES (?, ?, NULL, ?, ?)";
      $datos = array($idAlumno, $fechaInicio, $estadoAnterior, $estadoNuevo);
      return $this->insertar($sql, $datos);
  }
  public function modificar_fechaFinHistorico($idAlumno, $fechaFin)
{
    $sql = "UPDATE historico_alumnos SET fecha_fin = ? WHERE id_alumno = ? ";
    $datos = array($fechaFin, $idAlumno); 
    return $this->save($sql, $datos);
}
}
