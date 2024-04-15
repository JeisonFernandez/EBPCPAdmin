<?php

class Representantes extends Controller
{
  public function __construct()
  {
    session_start();
    if (!isset($_SESSION['usuario'])) {
      header('Location: ' . BASE_URL);
      die();
    }
    parent::__construct();
  }

  public function index()
  {
    $data['usuario'] = $_SESSION['usuario'];
    $data['script'] = "representantes.js";
    $this->views->getView($this, 'index', $data);
  }

  public function listar()
  {
    $data = $this->model->getRepresentantes();
    for ($i = 0; $i < count($data); $i++) {
      $data[$i]['acciones'] = '<div">
            <button title="Editar usuario" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button title="Eliminar usuario" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
          <div/>';

      $data[$i]['nombre_completo'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function guardar()
  {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha = $_POST['fecha'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $relacion = $_POST['relacion'];
    $idRepre = $_POST['idRepre'];
    $idDatos = $_POST['idDatos'];

    if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha) || empty($direccion) || empty($telefono) || empty($relacion)) {
      $res = array("tipo" => "warning", "mensaje" => "Todos los campos son obligatorios");
    } else {
      if ($idRepre == "") {
        $verificarCedula = $this->model->getVerificar("cedula", $cedula, 0);

        if (empty($verificarCedula)) {
          $idDatosR = $this->model->registrarDatosPersonales($nombre, $apellido, $fecha, $direccion);

          $data = $this->model->registrarRepresentantes($cedula, $telefono, $relacion, $idDatosR);

          if ($data > 0) {
            $res = array("tipo" => "success", "mensaje" => "Representante registrado con exito");
          } else {
            $res = array("tipo" => "error", "mensaje" => "Error al registrar representante");
          }
        } else {
          $res = array("tipo" => "warning", "mensaje" => "El representante ya existe");
        }
      } else {
        $verificarCedula = $this->model->getVerificar("cedula", $cedula, $idRepre);

        if (empty($verificarCedula)) {
          $datos = $this->model->modificarDatosPersonales($nombre, $apellido, $fecha, $direccion, $idDatos);

          if ($datos == 1) {
            $data = $this->model->modificarRepresentantes($cedula, $telefono, $relacion, $idDatos, $idRepre);

            if ($data == 1) {
              $res = array("tipo" => "success", "mensaje" => "Representante modificado con exito");
            } else {
              $res = array("tipo" => "error", "mensaje" => "Error al modificar representante");
            }
          } else {
            $res = array("tipo" => "error", "mensaje" => "Error al modificar representante");
          }

        } else {
          $res = array("tipo" => "warning", "mensaje" => "El representante ya existe");
        }
      }

    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getRepresentante($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function comprobarEliminar($id)
  {
    $data = $this->model->comprobarE($id);

    if ($data > 0) {
      $res = array("tipo" => "warning", "mensaje" => "Representante eliminable");
    } else {
      $res = array("tipo" => "success", "mensaje" => "Representante eliminable");
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function eliminar($id)
  {
    $data = $this->model->delete($id);
    if ($data == 1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Representante eliminado con exito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }
}