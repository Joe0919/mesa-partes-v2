$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  $("#div_no_encontrado").hide();
  $("#datos_buscados").hide();
  $("#linea_tiempo").hide();

  $("#form_busqueda").on("submit", function (e) {
    e.preventDefault();
    opcion = 10;
    let formData = new FormData(this);
    formData.append("opcion", opcion);
    $.ajax({
      url: "../../app/controllers/tramite-controller.php",
      type: "POST",
      datatype: "json",
      data: formData,
      processData: false, // Evita que jQuery procese los datos del formulario
      contentType: false, // Evita que jQuery establezca el encabezado Content-Type
      beforesend: function () {
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        if (data.length != 0) {
          $("#celdaexpe").text(data[0]["nro_expediente"]);
          $("#celdanro").text(data[0]["nro_doc"]);
          $("#celdatipo").text(data[0]["tipodoc"]);
          $("#celdasunto").text(data[0]["asunto"]);

          $("#celdadni").text(data[0]["dni"]);
          $("#celdadatos").text(data[0]["Datos"]);
          $("#celdaruc").text(data[0]["ruc_institu"]);
          $("#celdaenti").text(data[0]["institucion"]);
          $("#div_form").hide();
          $("#div_no_encontrado").hide();
          $("#btnhistorial").prop("disabled", false);
          $("#datos_buscados").show();
        } else {
          $("#expediente-info").text($("#expediente_b").val());
          $("#dni-info").text($("#dni_b").val());
          $("#anio-info").text($("#select-año").val());
          $("#div_no_encontrado").show();
          $("#expediente_b").focus();
          $("#form_busqueda")[0].reset();
        }

        $("#loader").hide();
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
      complete: function () {
        $("#loader").hide(); // Ocultar Div de carga al completar la solicitud
      },
    });
  });

  $("#btnLimpiar").click(function () {
    $("#form_busqueda")[0].reset();
    $("#expediente_b").focus();
  });

  $("#btnNuevaBusqueda").click(function () {
    Limpiar();
  });

  $("#btnHistorial").click(function () {
    if ($("#celdaexpe").text().length < 6) {
      MostrarAlerta("Error", "No se puede realizar esta acción", "error");
    } else {
      opcion = 11;
      expediente = $.trim($("#expediente_b").val());
      idni = $("#dni_b").val();
      anio = $("#select-año").val();
      $.ajax({
        url: "../../app/controllers/tramite-controller.php",
        type: "POST",
        datatype: "json",
        data: {
          opcion: opcion,
          expediente: expediente,
          anio: anio,
          idni: idni,
        },
        beforesend: function () {
          $("#loader").show();
        },
        success: function (response) {
          $("#linea_tiempo").append(response);
          $("#linea_tiempo").show();
          $("#btnHistorial").prop("disabled", true);
          window.location = "#linea_tiempo";
          $("#loader").hide();
        },
        error: function (error) {
          console.error("Error: " + error);
        },
      });
    }
  });

  function Limpiar() {
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
    $("#div_no_encontrado").hide();
    $("#btnHistorial").prop("disabled", false);
  }
});
