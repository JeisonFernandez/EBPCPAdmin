<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Estudiantes extends Controller
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
    $data['title'] = 'Estudiantes';
    $data['usuario'] = $_SESSION['usuario'];
    $data['grados'] = $this->model->getGrados();
    $data['representantes'] = $this->model->getRepresentantes();
    $data['script'] = 'estudiantes.js';
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getEstudiantes();
    
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['estado'] == 'cursando') {
            $data[$i]['estado'] = '<span class="badge badge-success">Cursando</span>';
            $data[$i]['acciones'] = '<button title="Editar Estudiante" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
                                     <button title="Eliminar Estudiante" class="btn btn-danger btn-sm" onclick="eliminar('  . $data[$i]['id_datosA'] .')"><i class="fas fa-trash-alt"></i></button>';
        } else {
            $data[$i]['estado'] = '<span class="badge badge-danger">No cursando</span>';
            $data[$i]['acciones'] = '<button title="Editar Estudiante" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
                                     <button title="Eliminar Estudiante" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id_datosA'] . ')"><i class="fas fa-trash-alt"></i></button>';
        }
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function buscarRepresentantes()
{
  if(isset($_POST['query'])){
    $query = $_POST['query']; 
    $representantes = $this->model->buscarRepresentantes($query);
    
    echo json_encode($representantes);
  }
}

public function guardar()
{
  
  if(isset($_POST['nombre_alumno'], $_POST['apellido_alumno'], $_POST['fecha_nacimiento'], $_POST['direccion'], $_POST['talla'], $_POST['peso'], $_POST['altura'], $_POST['estado'], $_POST['representante'], $_POST['grado'])) {
    
    $nombre = $_POST['nombre_alumno'];
    $apellido = $_POST['apellido_alumno'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $talla = $_POST['talla'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $estado = $_POST['estado'];
    $idRepresentante = $_POST['representante'];
    $idGrado = $_POST['grado'];
    $idd= $_POST["id_datos"];
   
    $idEstudiante = isset($_POST['id_estudiante']) ? $_POST['id_estudiante'] : null;
    $fechaInicio = date('Y-m-d H:i:s');
    $estadoAnterior = ''; 
    $estadoNuevo = $estado;
   
    if (empty($nombre) || empty($apellido) || empty($fechaNacimiento) || empty($direccion) || empty($talla) || empty($peso) || empty($altura) || empty($estado) || empty($idRepresentante) || empty($idGrado)) {
      $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
    } else {
      if ($idEstudiante) {
        $idDatos = $this->model->modificarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion, $idd);

        if ($idDatos > 0) {
            $data = $this->model->modificarEstudiante($talla, $peso, $altura, $estado, $idRepresentante, $idGrado, $idEstudiante);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Estudiante actualizado con éxito');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar el estudiante');
            }
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al actualizar los datos personales del estudiante');
        }
      } else {
        $idDatosA = $this->model->registrarDatosPersonales($nombre, $apellido, $fechaNacimiento, $direccion);
        if ($idDatosA > 0) {
          $data = $this->model->registrarEstudiante($talla, $peso, $altura, $estado, $idRepresentante, $idGrado, $idDatosA);
          $idAlumno = $data; 
          $this->model->agregarHistorico($idAlumno, $fechaInicio, $estadoAnterior, $estadoNuevo);
          if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Estudiante registrado con éxito');
          } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar el estudiante');
          }
        } else {
          $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar los datos personales del estudiante');
        }
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
    $data2 = $this->model->eliminarEstudiante($id);
    $data = $this->model->eliminarDatosPersonales($id);
    if ($data == 1 && $data2 ==1) {
      $res = array('tipo' => 'success', 'mensaje' => 'Estudiante eliminado con éxito');
    } else {
      $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar el estudiante');
    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function editar($id)
  {
    $data = $this->model->getEstudiante($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function generarPdf()
  {

    // CARGAR DATOS DE LA BD A DOMPDF
    $data = $this->model->getEstudiantes();

    $rows = '';
    foreach($data as $datos){
      $rows .= '
        <tr>
          <td>' . $datos['id'] . '</td>
          <td>' . $datos['nombre_completo'] . '</td>
          <td>' . $datos['nombre_grado'] . '</td>
          <td>' . $datos['fecha_nacimiento_alumno'] . '</td>
          <td>' . $datos['direccion_alumno'] . '</td>
          <td>' . $datos['talla'] . '</td>
          <td>' . $datos['peso'] . '</td>
          <td>' . $datos['altura'] . '</td>
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
        <title>Reporte de Estudiantes</title>
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
        <h1 class="titulo">Reporte de Estudiantes</h1>
        <!-- <h2 class="subTitulo">Reporte clasicon</h2> -->

        <table>
            <tr class="t-head">
                <th>Id</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Talla</th>
                <th>Peso</th>
                <th>Altura</th>
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
    $dompdf->stream('reporte-estudiantes.pdf', ['Attachment' => false]);
  }
  
}
