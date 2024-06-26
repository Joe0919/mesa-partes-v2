$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  /*=============================   MOSTRAR TABLA DE TRAMITES  ================================= */
  tablaTramites = $("#tablaTramites").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: "../../app/controllers/tramite-controller.php",
      method: "POST", 
      data: { opcion: opcion },
      dataSrc: "",
    },
    columnDefs: [
      { targets: -6, width: "28%" }, 
    ],
    ordering: false,
    columns: [
      {
        data: "expediente",
        render: function (data, type) {
          return "<b>" + data + "</b>";
        },
      },
      { data: "Fecha" },
      { data: "tipodoc" },
      { data: "dni" },
      { data: "Datos" },
      { data: "origen" },
      { data: "area" },
      {
        data: "estado",
        render: function (data, type) {
          let color = "";
          switch (data) {
            case "PENDIENTE":
              color = "bg-black";
              break;
            case "ACEPTADO":
              color = "bg-success";
              break;
            case "RECHAZADO":
              color = "bg-danger";
              break;
            case "ARCHIVADO":
              color = "bg-primary";
              break;
          }
          return (
            '<span style="font-size:14px"  class="badge ' +
            color +
            '">' +
            data +
            "</span> "
          );
        },
      },
      {
        defaultContent: `<div class='text-center'>
            <div class='btn-group'>
                  <button class='btn btn-outline-dark btn-sm btn-table btnMas' title='Más Información'>
                    <i class='material-icons'>add_circle</i></button>
            </div>
          </div>`,
      },
      {
        defaultContent: `<div class='text-center'>
          <div class='btn-group'>
                <button class='btn btn-warning btn-sm btn-table btnSeguimiento' title='Ver Historial'>
                      <i class='material-icons'>search</i></button>
          </div>
        </div>`,
      },
    ],
    initComplete: function () {
      // Oculta el loader una vez que los datos se hayan cargado
      $("#loader").hide(); // Mostrar DIv de carga
    },
  });

  // # NOTA: LA FUNCION DE MAS INFORMACION Y SEGUIMIENTO ESTAN EN MAIN.JS EN PUBLIC
});
