<?php

class Home extends Controller
{

  public function __construct()
  {
    session_start();
    if (isset($_SESSION['usuario'])) {
      header('Location: Principal');
      die();
  }
    parent::__construct();
  }

  public function index()
  {
    $data['title'] = 'Iniciar Sesión';
    $this->views->getView($this, "index", $data);
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
}
