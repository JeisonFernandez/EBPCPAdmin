<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h1 mb-0 text-gray-800" style="font-weight: bold;">Perfil</h1>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex justify-content-center align-items-center flex-column">
      <h2 class="h2 mb-0 text-gray-800 changePass">Cambiar contraseña</h2>
      <form id="formulario" autocomplete="off">

        <div class="modal-body mb-2">

          <input type="hidden" id="idUser" name="idUser" value="<?= $data['id_usuario'] ?>">

          <label for="clave">Contraseña actual</label>
          <div class="input-group mb-2">
            <input class="form-control" type="password" id="clave" name="clave" placeholder="Contraseña actual" required>
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>

          <div class="row mb-2">

            <div class="col-md-6">
              <label for="claveNew">Contraseña nueva</label>
              <div class="input-group">
                <input class="form-control" type="password" id="claveNew" name="claveNew" placeholder="Contraseña nueva" required>
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
            </div>

            <div class="col-md-6">
              <label for="confirmar">Confirmar contraseña</label>
              <div class="input-group">
                <input class="form-control" type="password" id="confirmar" name="confirmar"
                  placeholder="Confirmar Contraseña" required>
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-primary" style="width: 100%;" type="submit"><i class="fas fa-save mr-1"></i> Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>




<?php include 'views/Templates/footer.php' ?>