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
  const buttons = [
    {
      //Botón para Excel
      extend: "excel",
      footer: true,
      title: "Archivo",
      filename: "Export_File",

      //Aquí es donde generas el botón personalizado
      text: '<button class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>',
    },
    //Botón para PDF
    {
      extend: "pdf",
      footer: true,
      title: "Archivo PDF",
      filename: "reporte",
      text: '<button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></button>',
    },
    //Botón para print
    {
      extend: "print",
      footer: true,
      title: "Reportes",
      filename: "Export_File_print",
      text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>',
    },
  ];

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
  var opcionInactiva = Array.from(frmUsuario.rol.options).find(option => option.text === "Rol Inactivo");

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
