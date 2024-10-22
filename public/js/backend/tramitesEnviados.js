$(document).ready(function () {
  $("#loader").show();

  let area = $("#info-area").val();

  tablaTramitesEnviados = $("#tablaTramitesEnviados").DataTable({
    destroy: true,
    language: {
      url: "Spanish.json",
    },
    ajax: {
      url:
        base_url + "/tramites-enviados/getTramites/" + area.replace(/ /g, "+"),
      dataSrc: "",
    },
    ordering: true,
    autoWidth: false,
    columns: [
      { data: "expediente" },
      { data: "Fecha" },
      { data: "dni" },
      { data: "Datos" },
      { data: "origen" },
      { data: "area" },
      { data: "estado" },
      { data: "opciones" },
    ],
    initComplete: function () {
      $("#loader").hide();
    },
  });

  $("#btn_reload").click(function () {
    tablaTramitesEnviados.ajax.reload(null, false);
  });
});
