<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Representantes</h1>
      <button id="btnNewRepre" class="btn btn-primary" type="button">Nuevo <i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="">
      <table class="table table-hover display nowrap" id="tblRepresentantes" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
            <th>Id</th>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha Nacimiento</th>
            <th>Dirección</th>
            <th>Telefono</th>
            <th>Relación</th>
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

      <form id="frmRepresentantes" autocomplete="off">

        <input type="hidden" id="idRepre" name="idRepre">
        <input type="hidden" id="idDatos" name="idDatos">

        <div class="modal-body mb-2">
          <label for="cedula">Cedula</label>
          <div class="input-group mb-2">
            <input class="form-control validanumericos" maxlength="8" minlength="7" type="text" id="cedula" name="cedula" placeholder="Cedula">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>

          <div class="row mb-2">

            <div class="col-md-6">
              <label for="nombre">Nombre</label>
              <div class="input-group mb-2">
                <input class="form-control" type="text" maxlength="50" id="nombre" name="nombre" placeholder="Nombre">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
            </div>

            <div class="col-md-6">
              <label for="apellido">Apellido</label>
              <div class="input-group mb-2">
                <input class="form-control" type="text" maxlength="50" id="apellido" name="apellido" placeholder="Apellido">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
            </div>
          </div>

          <label for="fecha">Fecha de nacimiento</label>
          <div class="input-group mb-2">
            <input class="form-control" type="date" id="fecha" name="fecha" placeholder="Fecha">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
          </div>

          <label for="direccion">Dirección</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" maxlength="100" id="direccion" name="direccion" placeholder="Dirección">
            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="telefono">Telefono</label>
              <div class="input-group mb-2">
                <input class="form-control validanumericos" type="text" minlength="11" maxlength="12" id="telefono" name="telefono" placeholder="Telefono">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
              </div>
            </div>

            <div class="col-md-6">
              <label for="relacion">Relación</label>
              <div class="input-group mb-2">
                <input class="form-control" type="text" maxlength="20" id="relacion" name="relacion" placeholder="Relacion">
                <span class="input-group-text"><i class="fas fa-users"></i></span>
              </div>
            </div>
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