const btnNewUser = document.getElementById("btnNewUser");
const modalRegistro = document.getElementById("modalRegistro");
const frmUsuario = document.getElementById("frmUsuario");
const title = document.getElementById("title");

let tblUsuarios;

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

  // BOTONES OFFICE DATATABLE
  /* const buttons = [
    {
      // Botón para Excel
      extend: "excel",
      footer: true,
      title: "Archivo",
      filename: "Export_File",
      text: '<button class="btn btn-success"><i class="fas fa-file-excel"></i></button>',
    },
    // Botón para PDF
    {
      extend: "pdfHtml5",
      title: "Reporte de Datos",
      pageSize: "A4",
      download: "open",
      text: '<button class="btn btn-danger"><i class="fas fa-file-pdf"></i></button>',
      exportOptions: {
        search: "applied",
        order: "applied",
        stripNewlines: false,
      },
      customize: function (doc) {
        var rdoc = doc;
        var rcout = doc.content[doc.content.length - 1].table.body.length - 1;
        doc.content.splice(0, 1);
        var ahora = new Date();
        var fechaActual =
          ahora.getDate() +
          "/" +
          (ahora.getMonth() + 1) +
          "/" +
          ahora.getFullYear() +
          "  y Hora:" +
          ahora.getHours() +
          ":" +
          ahora.getMinutes() +
          ":" +
          ahora.getSeconds();
        doc.pageMargins = [30, 70, 30, 30];
        doc.defaultStyle.fontSize = 12;
        doc.styles.tableHeader.fontSize = 12;
        doc.content[doc.content.length - 1].table.headerRows = 2;
        doc.content[doc.content.length - 1].table.body[0].splice(-1, 1); // Eliminar columna "Acciones"
        var iPlus;
        for (var i = 0; i < rcout; i++) {
          iPlus = i + 1;
          var obj = doc.content[doc.content.length - 1].table.body[i + 1];
          doc.content[doc.content.length - 1].table.body[i + 1][2] = {
            text: obj[2].text,
            style: [obj[2].style],
            alignment: "center",
            bold: obj[2].text > 60 ? true : false,
            fillColor: obj[2].text > 60 ? "red" : null,
          };
          doc.content[doc.content.length - 1].table.body[iPlus].splice(-1, 1); // Eliminar columna "Acciones"
        }

        doc["header"] = function (page, pages) {
          return {
            table: {
              widths: ["100%"],
              headerRows: 0,
              body: [
                [
                  {
                    text: "Título Principal de Ejemplo",
                    alignment: "center",
                    fontSize: 14,
                    bold: true,
                    margin: [0, 10, 0, 0],
                  },
                ],
                [
                  {
                    text: [
                      { text: "Subtítulo1: ", bold: true },
                      "Detalles del subtítulo...1\n",
                      { text: "Subtítulo2: ", bold: true },
                      "Detalles del subtítulo...2",
                    ],
                  },
                ],
              ],
            },
            layout: "noBorders",
            margin: 10,
          };
        };

        doc["footer"] = function (page, pages) {
          return {
            columns: [
              {
                alignment: "left",
                text: ["Fecha de Creación: ", { text: fechaActual.toString() }],
              },
              {
                alignment: "center",
                text: "Total de filas: " + rcout.toString(),
              },
              {
                alignment: "right",
                text: [
                  "página ",
                  { text: page.toString() },
                  " de ",
                  { text: pages.toString() },
                ],
              },
            ],
            margin: 10,
          };
        };

        var objLayout = {};
        objLayout["hLineWidth"] = function (i) {
          return 0.8;
        };
        objLayout["vLineWidth"] = function (i) {
          return 0.5;
        };
        objLayout["hLineColor"] = function (i) {
          return "#aaa";
        };
        objLayout["vLineColor"] = function (i) {
          return "#aaa";
        };
        objLayout["paddingLeft"] = function (i) {
          return 5;
        };
        objLayout["paddingRight"] = function (i) {
          return 35;
        };
        doc.content[doc.content.length - 1].layout = objLayout;
      },
    },
    // Botón para imprimir
    {
      extend: "print",
      footer: true,
      title: "Reportes",
      filename: "Export_File_print",
      text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>',
    },
  ]; */

  // CARGAR DATOS CON DATATABLE
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "usuario" },
      { data: "correo" },
      { data: "rol" },
      { data: "estado" },
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "desc"]],
    bDestroy: true,
    iDisplayLength: 10,
    /* dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons, */
  });

  // ABRIR MODAL REGISTRAR USUARIO
  btnNewUser.addEventListener("click", (e) => {
    e.preventDefault();

    frmUsuario.clave.removeAttribute("readonly");
    frmUsuario.confirmar.removeAttribute("readonly");
    frmUsuario.id_usuario.value = "";
    frmUsuario.reset();
    manejarOpcionInactiva(false);
    bloquearEntrada(frmUsuario);

    title.textContent = "Nuevo Usuario";
    $("#modalRegistro").modal("show");
  });

  // REGISTRAR USUARIO POR AJAX
  frmUsuario.addEventListener("submit", function (e) {
    e.preventDefault();

    if (
      frmUsuario.usuario.value == "" ||
      frmUsuario.correo.value == "" ||
      frmUsuario.clave.value == "" ||
      frmUsuario.rol.value == ""
    ) {
      alertaPersonalizada("warning", "Todos los campos son requeridos");
    } else if (frmUsuario.clave.value != frmUsuario.confirmar.value) {
      alertaPersonalizada("warning", "Las contraseñas no coinciden");
    } else {
      const data = new FormData(frmUsuario);
      const http = new XMLHttpRequest();
      const url = base_url + "Usuarios/guardar";

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);

          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            frmUsuario.reset();
            $("#modalRegistro").modal("hide");
            tblUsuarios.ajax.reload();
          }
        }
      };
    }
  });
});

