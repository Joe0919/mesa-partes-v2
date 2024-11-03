$(document).ready(function () {
  $("#loader").hide();

  let expediente;

  $("#datos_buscados").hide();
  $("#linea_tiempo").hide();

  // Acciones para la vista de inicio
  if (page_id == "13") {
    $("#div_busqueda").hide();
  }

  controlador = page_id == "3" ? "Seguimiento" : "Busqueda";

  validarCamposRequeridos("#form_busqueda");

  $("#form_busqueda").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
      url: `${base_url}/${controlador}/getTramite`,
      type: "POST",
      datatype: "json",
      data: formData,
      processData: false,
      contentType: false,
      beforesend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = JSON.parse(response);
        if (objData.status) {
          $("#tdExpediente").text(objData.data.nro_expediente);
          expediente = objData.data.nro_expediente;
          $("#tdFecha").text(objData.data.Fecha);
          $("#tdNroDoc").text(objData.data.nro_doc);
          $("#tdTipoDoc").text(objData.data.tipodoc);
          $("#tdAsunto").text(objData.data.asunto);
          $("#tdArea").text(objData.data.area);
          $("#tdEstado").text(objData.data.estado);

          $("#tdDNI").text(objData.data.dni);
          $("#tdRemitente").text(objData.data.Datos);
          $("#tdTel").text(objData.data.telefono);
          $("#tdRUC").text(objData.data.ruc_institu);
          $("#tdEntidad").text(objData.data.institucion);
          $("#tdDireccion").text(objData.data.direccion);
          $("#tdCorreo").text(objData.data.email);
          $("#div_form").hide();
          $("#btnhistorial").prop("disabled", false);
          $("#datos_buscados").show();
        } else {
          MostrarAlertaHtml(
            "Trámite No encontrado",
            `<p class='lh-base'>
                No se encontró el trámite <b>` +
              $("#expediente_b").val() +
              `</b>
                , DNI del Firmante: <b>` +
              $("#dni_b").val() +
              `</b> en el <b>` +
              $("#select-año").val() +
              `</b>,
                <br>
                <b>Por favor, intente realizar nuevamente la búsqueda ingresando los datos correctos.<b>
            </p>`,
            "error"
          );
          $("#form_busqueda")[0].reset();
          eliminarValidacion("#form_busqueda");
        }

        $("#loader").hide();
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al cargar los datos", "error");
        console.error("Error: " + error);
        $("#loader").hide();
      },
    });
  });

  $("#btnLimpiarB").click(function () {
    $("#form_busqueda")[0].reset();
    $("#expediente_b").focus();
    eliminarValidacion("#form_busqueda");
  });

  $("#btnNuevaBusqueda").click(function () {
    resetVistaSeguimiento();
  });

  $("#btnHistorial").click(function () {
    if (expediente.length < 6) {
      MostrarAlerta("Error", "No se puede realizar esta acción", "error");
    } else {
      dni = $("#dni_b").val();
      anio = $("#select-año").val();
      $.ajax({
        url: `${base_url}/${controlador}/getHistorialTramite`,
        type: "POST",
        datatype: "json",
        data: {
          expediente: expediente,
          anio: anio,
          dni: dni,
        },
        beforesend: function () {
          $("#loader").show();
        },
        success: function (response) {
          objData = JSON.parse(response);
          if (objData.status) {
            $("#linea_tiempo").empty();
            $("#linea_tiempo").html(objData.data);
            $("#linea_tiempo").show();
            $("#btnHistorial").prop("disabled", true);
          } else {
            MostrarAlerta("Error", "No se pudo cargar el historial", "error");
          }
          $("#loader").hide();
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          $("#loader").hide();
        },
      });
    }
  });

  function resetVistaSeguimiento() {
    $("#form_busqueda")[0].reset();
    $("#expediente_b").focus();
    $("#div_form").show();
    $("#datos_buscados").hide();
    $("#linea_tiempo").hide();
    $("#celdaexpe").text("");
    $("#celdanro").text("");
    $("#celdatipo").text("");
    $("#celdasunto").text("");
    $("#celdadni").text("");
    $("#celdadatos").text("");
    $("#celdaruc").text("");
    $("#celdaenti").text("");
    $("#btnHistorial").prop("disabled", false);
    eliminarValidacion("#form_busqueda");
  }
});
