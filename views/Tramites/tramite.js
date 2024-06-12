$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  let expediente, archivo, ruc;
  /*=============================   MOSTRAR TABLA DE TRAMITES  ================================= */
  tablaTramites = $("#tablaTramites").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: "../../app/controllers/tramite-controller.php",
      method: "POST", //usamos el metodo POST
      data: { opcion: opcion }, //enviamos opcion 1 para que haga un SELECT
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
    ],
    initComplete: function () {
      // Oculta el loader una vez que los datos se hayan cargado
      $("#loader").hide(); // Mostrar DIv de carga
    },
  });

  //Mostrar datos de usuario para edicion
  $(document).on("click", ".btnMas", function () {
    opcion = 3;
    expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente

    $.ajax({
      url: "../../app/controllers/tramite-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, expediente: expediente },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        if (data.length > 0) {
          // $("#div_iframePDF").show();
          // $("#loaderPDF").hide();
          // $("#error-message").hide();

          $("#iddoc").val(data[0]["iddocumento"]);
          $("#inrodoc").val(data[0]["nro_doc"]);
          $("#ifolio").val(data[0]["folios"]);
          $("#iexpediente").val(data[0]["nro_expediente"]);
          $("#iestad").val(data[0]["estado"]);
          $("#itipodoc").val(data[0]["tipodoc"]);
          $("#iasunt").val(data[0]["asunto"]);
          $("#iddni1").val(data[0]["dni"]);
          $("#idremi").val(data[0]["Datos"]);

          $("#iruc").val(data[0]["ruc_institu"]);
          $("#iinsti").val(data[0]["institucion"]);

          archivo = data[0]["archivo"];

          $("#iframePDF").attr("src", "../../public/" + archivo);

          // $("#iframePDF").on("load", function () {
          //   $("#div_iframePDF").hide();
          //   $("#loaderPDF").show();
          //   $("#error-message").hide();
          // });

          // $("#iframePDF").on("error", function () {
          //   $("#div_iframePDF").hide();
          //   $("#loaderPDF").hide();
          //   $("#error-message").show();
          // });

          ruc = data[0]["ruc_institu"];

          if (ruc == null || ruc == "" || ruc == " " || ruc == "  ") {
            $("#radio_natural").prop("checked", true);
          } else {
            $("#radio_juridica").prop("checked", true);
          }

          ResetModalMas(); //Solo mostrar los divs necesarios

          $("#modalmas").modal({ backdrop: "static", keyboard: false });
          $("#loader").hide();
        }
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  });

  //Redirige a una nueva pestaña para ver el PDF
  $("#btn_NuevoPDF").click(function () {
    $(this).attr("href", "../../public/" + archivo);
  });

  function ResetModalMas() {
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").removeClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  }

  //CERRAR MODAL y resetear valores
  $("#btnCerrarMas").click(function () {
    $("#modalmas").modal("hide");
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").removeClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#NuevoPDF").hide();
    $("#iframePDF").attr("src", "");
    $("#radio_natural").prop("checked", false);
    $("#radio_juridica").prop("checked", false);
    ruc = "";
    archivo = "";
  });
  // VALIDACION PARA MOSTRAR U OCULTAR ELEMENTOS DEL MODAL
  $("#btn_tramite").click(function () {
    $("#btn_remitente").addClass("btn btn-light");
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  });

  $("#btn_remitente").click(function () {
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#btn_tramite").addClass("btn btn-light");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").hide();
    $("#div_remitente").show();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  });

  $("#btn_vistaprevia").click(function () {
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-light");
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#div_tramite").hide();
    $("#div_remitente").hide();
    $("#div_vistaprevia").show();
    $("#btn_NuevoPDF").show();
  });

});
