<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Estudiantes</h1>
      <button id="btnNewEstudiante" class="btn btn-primary" type="button">Nuevo Estudiante <i
          class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-container">
      <table class="table table-hover display" id="tblEstudiantes" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
            <th>Id</th>
            <th>Nombres</th>
            <!-- th>Apellido</th> -->
            <th>Grado</th>
            <th>Fecha Nacimiento</th>
            <th>Dirección</th>
            <th>Talla</th>
            <th>Peso</th>
            <th>Altura</th>
            <th>Estado</th>
            <th>Representante</th>
            <th>Acciones</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>

<div id="modalRegistroEstudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="titleEstudiante"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmEstudiante" autocomplete="off">

        <input type="hidden" id="id_estudiante" name="id_estudiante">

        <div class="modal-body mb-2">
          <label for="nombre_alumno">Nombre</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="nombre_alumno" name="nombre_alumno" placeholder="Nombre">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>

          <label for="apellido_alumno">Apellido</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="apellido_alumno" name="apellido_alumno" placeholder="Apellido"
              >
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>

          <label for="fecha_nacimiento">Fecha de Nacimiento</label>
          <div class="input-group mb-2">
            <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" >
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
          </div>

          <label for="direccion">Dirección</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Dirección" >
            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">
              <label for="talla">Talla</label>
              <div class="input-group">
                <input class="form-control" type="text" id="talla" name="talla" placeholder="Talla" >
                <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <label for="peso">Peso</label>
              <div class="input-group">
                <input class="form-control" type="text" id="peso" name="peso" placeholder="Peso" >
                <span class="input-group-text"><i class="fas fa-weight"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <label for="altura">Altura</label>
              <div class="input-group">
                <input class="form-control" type="text" id="altura" name="altura" placeholder="Altura" >
                <span class="input-group-text"><i class="fas fa-arrows-alt-v"></i></span>
              </div>
            </div>
          </div>

          <label for="estado">Estado</label>
          <div class="input-group">
            <select id="estado" class="form-control" name="estado" >
              <option value="cursando">Cursando</option>
              <option value="no_cursando">No cursando</option>
            </select>
            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
          </div>

          <label for="representante">Representante</label>
          <div class="input-group mb-2">
            <input class="form-control" type="text" id="representante" name="representante" placeholder="Representante"
              >
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>
          <div id="representanteLista"> </div>



          <label for="grado">Grado</label>
          <div class="input-group">
            <select name="grado" id="grado" class="form-control">
              <?php if (isset($data['estudiante']['id_grado'])) { ?>
                <?php foreach ($data['grados'] as $grado) { ?>
                  <option value="<?php echo $grado['id']; ?>" <?php if ($grado['id'] == $data['estudiante']['id_grado'])
                      echo 'selected="selected"'; ?>><?php echo $grado['descripcion']; ?></option>
                <?php } ?>
              <?php } else { ?>
                <option value="" selected>Seleccione el grado</option>
                <?php foreach ($data['grados'] as $grado) { ?>
                  <option value="<?php echo $grado['id']; ?>"><?php echo $grado['descripcion']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
          </div>

          <div class="input-group mb-2">
            <input type="hidden" id="id_datos" name="id_datos">
          </div>
          
        </div>

        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Guardar</button>
          <button class="btn btn-danger" data-dismiss="modal" type="button"><i class="fas fa-times-circle mr-1"></i>
            Cancelar</button>
        </div>

      </form>

    </div>
  </div>
</div> 

<?php include 'views/Templates/footer.php' ?>