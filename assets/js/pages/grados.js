const btnNewGrado = document.getElementById("btnNewGrado");
const modalRegistroGrado = document.getElementById("modalRegistroGrado");
const frmGrado = document.getElementById("frmGrado");
const titleGrado = document.getElementById("titleGrado");

let tblGrados;

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
  tblGrados = $("#tblGrados").DataTable({
    ajax: {
      url: base_url + "Grados/listar",
      dataSrc: "",
    },
    columns: [
     /*  { data: "id" }, */
      { data: "grado_descr" },
      /* { data: "seccion" }, */
      {data: "descripcion" }, 
      { data: "duracion" },
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "asc"]],
  });

  btnNewGrado.addEventListener("click", (e) => {
    e.preventDefault();

    frmGrado.reset();
    bloquearEntrada(frmGrado);

    titleGrado.textContent = "Nuevo Grado";
    $("#modalRegistroGrado").modal("show");
  });


  frmGrado.addEventListener("submit", function (e) {
    e.preventDefault();
    bloquearEntrada(frmGrado);

    if (
      frmGrado.grado.value == "" ||
      frmGrado.seccion.value == "" ||
      frmGrado.descripcion.value == "" ||
      frmGrado.duracion.value == "" 
    ){
      alertaPersonalizada("warning", "Todos los campos son obligatorios");
    }else{

    const data = new FormData(frmGrado);
    const http = new XMLHttpRequest();
    const url = base_url + "Grados/guardar";

    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);

        alertaPersonalizada(res.tipo, res.mensaje);
        if (res.tipo == "success") {
          frmGrado.reset();
          $("#modalRegistroGrado").modal("hide");
          tblGrados.ajax.reload();
        }
      }
    };
  } 
  });
});


function eliminar(id) {
  const url = base_url + "Grados/eliminar/" + id;
  eliminarRegistro(
    "¿Estas seguro de eliminar?",
    "El grado se eliminará de forma permanente.",
    "Si, Eliminar",
    url,
    tblGrados
  );
}


function editar(id) {
  const http = new XMLHttpRequest();

  const url = base_url + "Grados/editar/" + id;

  http.open("GET", url, true);

  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      
      frmGrado.id.value = res.id;
      frmGrado.grado.value = res.grado;
      frmGrado.seccion.value = res.seccion;
      frmGrado.descripcion.value = res.descripcion;
      frmGrado.duracion.value = res.duracion;
      }

      titleGrado.textContent = "Editar Grado";
      $("#modalRegistroGrado").modal("show");
      
    }
  };


