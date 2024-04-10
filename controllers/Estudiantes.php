<?php

class Estudiantes extends Controller
{

  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['usuario'])) {
      header('Location: ' .  BASE_URL);
      die();
    }
    parent::__construct();
  }

  public function index()
  {
    $data['usuario'] = $_SESSION['usuario'];
    $data['grados'] = $this->model->getGrados();
    $data['representantes'] = $this->model->getRepresentantes();
    $data['script'] = 'estudiantes.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getEstudiantes();
    
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['estado'] == 'cursando') {
            $data[$i]['estado'] = '<span class="badge badge-success">Cursando</span>';
            $data[$i]['acciones'] = '<button title="Editar Estudiante" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
                                     <button title="Eliminar Estudiante" class="btn btn-danger btn-sm" onclick="eliminar('  . $data[$i]['id_datosA'] .')"><i class="fas fa-trash-alt"></i></button>';
        } else {
            $data[$i]['estado'] = '<span class="badge badge-danger">No cursando</span>';
            $data[$i]['acciones'] = '<button title="Editar Estudiante" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
                                     <button title="Eliminar Estudiante" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id_datosA'] . ')"><i class="fas fa-trash-alt"></i></button>';
        }
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function buscarRepresentantes()
{
  if(isset($_POST['query'])){
    $query = $_POST['query']; 
    $representantes = $this->model->buscarRepresentantes($query);
    
    echo json_encode($representantes);
  }
}

public function guardar()
{
  
  if(isset($_POST['nombre_alumno'], $_POST['apellido_alumno'], $_POST['fecha_nacimiento'], $_POST['direccion'], $_POST['talla'], $_POST['peso'], $_POST['altura'], $_POST['estado'], $_POST['representante'], $_POST['grado'])) {
    
    $nombre = $_POST['nombre_alumno'];
    $apellido = $_POST['apellido_alumno'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $talla = $_POST['talla'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $estado = $_POST['estado'];
    $idRepresentante = $_POST['representante'];
    $idGrado = $_POST['grado'];
    $idd= $_POST["id_datos"];
   
    $idEstudiante = isset($_POST['id_estudiante']) ? $_POST['id_estudiante'] : null;
    
   
    if (empty($nombre) || empty($apellido) || empty($fechaNacimiento) || empty($direccion) || empty($talla) || empty($peso) || empty($altura) || empty($estado) || empty($idRepresentante) || empty($idGrado)) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {
      if ($idEstudiante) {
        $idDatos = $this->model->modificarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion, $idd);

        if ($idDatos > 0) {
            $data = $this->model->modificarEstudiante($talla, $peso, $altura, $estado, $idRepresentante, $idGrado, $idEstudiante);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Estudiante actualizado con éxito');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el estudiante');
            }
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar los datos personales del estudiante');
        }
      } else {
        $idDatosA = $this->model->registrarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion);
        if ($idDatosA > 0) {
          $data = $this->model->registrarEstudiante($talla, $peso, $altura, $estado, $idRepresentante, $idGrado, $idDatosA);
          if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Estudiante registrado con éxito');
          } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el estudiante');
          }
        } else {
          $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar los datos personales del estudiante');
        }
      }
    }
  } else {
    $res = array('tipo' => 'error', 'mensaje' => 'No se recibieron todos los datos del formulario');
  }
  
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
  die();
}


  public function eliminar($id)
  {
    $data2 = $this->model->eliminarEstudiante($id);
    $data = $this->model->eliminarDatosPersonales($id);
    if ($data == 1 && $data2 ==1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Estudiante eliminado con éxito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar el estudiante');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getEstudiante($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  
}
