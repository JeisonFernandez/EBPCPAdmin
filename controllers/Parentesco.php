<?php

class Parentesco extends Controller
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
    $data['title'] = "Parentesco Alumno";
    $data['usuario'] = $_SESSION['usuario'];
    $data['parentesco'] = $this->model->getParentesco();
    $data['script'] = 'parentesco.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getParentesco();
    
    for ($i = 0; $i < count($data); $i++) {
        $data[$i]['acciones'] = '<div">
            <button title="Editar parentesco" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button title="Eliminar parentesco" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
          <div/>';

    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }


public function guardar()
{
  
  if(isset($_POST['relacion'])) {
    $relacion = $_POST['relacion'];
    
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
   
    if ( empty($relacion) ) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {
      if ($id) {
         $data=$this->model->modificarParentesco( $relacion, $id);
         if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'EL parentesco fue actualizado con éxito');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el parentesco');
        }
    } else {
        $data2= $this->model->registrarParentesco( $relacion,);
        if ($data2 > 0) {
          
          $res = array('tipo' => 'success', 'mensaje' => 'Parentesco registrado con éxito');
        } else {
          $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el Parentesco');
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
    $data = $this->model->eliminarParentesco($id);
    if ($data == 1 ) {
      $res = array('tipo' => 'success', 'mensaje' => 'Parentesco eliminado con éxito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar el Parentesco');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getParent($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  
}
