const btnNewProfe = document.getElementById("btnNewProfe");
const modalRegistro = document.getElementById("modalRegistro");
const frmProfesores = document.getElementById("frmProfesores");
const title = document.getElementById("title");
let tblProfesores;

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

  tblProfesores = $("#tblProfesores").DataTable({
    ajax: {
      url: base_url + "Profesores/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "cedula" },
      { data: "nombre_completo" },
      { data: "telefono" },
      { data: "correo" },
      { data: "grado" },
      { data: "fecha_nac" },
      { data: "direccion" },
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "desc"]],
  });

  btnNewProfe.addEventListener("click", function (e) {
    e.preventDefault();

    frmProfesores.idProfe.value = "";
    frmProfesores.idDatos.value = "";
    frmProfesores.reset();
    bloquearEntrada(frmProfesores);

    title.textContent = "Nuevo Profesores";
    $("#modalRegistro").modal("show");
  });

  frmProfesores.addEventListener("submit", function (e) {
    e.preventDefault();

    bloquearEntrada(frmProfesores);



    if (
      frmProfesores.cedula.value == "" ||
      frmProfesores.nombre.value == "" ||
      frmProfesores.apellido.value == "" ||
      frmProfesores.fecha.value == "" ||
      frmProfesores.correo.value == "" ||
      frmProfesores.direccion.value == "" ||
      frmProfesores.telefono.value == "" ||
      frmProfesores.grado.value == ""
    ) {
      alertaPersonalizada("warning", "Todos los campos son obligatorios");
    } else {
      const data = new FormData(frmProfesores);
      const http = new XMLHttpRequest();
      const url = base_url + "Profesores/guardar";

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            frmProfesores.reset();
            $("#modalRegistro").modal("hide");
            tblProfesores.ajax.reload();
          }
        }
      };
    }
  });
});

function editar(id) {
  const http = new XMLHttpRequest();
  const url = base_url + "Profesores/editar/" + id;

  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      frmProfesores.idProfe.value = res.id;
      frmProfesores.idDatos.value = res.id_datosP;
      frmProfesores.cedula.value = res.cedula;
      frmProfesores.nombre.value = res.nombre;
      frmProfesores.apellido.value = res.apellido;
      frmProfesores.fecha.value = res.fecha_nac;
      frmProfesores.direccion.value = res.direccion;
      frmProfesores.telefono.value = res.telefono;
      frmProfesores.correo.value = res.correo;
      bloquearEntrada(frmProfesores);

      title.textContent = "Editar Profesores";
      $("#modalRegistro").modal("show");
    }
  };
}

function eliminar(id) {
  Swal.fire({
    title:
      "Los profesores no se pueden eliminar, proximamente...",
    showClass: {
      popup: `
        animate__animated
        animate__fadeInUp
        animate__faster
      `,
    },
    hideClass: {
      popup: `
        animate__animated
        animate__fadeOutDown
        animate__faster
      `,
    },
  });
}
