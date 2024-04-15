const formulario = document.getElementById('formulario');

bloquearEntrada(formulario);

document.addEventListener('DOMContentLoaded', function(){
  formulario.addEventListener('submit', function(e){
    e.preventDefault();

    if (formulario.clave.value == "" || formulario.claveNew.value == "" || formulario.confirmar.value == "") {
      alertaPersonalizada("warning", "Todos los campos son obligatorios.");
    }else if (formulario.claveNew.value !== formulario.confirmar.value){
      alertaPersonalizada("warning", "Las contraseñas no coinciden.");
    }else {
      const data = new FormData(formulario);
      const http = new XMLHttpRequest();
      const url = base_url + 'Perfil/actualizar';

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == 'success') {
            formulario.reset();
          }
        }
      }
    }
  });
});