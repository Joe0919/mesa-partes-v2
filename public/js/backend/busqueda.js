$(document).ready(function () {
  $("#div_no_encontrado").hide();
  $("#datos_buscados").hide();
  $("#linea_tiempo").hide();

  $("#form_busqueda").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
      url: base_url + "/Busqueda/getTramite",
      type: "POST",
      datatype: "json",
      data: formData,
      processData: false,
      contentType: false,
      beforesend: function () {
        $("#loader").show();
      },
      success: function (response) {
        console.log(response);
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#celdaexpe").text(objData.data.nro_expediente);
          $("#celdanro").text(objData.data.nro_doc);
          $("#celdatipo").text(objData.data.tipodoc);
          $("#celdasunto").text(objData.data.asunto);

          $("#celdadni").text(objData.data.dni);
          $("#celdadatos").text(objData.data.Datos);
          $("#celdaruc").text(objData.data.ruc_institu);
          $("#celdaenti").text(objData.data.institucion);
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
      error: function (error) {
        MostrarAlerta("Error", "Error al cargar los datos", "error");
        console.error("Error: " + error);
        $("#loader").hide();
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

  $("#btnHistorial").click(function () {
    if ($("#celdaexpe").text().length < 6) {
      MostrarAlerta("Error", "No se puede realizar esta acción", "error");
    } else {
      expediente = $.trim($("#expediente_b").val());
      dni = $("#dni_b").val();
      anio = $("#select-año").val();
      $.ajax({
        url: base_url + "/Busqueda/getHistorialTramite",
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
          console.log(response);
          objData = $.parseJSON(response);
          if (objData.status) {
            $("#linea_tiempo").empty();
            $("#linea_tiempo").html(objData.data);
            $("#linea_tiempo").show();
            $("#btnHistorial").prop("disabled", true);
            window.location = "#linea_tiempo";
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