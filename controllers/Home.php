<?php

class Home extends Controller
{

  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $this->views->getView($this, "index");
  }

  ### LOGIN ###
  public function validar()
  {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $data = $this->model->getUsuario($usuario);
    if (!empty($data)) {
      if (password_verify($clave, $data['clave'])) {
        $_SESSION['id_usuario'] = $data['id'];
        $_SESSION['usuario'] = $data['usuario'];

        $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido al sistema de administración EBCP Admin');
      } else {
        $res = array('tipo' => 'warning', 'mensaje' => 'Contraseña incorrecta');
      }
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'El usuario no existe');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function salir()
  {
    session_destroy();
    header('Location: ' . BASE_URL);
    die();
  }
}
