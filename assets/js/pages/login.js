const frmLogin = document.getElementById("frmLogin");
const usuario = document.getElementById("usuario");
const clave = document.getElementById("clave");
const btnRecovery = document.getElementById("btnRecovery");

document.addEventListener("DOMContentLoaded", function () {
  frmLogin.addEventListener("submit", (e) => {
    e.preventDefault();

    if (usuario.value == "" || clave.value == "") {
      alertaPersonalizada("warning", "Todos los campos con * son requeridos");
    } else {
      const data = new FormData(frmLogin);
      const http = new XMLHttpRequest();
      const url = base_url + "Home/validar";

      http.open("POST", url, true);
      http.send(data);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          alertaPersonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            let timerInterval;
            Swal.fire({
              title: res.mensaje,
              html: "Redireccionando <b></b>",
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                  timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
              },
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location = base_url + 'Principal';
              }
            });
          }
        }
      };
    }
  });

  btnRecovery.addEventListener("click", function(e){
    e.preventDefault();
    Swal.fire({
      icon: "warning",
      title: "¿Olvidaste tu contraseña?",
      text: "Si ha olvidado su contraseña, por favor, póngase en contacto con el administrador del sistema para iniciar el proceso de recuperación de la misma. Agradecemos su colaboración.",
    });
  })
});
