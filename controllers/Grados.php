<?php

class Grados extends Controller
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
    $data['script'] = 'grados.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getGrados();
    
    for ($i = 0; $i < count($data); $i++) {
        $data[$i]['acciones'] = '<div">
            <button title="Editar grado" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button title="Eliminar grado" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
          <div/>';

    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }


public function guardar()
{
  
  if(isset($_POST['grado'], $_POST['seccion'], $_POST['descripcion'], $_POST['duracion'] )) {
    
    $grado = $_POST['grado'];
    $seccion = $_POST['seccion'];
    $descripcion = $_POST['descripcion'];
    $duracion = $_POST['duracion'];
   
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
   
    if (empty($grado) || empty($seccion) || empty($descripcion) || empty($duracion) ) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {
      if ($id) {
         $data=$this->model->modificarGrados($grado, $seccion, $descripcion, $duracion, $id);
         if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Grado actualizado con éxito');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el grado');
        }
    } else {
        $data2= $this->model->registrarGrados($grado, $seccion, $descripcion, $duracion);
        if ($data2 > 0) {
          
          $res = array('tipo' => 'success', 'mensaje' => 'Grado registrado con éxito');
        } else {
          $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el grado');
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
    $data = $this->model->eliminarGrados($id);
    if ($data == 1 ) {
      $res = array('tipo' => 'success', 'mensaje' => 'Grado eliminado con éxito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar el grado');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getGrado($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  
}
