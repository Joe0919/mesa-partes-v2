$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  let expediente, archivo, ruc, idarea, area, estado, bdr;
  opcion = 5;

  //Esperamos que se carguen los datos del usuario logueado
  setTimeout(function () {
    inicializarTabla();
  }, 100);

  function inicializarTabla() {
    idarea = $("#id_areaid").val();
    area = $("#info-area").val();
    estado = $("#select_estado").val();
    console.log(`where area=${area} and estado=${estado} and idubi=${idarea}`);
    /*=============================   MOSTRAR TABLA DE TRAMITES  ================================= */
    tablaTramitesRecibidos = $("#tablaTramitesRecibidos").DataTable({
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
          estado: estado,
          idarea: idarea,
          bdr: bdr,
        }, //enviamos opcion 4 para que haga un SELECT
        dataSrc: "",
      },
      // columnDefs: [
      //   { targets: -2, width: "20px" }, // -2 se refiere a la penúltima columna
      // ],
      ordering: false,
      columns: [
        { data: "expediente" },
        { data: "Fecha" },
        { data: "tipodoc" },
        { data: "dni" },
        { data: "Datos" },
        { data: "origen" },
        { data: "area" },
        {
          data: "estado",
          render: function (data, type) {
            let country = "";
            switch (data) {
              case "PENDIENTE":
                country = "bg-black";
                break;
              case "ACEPTADO":
                country = "bg-success";
                break;
              case "RECHAZADO":
                country = "bg-danger";
                break;
              case "ARCHIVADO":
                country = "bg-primary";
                break;
            }
            return (
              '<span style="font-size:14px"  class="badge ' +
              country +
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
                    <button class='btn btn-success btn-sm btn-table btnAceptar btnPrimario' title='Aceptar Trámite'>
                      <i class='material-icons'>task_alt</i></button>
                    <button class='btn btn-warning btn-sm btn-table btnSeguimiento btnSecundario' title='Ver Historial'>
                      <i class='material-icons'>search</i></button>
                    <button class='btn btn-danger btn-sm btn-table btnDerivar btnSecundario' title='Derivar Documento'>
                      <i class='material-icons'>output</i></button>
              </div>
            </div>`,
        },
      ],
      initComplete: function () {
        // Oculta el loader una vez que los datos se hayan cargado
        $("#loader").hide(); // Mostrar DIv de carga
        $(".btnSecundario").hide();
      },
    });
  }
});
