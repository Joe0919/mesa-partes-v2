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

});
