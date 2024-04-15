</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; by G4LIFEDEV <?= date("Y")?></span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres salir?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Selecciona "Cerrar Sesión" si quieres salir de tu cuenta.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= 'Usuarios/salir'?>">Cerrar Sesión</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= BASE_URL ?>assets/vendorManual/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL ?>assets/vendorManual/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= BASE_URL ?>assets/vendorManual/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= BASE_URL ?>assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= BASE_URL ?>assets/vendorManual/datatables/datatables.min.js"></script>
<!-- <script src="<?= BASE_URL ?>assets/vendorManual/datatables/dataTables.bootstrap4.min.js"></script> -->

<!-- Page level custom scripts -->
<!-- <script src="<?= BASE_URL ?>assets/js/demo/datatables-demo.js"></script> -->

<!-- Page level plugins -->
<!-- <script src="<?= BASE_URL ?>assets/vendorManual/chart.js/Chart.min.js"></script> -->

<!-- Page level custom scripts -->
<!-- <script src="<?= BASE_URL ?>assets/js/demo/chart-area-demo.js"></script>
<script src="<?= BASE_URL ?>assets/js/demo/chart-pie-demo.js"></script> -->

<script src="<?= BASE_URL ?>assets/vendorManual/swetalert2/sweetalert2@11.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js" type="text/javascript"></script>

<script>
  const base_url = "<?= BASE_URL ?>";
</script>

<script src="<?= BASE_URL ?>assets/js/custom.js"></script>
<?php if(!empty($data['script'])){ ?>
  <script src="<?= BASE_URL . 'assets/js/pages/' . $data['script']; ?>"></script>
  <?php } ?>

</body>
</html>