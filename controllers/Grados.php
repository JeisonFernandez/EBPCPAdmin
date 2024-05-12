<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Grados extends Controller
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
    $data['title'] = "Grados";
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

    if (isset($_POST['grado'], $_POST['seccion'], $_POST['descripcion'], $_POST['duracion'])) {

      $grado = $_POST['grado'];
      $seccion = $_POST['seccion'];
      $descripcion = $_POST['descripcion'];
      $duracion = $_POST['duracion'];

      $id = isset($_POST['id']) ? $_POST['id'] : null;


      if (empty($grado) || empty($seccion) || empty($descripcion) || empty($duracion)) {
        $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
      } else {
        if ($id) {
          $data = $this->model->modificarGrados($grado, $seccion, $descripcion, $duracion, $id);
          if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Grado actualizado con éxito');
          } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el grado');
          }
        } else {
          $data2 = $this->model->registrarGrados($grado, $seccion, $descripcion, $duracion);
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

  public function comprobarEliminar($id)
  {
    $data = $this->model->comprobarE($id);

    if ($data > 0) {
      $res = array("tipo" => "warning", "mensaje" => "Representante no eliminable");
    } else {
      $res = array("tipo" => "success", "mensaje" => "Representante eliminable");
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }


  public function eliminar($id)
  {
    $data = $this->model->eliminarGrados($id);
    if ($data == 1) {
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

  public function generarPdf()
  {

    // CARGAR DATOS DE LA BD A DOMPDF
    $data = $this->model->getGrados();

    $rows = '';
    foreach ($data as $datos) {
      $rows .= '
        <tr>
          <td>' . $datos['id'] . '</td>
          <td>' . $datos['grado_descr'] . '</td>
          <td>' . $datos['descripcion'] . '</td>
          <td>' . $datos['duracion'] . '</td>
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
        <title>Reporte de Grados</title>
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
        <img class="logo" src="' . $base64 . '" alt="Insignia EBPCP">
        <h1 class="titulo">Reporte de Grados</h1>
        <!-- <h2 class="subTitulo">Reporte clasicon</h2> -->

        <table>
            <tr class="t-head">
                <th>Id</th>
                <th>Grado</th>
                <th>Descripción</th>
                <th>Duración</th>
            </tr>
            ' . $rows . '
        </table>
    </body>
    </html>
    ';

    $dompdf->loadHtml($html);

    // Renderiza el PDF
    $dompdf->render();

    // Muestra el PDF en una nueva página
    $dompdf->stream('reporte-grados.pdf', ['Attachment' => false]);
  }

}
