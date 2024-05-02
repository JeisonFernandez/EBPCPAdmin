const btnNewEstudiante = document.getElementById("btnNewEstudiante");
const modalRegistroEstudiante = document.getElementById(
  "modalRegistroEstudiante"
);
const frmEstudiante = document.getElementById("frmEstudiante");
const titleEstudiante = document.getElementById("titleEstudiante");
const modalFunciones = document.getElementById("modalFunciones");

let tblEstudiantes;

document.addEventListener("DOMContentLoaded", function () {
  // TRADUCCIÓN DEL DATATABLE
  const language = {
    decimal: "",
    emptyTable: "No hay información",
    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
    infoFiltered: "(Filtrado de _MAX_ total entradas)",
    infoPostFix: "",
    thousands: ",",
    lengthMenu: "Mostrar _MENU_ Entradas",
    loadingRecords: "Cargando...",
    processing: "Procesando...",
    search: "Buscar:",
    zeroRecords: "Sin resultados encontrados",
  };

  // CARGAR DATOS CON DATATABLE
  tblEstudiantes = $("#tblEstudiantes").DataTable({
    ajax: {
      url: base_url + "Estudiantes/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre_completo" },
      //{ data: "apellido_alumno" },
      { data: "nombre_grado" },
      { data: "fecha_nacimiento_alumno" },
      { data: "direccion_alumno" },
      { data: "talla" },
      { data: "peso" },
      { data: "altura" },
      { data: "estado" },
      { data: "representante_info" },
      //{ data: "id_datosA" },
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "desc"]],
  });

  btnNewEstudiante.addEventListener("click", (e) => {
    e.preventDefault();

    frmEstudiante.reset();
    bloquearEntrada(frmEstudiante);

    titleEstudiante.textContent = "Nuevo Estudiante";
    $("#modalRegistroEstudiante").modal("show");
  });

  frmEstudiante.addEventListener("submit", function (e) {
    e.preventDefault();
    bloquearEntrada(frmEstudiante);

    if (
      frmEstudiante.nombre_alumno.value == "" ||
      frmEstudiante.apellido_alumno.value == "" ||
      frmEstudiante.fecha_nacimiento.value == "" ||
      frmEstudiante.direccion.value == "" ||
      frmEstudiante.talla.value == "" ||
      frmEstudiante.peso.value == "" ||
      frmEstudiante.altura.value == "" ||
      frmEstudiante.estado.value == "" ||
      frmEstudiante.representante.value == "" ||
      frmEstudiante.grado.value == ""
    ) {
      alertaPersonalizada("warning", "Todos los campos son obligatorios");
    } else {
      const data = new FormData(frmEstudiante);
      const http = new XMLHttpRequest();
      const url = base_url + "Estudiantes/guardar";

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);

          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            frmEstudiante.reset();
            $("#modalRegistroEstudiante").modal("hide");
            tblEstudiantes.ajax.reload();
          }
        }
      };
    }
  });
});

$(document).ready(function () {
  $("#representante").keyup(function () {
    var query = $(this).val();
    if (query !== "") {
      $.ajax({
        url: base_url + "Estudiantes/buscarRepresentantes",
        method: "POST",
        data: { query: query },
        dataType: "json",
        success: function (data) {
          console.log(data);
          $("#representanteLista").empty();
          $.each(data, function (key, value) {
            var representanteItem = $("<p>")
              .addClass("representante-item")
              .append(
                '<span class="id">' +
                  value.id +
                  "</span> " +
                  value.nombre +
                  " " +
                  value.apellido +
                  " C.I:" +
                  value.cedula
              )
              .hover(
                function () {
                  $(this).css("background-color", "#e2e8f0");
                },
                function () {
                  $(this).css("background-color", "transparent");
                }
              );
            $("#representanteLista").append(representanteItem);
          });
          $(".id").css("color", "white");
        },
      });
    }
  });

  $(document).on("click", ".representante-item", function () {
    var nombreCompleto = $(this).text();
    $("#representante").val(nombreCompleto);
    $("#representanteLista").empty();
  });
});

function eliminar(id) {
  const url = base_url + "Estudiantes/eliminar/" + id;
  eliminarRegistro(
    "¿Estas seguro de eliminar?",
    "El estudiante se eliminará de forma permanente.",
    "Si, Eliminar",
    url,
    tblEstudiantes
  );
}

function editar(id) {
  const http = new XMLHttpRequest();

  const url = base_url + "Estudiantes/editar/" + id;

  http.open("GET", url, true);

  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      frmEstudiante.id_estudiante.value = res.id;
      frmEstudiante.nombre_alumno.value = res.nombre_alumno;
      frmEstudiante.apellido_alumno.value = res.apellido_alumno;
      frmEstudiante.fecha_nacimiento.value = res.fecha_nacimiento_alumno;
      frmEstudiante.direccion.value = res.direccion_alumno;
      frmEstudiante.talla.value = res.talla;
      frmEstudiante.peso.value = res.peso;
      frmEstudiante.altura.value = res.altura;
      frmEstudiante.estado.value = res.estado;
      frmEstudiante.representante.value = res.representante_info;
      frmEstudiante.id_datos.value = res.id_datosA;
      const idGrado = res.id_grado;

      for (let i = 0; i < frmEstudiante.grado.options.length; i++) {
        if (frmEstudiante.grado.options[i].value === idGrado.toString()) {
          frmEstudiante.grado.options[i].selected = true;
          break;
        }
      }

      titleEstudiante.textContent = "Editar Estudiante";
      $("#modalRegistroEstudiante").modal("show");
      $("#representante").prop("readonly", true);

      $("#modalRegistroEstudiante").on("hidden.bs.modal", function () {
        $("#representante").prop("readonly", false);
      });
    }
  };
}

function funciones(id) {
  $("#modalFunciones").modal("show");
  const btnConstancia = document.getElementById("btnConstancia");

  
  btnConstancia.addEventListener("click", function (e) {
    
    btnConstancia.setAttribute('href', base_url + 'Estudiantes/pdfConstancia/' + id);

    $("#modalFunciones").modal("hide");
  });
}