function eliminar(id) {
  const url = base_url + "Usuarios/eliminar/" + id;
  eliminarRegistro(
    "¿Estas seguro de eliminar?",
    "El usuario no se eliminará de forma permanente, pasara a un estado inactivo.",
    "Si, Eliminar",
    url,
    tblUsuarios
  );
}

function reingresar(id) {
  const url = base_url + "Usuarios/reingresar/" + id;
  reingresarRegistro(
    "¿Estas seguro de reingresar?",
    "El usuario pasara a ser incorporado nuevamente.",
    "Si, Reingresar",
    url,
    tblUsuarios
  );
}

function editar(id) {
  const http = new XMLHttpRequest();

  const url = base_url + "Usuarios/editar/" + id;

  http.open("GET", url, true);

  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      frmUsuario.id_usuario.value = res.id;
      frmUsuario.usuario.value = res.usuario;
      frmUsuario.correo.value = res.correo;
      frmUsuario.clave.value = "*******";
      frmUsuario.confirmar.value = "*******";
      frmUsuario.clave.setAttribute("readonly", "readonly");
      frmUsuario.confirmar.setAttribute("readonly", "readonly");

      if (res.id_rol == 0) {
        manejarOpcionInactiva(true);
      } else {
        manejarOpcionInactiva(false);
        frmUsuario.rol.value = res.id_rol;
      }

      bloquearEntrada(frmUsuario);
      title.textContent = "Editar Usuario";
      $("#modalRegistro").modal("show");
    }
  };
}

// Función para manejar la opción "Rol Inactivo"
function manejarOpcionInactiva(agregar) {
  // Buscar si la opción "Rol Inactivo" ya existe
  var opcionInactiva = Array.from(frmUsuario.rol.options).find(
    (option) => option.text === "Rol Inactivo"
  );

  if (agregar) {
    // Si se debe agregar y no existe, crear y agregar la opción
    if (!opcionInactiva) {
      var option = document.createElement("option");
      option.text = "Rol Inactivo";
      option.disabled = true;
      option.selected = true;
      frmUsuario.rol.appendChild(option);
    }
  } else {
    // Si no se debe agregar, eliminar la opción si existe
    if (opcionInactiva) {
      frmUsuario.rol.removeChild(opcionInactiva);
    }
  }
}
