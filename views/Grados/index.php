<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Estudiantes</h1>
      <button id="btnNewGrado" class="btn btn-primary" type="button">Nuevo Grado <i
          class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-container">
      <table class="table table-hover display" id="tblGrados" style="width:100%;">
        <thead class="text-white" style="background-color: #4e73df;">
          <tr>
            <!-- <th>Id</th> -->
            <th>Grados</th>
            <!-- <th>Seccion</th>-->
           <th>Descripcion</th>  
            <th>Duracion</th>
            <th>Acciones</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>

<div id="modalRegistroGrado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="titleGrado"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmGrado" autocomplete="off">

    <input type="hidden" id="id" name="id">

    <div class="modal-body mb-2">
        <label for="grado">Grado</label>
        <div class="input-group mb-2">
            <input class="form-control" type="number" id="grado" name="grado" placeholder="Grado">
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
        </div>

        <label for="seccion">Seccion</label>
        <div class="input-group mb-2">
            <input class="form-control" type="text" id="seccion" name="seccion" placeholder="Seccion">
            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
        </div>

        <label for="descripcion">Descripcion</label>
        <div class="input-group mb-2">
            <input class="form-control" type="text" id="descripcion" name="descripcion" placeholder="Descripcion">
            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
        </div>

        <label for="duracion">Duracion</label>
        <div class="input-group mb-2">
            <input class="form-control" type="text" id="duracion" name="duracion" placeholder="Duracion">
            <span class="input-group-text"><i class="fas fa-clock"></i></span>
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