<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Historico de los Estudiantes</h1>
       <!-- <button id="btnNewHistorico" class="btn btn-primary" type="button">Nuevo Historico <i
          class="fas fa-plus"></i></button>  -->
    </div>
  </div>
  <div class="card-body">
    <div class="table-container">
      <table class="table table-hover display" id="tblHistorico" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
             <!-- <th>Id</th> -->
            <th>Estudiante</th>
            <th>Fecha Inicio</th>
           <th>Fecha Fin</th>  
            <th>Estado Anterior</th>
            <th>Estado Nuevo</th>
            <th>Acciones</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>

<div id="modalRegistroHistorico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="titleHistorico"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmHistorico" autocomplete="off">

    <input type="hidden" id="id" name="id">

    <div class="modal-body mb-2">
        <div class="input-group mb-2">
            <input class="form-control" type="hidden" id="id_alumno" name="id_alumno" placeholder="Estudiante" >
        </div>

        <label for="id_alumno">Estudiante</label>
        <div class="input-group mb-2">
            <input class="form-control" type="text" id="alumno" name="alumno" placeholder="Estudiante" disabled>
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
        </div>

        <label for="fecha_inicio">Fecha Inicio</label>
        <div class="input-group mb-2">
            <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha Inicio">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>

        <label for="fecha_fin">Fecha Fin</label>
        <div class="input-group mb-2">
            <input class="form-control" type="date" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
        </div>

         <label for="estado_anterior">Estado Anterior</label>
          <div class="input-group">
            <select id="estado_anterior" class="form-control" name="estado_anterior" >
              <option value="cursando">Cursando</option>
              <option value="no_cursando">No cursando</option>
            </select>
            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
          </div>

          <label for="estado_nuevo">Estado Nuevo</label>
          <div class="input-group">
            <select id="estado_nuevo" class="form-control" name="estado_nuevo" >
              <option value="cursando">Cursando</option>
              <option value="no_cursando">No cursando</option>
            </select>
            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
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