<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Usuarios</h1>
      <div class="">
        <a href="Usuarios/generarPdf" target="_blank" class="btn btn-danger" type="button"><i class="fas fa-file-pdf"></i></a>
        <a href="" class="btn btn-success" type="button"><i class="fas fa-file-excel"></i></a>
      </div>
      <button id="btnNewUser" class="btn btn-primary" type="button">Nuevo Usuario <i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="">
      <table class="table table-hover display nowrap" id="tblUsuarios" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
            <th>Id</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>


<div id="modalRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="title"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmUsuario" autocomplete="off">

        <input type="hidden" id="id_usuario" name="id_usuario">

        <div class="modal-body mb-2">
          <label for="usuario">Usuario</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Usuario" maxlength="50"
              pattern="[a-zA-Z0-9]+" required>
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>

          <label for="correo">Correo</label>
          <div class="input-group mb-2">
            <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo" required>
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          </div>

          <div class="row mb-2">

            <div class="col-md-6">
              <label for="clave">Clave</label>
              <div class="input-group">
                <input class="form-control" type="password" id="clave" name="clave" placeholder="Contraseña" required>
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
            </div>

            <div class="col-md-6">
              <label for="confirmar">Confirmar</label>
              <div class="input-group">
                <input class="form-control" type="password" id="confirmar" name="confirmar"
                  placeholder="Confirmar Contraseña" required>
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
            </div>
          </div>

          <label for="rol">Roles</label>
          <div class="input-group">
            <select id="rol" class="form-control" name="rol" required>
              <?php foreach ($data['roles'] as $rol) { ?>
                <option value="<?= $rol['id'] ?>"><?= $rol['rol'] ?></option>
              <?php } ?>
            </select>
            <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
          </div>

        </div>

        <div class="modal-footer d-flex justify-content-start">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Guardar</button>
          <button class="btn btn-danger" data-dismiss="modal" type="button"><i class="fas fa-times-circle mr-1"></i>
            Cancelar</button>
        </div>

      </form>

    </div>
  </div>
</div>


<?php include 'views/Templates/footer.php' ?>