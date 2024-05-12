<?php include 'views/Templates/header.php' ?>

<!-- Page Heading -->
<div class="d-flex navegacion card shadow border-bottom-primary mb-2">
  <a class="disabled active" href="Principal">Home</a>
  <a class="desabilitar">/</a>
  <a class="desabilitar">Parentesco Alumno</a>
  <a class="desabilitar">/</a>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 resposive-ch">
      <h1 class="h2 mb-0 text-gray-800">Parentesco Alumno</h1>
      <button id="btnNewParentesco" class="btn btn-primary" type="button">Nueva Relación <i
          class="fas fa-plus"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="table-container">
      <table class="table table-hover display" id="tblParentesco" style="width:100%;">
        <thead class="text-white bg-gradient-primary">
          <tr>
            <!-- <th>Id</th> -->
           <th>Relacion</th>  
            <th>Acciones</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>

<div id="modalRegistroParentesco" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="titleParentesco"></h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="frmParentesco" autocomplete="off">

    <input type="hidden" id="id" name="id">

    <div class="modal-body mb-2">

        <label for="relacion">Relacion</label>
        <div class="input-group mb-2">
            <input class="form-control validarLetras" type="text" id="relacion" name="relacion" placeholder="Relacion">
            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
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