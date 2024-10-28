$(document).ready(function () {
  $("#loader").show();

  idarea = $("#id_areaid").val();
  area = $("#info-area").val();
  estado = $("#select_estado").val();

  inicializarTablaTramites("tablaTramitesRecibidos", "tramites-recibidos");

  $("#select_estado").on("change", function () {
    estado = $(this).val();
    inicializarTablaTramites("tablaTramitesRecibidos", "tramites-recibidos");
  });

  
$("#btn_reload").click(function () {
  let tablaTramitesRecibidos = $("#tablaTramiteRecibidos").DataTable();
  tablaTramitesRecibidos.ajax.reload(null, false);
});
});
