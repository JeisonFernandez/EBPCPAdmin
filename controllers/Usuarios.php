<?php

class Usuarios extends Controller
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
    $data['roles'] = $this->model->getRoles();
    $data['script'] = 'usuarios.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getUsuarios();
    for ($i = 0; $i < count($data); $i++) {

      if ($data[$i]['estado'] == 1) {
        if ($data[$i]['id'] != 1) {
          $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
          $data[$i]['acciones'] = '<div">
            <button title="Editar usuario" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button title="Eliminar usuario" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
          <div/>';
        } else {
          $data[$i]['estado'] = '<div><span class="badge badge-success">Activo</span></div>';
          $data[$i]['acciones'] = '<div class"text-center">
            <span class="badge badge-primary p-1 rounded">Super Administrador</span>
            </div>';
        }
      } else {
        $data[$i]['estado'] = '<div><span class="badge badge-danger">Inactivo</span></div>';
        $data[$i]['acciones'] = '<div">
            <button title="Reingresar usuario" class="btn btn-success btn-sm" onclick="reingresar(' . $data[$i]['id'] . ')"><i class="fas fa-reply-all"></i></button>
          <div/>';
      }
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function guardar()
  {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $id_usuario = $_POST['id_usuario'];

    if (empty($usuario) || empty($correo) || empty($clave) || empty($rol)) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {

      if ($id_usuario == '') {
        ### Comprobar si ya existe el usuario ###
        $verificarUsuario = $this->model->getVerificar('usuario', $usuario, 0);

        if (empty($verificarUsuario)) {
          ### Comprobar si ya existe el correo ###
          $verificarCorreo = $this->model->getVerificar('correo', $correo, 0);

          if (empty($verificarCorreo)) {
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            $data = $this->model->registrar($usuario, $correo, $hash, $rol);
            if ($data > 0) {
              $res = array('tipo' => 'success', 'mensaje' => 'Usuario registrado con exito');
            } else {
              $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar');
            }
          } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
          }
        } else {
          $res = array('tipo' => 'warning', 'mensaje' => 'El usuario ya existe');
        }
      } else {
        ### Comprobar si ya existe el usuario ###
        $verificarUsuario = $this->model->getVerificar('usuario', $usuario, $id_usuario);

        if (empty($verificarUsuario)) {
          ### Comprobar si ya existe el correo ###
          $verificarCorreo = $this->model->getVerificar('correo', $correo, $id_usuario);

          if (empty($verificarCorreo)) {
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            $data = $this->model->modificar($usuario, $correo, $rol, $id_usuario);
            if ($data == 1) {
              $res = array('tipo' => 'success', 'mensaje' => 'Usuario modificado con exito');
            } else {
              $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar');
            }
          } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
          }
        } else {
          $res = array('tipo' => 'warning', 'mensaje' => 'El usuario ya existe');
        }
      }
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function eliminar($id)
  {
    $data = $this->model->delete($id);
    if ($data == 1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Usuario desactivado con exito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getUsuario($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function reingresar($id)
  {
    $data = $this->model->accionUser(1, $id);

    if ($data == 1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Usuario restaurado con exito');
    } else {
      $res = array('tipo' => 'error', 'mensaje' => 'Error al restaurar');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}
