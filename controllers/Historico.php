<?php
use Dompdf\Dompdf;
use Dompdf\Options;

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
    $data['title'] = 'Historio';
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

  public function generarPdf()
  {

    // CARGAR DATOS DE LA BD A DOMPDF
    $data = $this->model->getHistorico();

    $rows = '';
    foreach($data as $datos){
      $rows .= '
        <tr>

          <td>' . $datos['nombre_completo'] . '</td>
          <td>' . $datos['fecha_inicio'] . '</td>
          <td>' . $datos['fecha_fin'] . '</td>
          <td>' . $datos['estado_anterior'] . '</td>
          <td>' . $datos['estado_nuevo'] . '</td>
        </tr>
      ';
    }

    // Crea una instancia de Dompdf
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
        <title>Reporte de Profesores</title>
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
                text-align: center;
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
        <h1 class="titulo">Reporte de Historico</h1>

        <!-- <h2 class="subTitulo">Reporte clasicon</h2> -->

        <table>
            <tr class="t-head">
                <th>Estudiante</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado Anterior</th>
                <th>Estado Nuevo</th>
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
    $dompdf->stream('reporte-historico.pdf', ['Attachment' => false]);
  }
  
}
