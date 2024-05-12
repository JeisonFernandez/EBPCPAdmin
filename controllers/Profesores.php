<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Profesores extends Controller
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
    $data['grados'] = $this->model->getGrados();
    $data['script'] = 'profesores.js';
    $data["title"] = "Profesores";
    $this->views->getView($this, "index", $data);
  }

  public function listar()
  {
    $data = $this->model->getProfesores();
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
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $grado = $_POST['grado'];
    $idProfe = $_POST['idProfe'];
    $idDatos = $_POST['idDatos'];

    if (empty($cedula) || empty($nombre) || empty($apellido) || empty($correo) || empty($fecha) || empty($direccion) || empty($telefono)) {
      $res = array("tipo" => "warning", "mensaje" => "Todos los campos son obligatorios");
    } else {
      if ($idProfe == "") {
        $verificarCedula = $this->model->getVerificar("cedula", $cedula, 0);

        if (empty($verificarCedula)) {
          $idDatosP = $this->model->registrarDatosPersonales($nombre, $apellido, $fecha, $direccion);

          $data = $this->model->registrarProfesores($cedula, $telefono, $correo, $grado, $idDatosP);

          if ($data > 0) {
            $res = array("tipo" => "success", "mensaje" => "Profesor registrado con exito");
          } else {
            $res = array("tipo" => "error", "mensaje" => "Error al registrar profesor");
          }
        } else {
          $res = array("tipo" => "warning", "mensaje" => "El profesor ya existe");
        }
      } else {
        $verificarCedula = $this->model->getVerificar("cedula", $cedula, $idProfe);

        if (empty($verificarCedula)) {
          $datos = $this->model->modificarDatosPersonales($nombre, $apellido, $fecha, $direccion, $idDatos);

          if ($datos == 1) {
            $data = $this->model->modificarProfesores($cedula, $telefono, $correo, $grado, $idDatos, $idProfe);

            if ($data == 1) {
              $res = array("tipo" => "success", "mensaje" => "Profesor modificado con exito");
            } else {
              $res = array("tipo" => "error", "mensaje" => "Error al modificar un profesor");
            }
          } else {
            $res = array("tipo" => "error", "mensaje" => "Error al modificar un profesor");
          }

        } else {
          $res = array("tipo" => "warning", "mensaje" => "El profesor ya existe");
        }
      }

    }

    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
  }


  public function editar($id)
  {
    $data = $this->model->getProfesor($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function generarPdf()
  {

    // CARGAR DATOS DE LA BD A DOMPDF
    $data = $this->model->getProfesores();

    $rows = '';
    foreach($data as $datos){
      $rows .= '
        <tr>
          <td>' . $datos['id'] . '</td>
          <td>' . $datos['cedula'] . '</td>
          <td>' . $datos['nombre'] . '</td>
          <td>' . $datos['apellido'] . '</td>
          <td>' . $datos['fecha_nac'] . '</td>
          <td>' . $datos['telefono'] . '</td>
          <td>' . $datos['correo'] . '</td>
          <td>' . $datos['direccion'] . '</td>
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
        <h1 class="titulo">Reporte de Profesores</h1>

        <!-- <h2 class="subTitulo">Reporte clasicon</h2> -->

        <table>
            <tr class="t-head">
                <th>ID</th>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Dirección</th>
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
    $dompdf->stream('reporte-profesores.pdf', ['Attachment' => false]);
  }

}