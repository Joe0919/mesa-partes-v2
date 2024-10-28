<!-- url base -->
<script>
  const base_url = "<?= base_url(); ?>";
  const modulo = "<?= $_SESSION['permisosMod']['idmodulo'] ?>";
  const page_id = "<?= $data['page_id'] ?>";
</script>
<!-- jQuery -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- JS PRINCIPAL DEL PROYECTO -->
<script src="<?= media() ?>/js/funciones.js"></script>
<script src="<?= media() ?>/js/main.js"></script>

<!-- Bootstrap 4 -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- FOR DATA PICKER -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media() ?>/templates/AdminLTE/dist/js/adminlte.js"></script>

<!-- SweetAlert2 -->
<script src="<?= media() ?>/templates/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>