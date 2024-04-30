<?php

class Historico extends Controller
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
    $data['historico'] = $this->model->getHistorico();
    $data['script'] = 'historico.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getHistorico();
    
    for ($i = 0; $i < count($data); $i++) {
        $data[$i]['acciones'] = '<div">
            <button title="Editar historico" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button title="Eliminar historico" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
          <div/>';

    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }


  
  public function guardar()
  {
      if(isset($_POST['id_alumno'],$_POST['fecha_inicio'],$_POST['fecha_fin'],$_POST['estado_anterior'],$_POST['estado_nuevo'])) {
          $fecha_inicio = $_POST['fecha_inicio'];
          $fecha_fin = $_POST['fecha_fin'];
          $estado_anterior= $_POST["estado_anterior"];
          $estado_nuevo= $_POST["estado_nuevo"];
          $id = isset($_POST['id']) ? $_POST['id'] : null;
          $id_alumno =   $_POST['id_alumno'];
          
          if ($id) {
              $data = $this->model->modificarHistorico($id_alumno,$fecha_inicio, $fecha_fin,$estado_anterior,$estado_nuevo, $id);
              if ($data > 0) {
                  $data = $this->model->modificarEstudiante($estado_nuevo,$id_alumno);
                  if ($data > 0) {
                      $res = array('tipo' => 'success', 'mensaje' => 'El Historico se actualizo con éxito');
                  } else {
                      $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el estado del estudiante');
                  }
              } else {
                  $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el Historico');
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
    $data = $this->model->eliminarHistorico($id);
    if ($data == 1 ) {
      $res = array('tipo' => 'success', 'mensaje' => 'Historico eliminado con éxito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar el Historico');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getHistory($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  
}
