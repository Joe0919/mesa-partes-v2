$(document).ready(function () {

  $("#loader").show();

  tablaTramites = $("#tablaTramites").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "/Tramites/getTramites",
      dataSrc: "",
    },
    ordering: false,
    autoWidth: false,
    columns: [
      { data: "expediente" },
      { data: "Fecha" },
      { data: "tipodoc" },
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
});
