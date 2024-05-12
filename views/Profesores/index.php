<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->
<div class="d-flex navegacion card shadow border-bottom-primary mb-2">
  <a class="disabled active" href="Principal">Home</a>
  <a class="desabilitar">/</a>
  <a class="desabilitar">Profesores</a>
  <a class="desabilitar">/</a>
</div>


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Profesores</h1>
      <div class="">
        <a href="Profesores/generarPdf" target="_blank" class="btn btn-danger" type="button"><i
            class="fas fa-file-pdf"></i></a>
      </div>
      <button id="btnNewProfe" class="btn btn-primary" type="button">Nuevo Profesor <i class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="">
      <table class="table table-hover display nowrap" id="tblProfesores" style="width:100%;">
      <thead class="text-white bg-gradient-primary">
          <tr>
            <th>Id</th>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Grado</th>
            <th>Fecha Nacimiento</th>
            <th>Dirección</th>
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

      <form id="frmProfesores" autocomplete="off">

        <input type="hidden" id="idProfe" name="idProfe">
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

          <label for="correo">Correo Electronico</label>
          <div class="input-group mb-2">
            <input class="form-control" type="email" maxlength="100" id="correo" name="correo" placeholder="Correo Electronico">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="telefono">Telefono</label>
              <div class="input-group mb-2">
                <input class="form-control validanumericos" type="text" minlength="11" maxlength="12" id="telefono" name="telefono" placeholder="Telefono">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
              </div>
            </div>
          </div>
          <label for="grado">Grados</label>
          <div class="input-group">
            <select name="grado" id="grado" class="form-control">
                <?php foreach ($data['grados'] as $grado) { ?>
                  <option value="<?php echo $grado['id']; ?>"><?php echo $grado['descripcion']; ?></option>
                <?php } ?>
            </select>
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
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