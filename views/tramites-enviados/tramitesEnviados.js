$(document).ready(function () {
  $("#loader").show();

  //Esperamos que se carguen los datos del usuario logueado
  setTimeout(function () {
    inicializarTabla();
  }, 100);

  function inicializarTabla() {
    opcion = 9;
    area = $("#info-area").val();
    /*=============================   MOSTRAR TABLA DE TRAMITES  ================================= */
    tablaTramitesEnviados = $("#tablaTramitesEnviados").DataTable({
      destroy: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      },
      ajax: {
        url: "../../app/controllers/tramite-controller.php",
        method: "POST", //usamos el metodo POST
        data: {
          opcion: opcion,
          area: area,
        },
        dataSrc: "",
      },
      columnDefs: [{ targets: -1, width: "10px" }],
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
        $("#loader").hide();
        //Validamos que botones se deben de mostrar dependiendo del estado del tramite
      },
    });
  }

  // # NOTA: LA FUNCION DE MAS INFORMACION Y SEGUIMIENTO ESTAN EN MAIN.JS EN PUBLIC
});
