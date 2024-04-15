const btnNewRepre = document.getElementById("btnNewRepre");
const modalRegistro = document.getElementById("modalRegistro");
const frmRepresentantes = document.getElementById("frmRepresentantes");
const title = document.getElementById("title");
let tblRepresentantes;

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

  tblRepresentantes = $("#tblRepresentantes").DataTable({
    ajax: {
      url: base_url + "Representantes/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "cedula" },
      { data: "nombre_completo" },
      { data: "fecha_nac" },
      { data: "telefono" },
      { data: "relacion" },
      { data: "direccion" },
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "desc"]],
  });

  btnNewRepre.addEventListener("click", function (e) {
    e.preventDefault();

    frmRepresentantes.idRepre.value = "";
    frmRepresentantes.idDatos.value = "";
    frmRepresentantes.reset();
    bloquearEntrada(frmRepresentantes);

    title.textContent = "Nuevo Representante";
    $("#modalRegistro").modal("show");
  });

  frmRepresentantes.addEventListener("submit", function (e) {
    e.preventDefault();

    bloquearEntrada(frmRepresentantes);

    if (
      frmRepresentantes.cedula.value == "" ||
      frmRepresentantes.nombre.value == "" ||
      frmRepresentantes.apellido.value == "" ||
      frmRepresentantes.fecha.value == "" ||
      frmRepresentantes.direccion.value == "" ||
      frmRepresentantes.telefono.value == "" ||
      frmRepresentantes.relacion.value == ""
    ) {
      alertaPersonalizada("warning", "Todos los campos son obligatorios");
    } else {
      const data = new FormData(frmRepresentantes);
      const http = new XMLHttpRequest();
      const url = base_url + "Representantes/guardar";

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            frmRepresentantes.reset();
            $("#modalRegistro").modal("hide");
            tblRepresentantes.ajax.reload();
          }
        }
      };
    }
  });
});

function editar(id) {
  const http = new XMLHttpRequest();
  const url = base_url + "Representantes/editar/" + id;

  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      frmRepresentantes.idRepre.value = res.id;
      frmRepresentantes.idDatos.value = res.id_datosR;
      frmRepresentantes.cedula.value = res.cedula;
      frmRepresentantes.nombre.value = res.nombre;
      frmRepresentantes.apellido.value = res.apellido;
      frmRepresentantes.fecha.value = res.fecha_nac;
      frmRepresentantes.direccion.value = res.direccion;
      frmRepresentantes.telefono.value = res.telefono;
      frmRepresentantes.relacion.value = res.relacion;
      bloquearEntrada(frmRepresentantes);

      title.textContent = "Editar Usuario";
      $("#modalRegistro").modal("show");
    }
  };
}

function eliminar(id) {
  const http = new XMLHttpRequest();
  const url = base_url + "Representantes/comprobarEliminar/" + id;

  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "warning") {
        Swal.fire({
          title:
            "Los representantes no pueden eliminarse mientras tengan alumnos cursando. Para eliminar un representante, primero asegúrate de que no tenga ningún alumno relacionado.",
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
      } else {
        const urlE = base_url + "Representantes/eliminar/" + id;
        eliminarRegistro(
          "¿Estas seguro de eliminar?",
          "El representante se eliminará de forma permanente.",
          "Si, Eliminar",
          urlE,
          tblRepresentantes
        );
      }
    }
  };
}
