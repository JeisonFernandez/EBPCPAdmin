const btnNewParentesco = document.getElementById("btnNewParentesco");
const modalRegistroParentesco = document.getElementById("modalRegistroParentesco");
const frmParentesco = document.getElementById("frmParentesco");
const titleParentesco = document.getElementById("titleParentesco");

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
  tblParentesco = $("#tblParentesco").DataTable({
    ajax: {
      url: base_url + "Parentesco/listar",
      dataSrc: "",
    },
    columns: [
     /*  { data: "id" }, */
      {data: "relacion" }, 
      { data: "acciones" },
    ],
    language: language,
    responsive: true,
    order: [[0, "asc"]],
  });

  btnNewParentesco.addEventListener("click", (e) => {
    e.preventDefault();

    frmParentesco.reset();
    bloquearEntrada(frmParentesco);

    titleParentesco.textContent = "Nuevo Parentesco";
    $("#modalRegistroParentesco").modal("show");
  });


  frmParentesco.addEventListener("submit", function (e) {
    e.preventDefault();
    bloquearEntrada(frmParentesco);

    if (
      frmParentesco.relacion.value == "" 
    ){
      alertaPersonalizada("warning", "Todos los campos son obligatorios");
    }else{

    const data = new FormData(frmParentesco);
    const http = new XMLHttpRequest();
    const url = base_url + "Parentesco/guardar";

    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);

        alertaPersonalizada(res.tipo, res.mensaje);
        if (res.tipo == "success") {
          frmParentesco.reset();
          $("#modalRegistroParentesco").modal("hide");
          tblParentesco.ajax.reload();
        }
      }
    };
  } 
  });
});


function eliminar(id) {
  const url = base_url + "Parentesco/eliminar/" + id;
  eliminarRegistro(
    "¿Estas seguro de eliminar?",
    "El Parentesco se eliminará de forma permanente.",
    "Si, Eliminar",
    url,
    tblParentesco
  );
}


function editar(id) {
  const http = new XMLHttpRequest();

  const url = base_url + "Parentesco/editar/" + id;

  http.open("GET", url, true);

  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      
      frmParentesco.id.value = res.id;
      frmParentesco.relacion.value = res.relacion;
      }

      titleParentesco.textContent = "Editar Parentesco";
      $("#modalRegistroParentesco").modal("show");
      
    }
  };


