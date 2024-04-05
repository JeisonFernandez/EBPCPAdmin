<?php

class Roles extends Controller
{
  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $data['usuario'] = $_SESSION['usuario'];
    $data['script'] = 'roles.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getRoles();

    for ($i = 0; $i < count($data); $i++) {
      if ($data[$i]['estado'] == 1) {
        $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
        $data[$i]['acciones'] = '<div">
          <button title="Editar Rol" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
          <button title="Eliminar Rol" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
        <div/>';
      } else {
        $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
        $data[$i]['acciones'] = '<div">
            <button title="Reactivar Rol" class="btn btn-success btn-sm" onclick="reingresar(' . $data[$i]['id'] . ')"><i class="fas fa-reply-all"></i></button>
          <div/>';
      }
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function guardar(){
    $rol = $_POST['rol'];

    if (empty($rol)) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Tienes que introducir un rol');
    }else {
      $verificarRol = $this->model->getVerificar('rol', $rol);

      if (empty($verificarRol)) {
        $data = $this->model->registrar($rol);
  
        if($data > 0){
          $res = array('tipo' => 'success', 'mensaje' => 'Rol registrado con exito');
        }else {
          $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar');
        }
      }else {
        $res = array('tipo' => 'warning', 'mensaje' => 'El rol ya existe');
      }
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}
