const btnNewRol = document.getElementById('btnNewRol');
const frmRoles = document.getElementById('frmRoles');
const title = document.getElementById('title');
let tblRoles;

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

  tblRoles = $("#tblRoles").DataTable({
    ajax: {
      url: base_url + "Roles/listar",
      dataSrc: "",
    },
    columns: [
      {data: 'id'},
      {data: 'rol'},
      {data: 'estado'},
      {data: 'acciones'},
    ],
    language: language,
    responsive: true,
    order: [[0, "desc"]],
  });

  // ABRIR MODAL NUEVO ROL
  btnNewRol.addEventListener('click', function(e){
    e.preventDefault();

    title.textContent = "Nuevo Rol";
    $('#modalRegistro').modal('show');
  });

  // NUEVO ROL FORM
  frmRoles.addEventListener('submit', function(e){
    e.preventDefault();

    if (frmRoles.rol.value == '') {
      alertaPersonalizada('warning', 'Tienes que introducir un rol');
    }else {
      const data = new FormData(frmRoles);
      const http = new XMLHttpRequest();
      const url = base_url + 'Roles/guardar';

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function (){
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == 'success') {
            frmRoles.reset();
            $("#modalRegistro").modal("hide");
            tblRoles.ajax.reload();
          }
        }
      }
    }
  });

});
