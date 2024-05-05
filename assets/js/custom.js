function alertaPersonalizada(icono, titulo) {
  Swal.fire({
    position: "top-end",
    icon: icono,
    title: titulo,
    showConfirmButton: false,
    timer: 1500,
  });
}

function eliminarRegistro(titulo, texto, accion, url, table) {
  Swal.fire({
    title: titulo,
    text: texto,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            table.ajax.reload();
          }
        }
      };
    }
  });
}

function reingresarRegistro(titulo, texto, accion, url, table) {
  Swal.fire({
    title: titulo,
    text: texto,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: accion,
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            table.ajax.reload();
          }
        }
      };
    }
  });
}


// funcion para todos los inputs que reciban numeres, solo con ponerle la clase (validanumericos) posible cambio
onload = function () {
  let cantidad = document.querySelectorAll(".validanumericos").length;
  for (let i = 0; i < cantidad; i++) {
    var ele = document.querySelectorAll(".validanumericos")[i];
    ele.onkeypress = function (e) {
      if (isNaN(this.value + String.fromCharCode(e.charCode))) return false;
    };
    ele.onpaste = function (e) {
      e.preventDefault();
    };
  }
};

// funcion para bloquear en tiempo real caracteres especiales, SQL, JS, en los inputs (recibe el frm entero tambien)  
function bloquearEntrada(inputElement) {
  inputElement.addEventListener("input", function (event) {
    const inputValue = event.target.value;
    // Validación: No permitir <, >, script, SELECT, DELETE, UPDATE, INSERT, DROP, ALTER, ni caracteres especiales
    if (event.target.type !== "date") {
      if (event.target.id === "direccion" || event.target.type === "password" || event.target.type === "email") {
        const cleanValue = inputValue.replace(/[<>&=]|script|SELECT|DELETE|UPDATE|INSERT|DROP|ALTER|/gi, "");
        event.target.value = cleanValue;
      }else{
        const cleanValue = inputValue.replace(/[<>&=]|script|SELECT|DELETE|UPDATE|INSERT|DROP|ALTER|[^\w\s]/gi, "");
        event.target.value = cleanValue;
      }
    }
  });
}

function EntradaAlumno(inputElement) {
  inputElement.addEventListener("input", function (event) {
    const inputValue = event.target.value;

    if (event.target.id === "peso" || event.target.id === "altura") {
      const cleanValue = inputValue.replace(/[^\d.,]/g, ""); 
      event.target.value = cleanValue;
    } else {
      if (event.target.type !== "date") {
        const cleanValue = inputValue.replace(/[<>&=]|script|SELECT|DELETE|UPDATE|INSERT|DROP|ALTER|[^\w\s]/gi, "");
        event.target.value = cleanValue;
      }
    }
  });
}
