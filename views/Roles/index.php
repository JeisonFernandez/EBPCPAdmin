<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Roles</h1>
      <button id="btnNewRol" class="btn btn-primary" type="button">Nuevo Rol <i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="">
      <table class="table table-hover display nowrap" id="tblRoles" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
            <th>Id</th>
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


<div id="modalRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="title"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmRoles" autocomplete="off">

        <input type="hidden" id="id_rol" name="id_rol">

        <div class="modal-body mb-2">

          <label for="rol">Nombre</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="rol" name="rol" placeholder="Rol" required>
            <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
          </div>

        </div>

        <div class="modal-footer d-flex justify-content-start">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Guardar</button>
          <button class="btn btn-danger" data-dismiss="modal" type="button"><i class="fas fa-times-circle mr-1"></i> Cancelar</button>
        </div>

      </form>

    </div>
  </div>
</div>


<?php include 'views/Templates/footer.php' ?>