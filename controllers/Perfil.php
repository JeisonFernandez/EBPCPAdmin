<?php

class Perfil extends Controller
{
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION["usuario"])) {
      header('Location: ' . BASE_URL);
      die();
    }
    parent::__construct();
  }

  public function index()
  {
    $data['usuario'] = $_SESSION['usuario'];
    $data['id_usuario'] = $_SESSION['id_usuario'];
    $data['script'] = 'perfil.js';
    $this->views->getView($this, "index", $data);
  }

  public function actualizar()
  {
    $claveActual = $_POST['clave'];
    $claveNew = $_POST['claveNew'];
    $idUser = $_POST['idUser'];

    if (empty($claveActual) || empty($claveNew)) {
      $res = array('tipo'=> 'warning', 'mensaje'=> 'Todos los campos son obligatorios.');
    }else {
      $verificarClave = $this->model->verificar($claveActual, $idUser);

      if ($verificarClave) {
        $data = $this->model->changePass($claveNew, $idUser);
        
        if ($data == 1) {
          $res = array('tipo'=> 'success', 'mensaje'=> 'Contraseña modificada correctamente.');
        }else {
          $res = array('tipo'=> 'error', 'mensaje'=> 'Error al modificar contraseña.');
        }
      }else {
        $res = array('tipo'=> 'warning', 'mensaje'=> 'Contraseña incorrecta.');
      }
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}