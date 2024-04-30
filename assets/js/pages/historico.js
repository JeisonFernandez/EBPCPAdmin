

///////////////////////////////////jjj
const btnNewHistorico = document.getElementById("btnNewHistorico");
const modalRegistroHistorico = document.getElementById("modalRegistroHistorico");
const frmHistorico = document.getElementById("frmHistorico");
const titleHistorico = document.getElementById("titleHistorico");

  
let tblHistorico;
  
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
  
    
  
    tblHistorico = $("#tblHistorico").DataTable({
      ajax: {
        url: base_url + "Historico/listar",
        dataSrc: "",
      },
      columns: [
        /* { data: "id" },  */
        { data: "nombre_completo" },
        { data: "fecha_inicio" }, 
        {data: "fecha_fin" }, 
        { data: "estado_anterior" },
        { data: "estado_nuevo" },
        { data: "acciones" }
      ],
      language: language,
      responsive: true,
      order: [[0, "asc"]],
    });
  
    
  
    frmHistorico.addEventListener("submit", function (e) {
      e.preventDefault();
      bloquearEntrada(frmHistorico);
  
      const data = new FormData(frmHistorico);
      const http = new XMLHttpRequest();
      const url = base_url + "Historico/guardar";
  
      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
  
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            frmHistorico.reset();
            $("#modalRegistroHistorico").modal("hide");
            tblHistorico.ajax.reload();
          }
        }
      };
    
    });
  });
  
  
  function eliminar(id) {
    const url = base_url + "Historico/eliminar/" + id;
    eliminarRegistro(
      "¿Estas seguro de eliminar?",
      "El Historico se eliminará de forma permanente.",
      "Si, Eliminar",
      url,
      tblGrados
    );
  }
  
  
  function editar(id) {
    const http = new XMLHttpRequest();
  
    const url = base_url + "Historico/editar/" + id;
  
    http.open("GET", url, true);
  
    http.send();
  
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        
        frmHistorico.id.value = res.id;
        frmHistorico.id_alumno.value = res.id_alumno;
        frmHistorico.alumno.value = res.nombre_completo;
        frmHistorico.fecha_inicio.value = res.fecha_inicio;
        frmHistorico.fecha_fin.value = res.fecha_fin;
        frmHistorico.estado_anterior.value = res.estado_anterior;
        frmHistorico.estado_nuevo.value = res.estado_nuevo;  
        }
  
        titleHistorico.textContent = "Editar Historico";
        $("#modalRegistroHistorico").modal("show");
        
      }
    };
  
  
  