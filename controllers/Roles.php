<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Roles extends Controller
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
    $data['title'] = 'Roles';
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

  public function guardar()
  {
    $rol = $_POST['rol'];
    $id_rol = $_POST['id_rol'];

    if (empty($rol)) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Tienes que introducir un rol');
    } else {
      if ($id_rol == '') {
        $verificarRol = $this->model->getVerificar('rol', $rol, 0);


        if (empty($verificarRol)) {
          $data = $this->model->registrar($rol);

          if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Rol registrado con exito');
          } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar');
          }
        } else {
          $res = array('tipo' => 'warning', 'mensaje' => 'El rol ya existe');
        }
      } else {
        $verificarRol = $this->model->getVerificar('rol', $rol, $id_rol);


        if (empty($verificarRol)) {
          $data = $this->model->modificar($rol, $id_rol);

          if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Rol modificado con exito');
          } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar');
          }
        } else {
          $res = array('tipo' => 'warning', 'mensaje' => 'El rol ya existe');
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
      $res = array('tipo' => 'success', 'mensaje' => 'Rol desactivado con exito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al intertar eliminar');
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function reingresar($id)
  {
    $data = $this->model->reingresar($id);
    if ($data == 1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Rol reactivado con exito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al intertar reingresar el rol');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getRol($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  
  public function generarPdf()
  {

    // CARGAR DATOS DE LA BD A DOMPDF
    $data = $this->model->getRoles();
    for ($i=0; $i < count($data); $i++) { 
      if ($data[$i]['estado'] == 1) {
        $data[$i]['estado'] = 'Activo';
      }else {
        $data[$i]['estado'] = 'Inactivo';
      }
    }

    $rows = '';
    foreach($data as $datos){
      $rows .= '
        <tr>
          <td>' . $datos['id'] . '</td>
          <td>' . $datos['rol'] . '</td>
          <td>' . $datos['estado'] . '</td>
        </tr>
      ';
    }

    // Crea una instancia de Dompdf recordar usar el Use al principio
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);



    // PONER IMAGENES EN DOMPDF
    $rutaImagenLocal = 'assets/img/ing.jpg'; // Cambia esto a la ruta de tu imagen local
    // Lee el contenido de la imagen
    $contenidoImagen = file_get_contents($rutaImagenLocal);
    // Codifica la imagen en Base64
    $imagenBase64 = base64_encode($contenidoImagen);
    $base64 = "data:image/jpeg;base64,$imagenBase64";


    // Carga el contenido HTML (puedes usar una vista o generar HTML manualmente)
    $html = '
    <html>
    <head>
        <title>Reporte de Roles</title>
        <style>
            body {
              font-family: sans-serif;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            .logo {
              width: 100px;
              heigth: 100px;
            }

            .titulo {
              display: inline;
              margin-left: 110px;
              position: absolute;
              top: 0;
            }

            .subTitulo {
              /* display: inline; */
              text-align: center;
            }

            .t-head {
              background-color: #4e73df;
              color: #fff;
            }
        </style>
    </head>
    <body>
        <img class="logo" src="'.$base64.'" alt="Insignia EBPCP">
        <h1 class="titulo">Reporte de Roles</h1>
        <!-- <h2 class="subTitulo">Reporte clasicon</h2> -->

        <table>
            <tr class="t-head">
                <th>Id</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
            '.$rows.'
        </table>
    </body>
    </html>
    ';

    $dompdf->loadHtml($html);

    // Renderiza el PDF
    $dompdf->render();

    // Muestra el PDF en una nueva página
    $dompdf->stream('reporte-roles.pdf', ['Attachment' => false]);
  }
}
