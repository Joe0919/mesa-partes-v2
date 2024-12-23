let controlador;

$(function () {
  $("#loader").hide();

  let idusuario = $("#iduser").length > 0 ? $("#iduser").val() : "0";
  $("#nom_pdf").hide();

  // Acciones para la vista Home
  $("#btnNuevoTramite").hide();
  controlador = page_id == "2" ? "registro-tramite" : "Tramites";

  $("#idnombre").prop("readonly", true);
  $("#idap").prop("readonly", true);
  $("#idam").prop("readonly", true);
  $("#idcel").prop("readonly", true);
  $("#iddirec").prop("readonly", true);
  $("#idemail").prop("readonly", true);
  $("#idni").focus();

  llenarSelectTipo();

  $("#div_juridica").hide();

  // MOSTRAR SECCION DE PERSONA JURIDICA
  $("input[name='customRadio']").change(function () {
    if ($(this).val() == "juridica") {
      $("#div_juridica").show();
    } else {
      $("#div_juridica").hide();
    }
  });
  // COLOCAR NOMBRE DEL ARCHIVO Y MOSTRAR
  $("#idfile").change(function () {
    let resultado = validarArchivo(this); // Validar el archivo

    if (resultado === 0) {
      MostrarAlerta("Archivo Incorrecto", "Solo se aceptan PDFs", "error");
      $(this).val("");
    } else if (resultado === 2) {
      MostrarAlerta(
        "Demasiado grande",
        "El PDF debe tener menos de 10MB",
        "error"
      );
      $(this).val("");
    } else if (resultado === 1) {
      // Si el archivo es válido, continuar con la lógica
      let file = $(this).prop("files")[0];

      // Mostrar la información del archivo
      let fileName = file.name;
      let fileSize = (file.size / 1024 / 1024).toFixed(2); // Convertir a MB
      $("#alias").text(fileName);
      $("#fileSize strong").text(fileSize);
      $("#fileInfo").removeClass("d-none");
      $("#fileSize").removeClass("d-none");
      $("#archivo").addClass("d-none");
      $("#alias").removeAttr("title");
      $("#nom_pdf").show();
      $("#link_doc").attr({ title: file.name });
      ok = true;
      archivo = "";
    }
  });

  $("#btnEliminar").click(function () {
    // Limpiar el input de archivo
    $("#idfile").val("");
    $("#fileInfo").addClass("d-none");
    $("#alias").text("Documento");
    $("#fileSize strong").text("0.0");
    $("#archivo").removeClass("d-none");
  });
  // VALIDAMOS EXISTENCIA DE PERSONA
  $("#btn_validar").click(function () {
    let dni = $("#idni").val();
    if (dni.length < 8) {
      alert("El DNI debe tener 8 digitos");
      $("#idni").focus();
    } else {
      $.ajax({
        url: `${base_url}/Persona/getPersona/${dni}`,
        type: "GET",
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          objData = JSON.parse(response);
          if (objData.status) {
            $("#idni").prop("readonly", true);
            $("#idnombre").prop("readonly", true);
            $("#idap").prop("readonly", true);
            $("#idam").prop("readonly", true);
            $("#idpersona").val(objData.data.idpersona);
            $("#idap").val(objData.data.ap_paterno);
            $("#idam").val(objData.data.ap_materno);
            $("#idnombre").val(objData.data.nombres);
            $("#idemail").val(objData.data.email);
            $("#idemail").prop("readonly", false);
            $("#idcel").val(objData.data.telefono);
            $("#iddirec").val(objData.data.direccion);

            $("#idruc").val(objData.data.ruc_institu);
            $("#identidad").val(objData.data.institucion);
            ruc = objData.data.ruc_institu;
            if (ruc == null || ruc == "" || ruc == " " || ruc == "  ") {
              $("#radio_natural").prop("checked", true);
              $("#div_juridica").hide();
            } else {
              $("#radio_juridica").prop("checked", true);
              $("#div_juridica").show();
              $("#idruc").prop("readonly", true);
              $("#identidad").prop("readonly", true);
            }
            MostrarAlertaToast(
              "DNI ENCONTRADO",
              "Datos Completados. Solo puede incluir un único email.",
              "success",
              "toast-bottom-center"
            );
          } else {
            MostrarAlertaToast(
              "DNI NO ENCONTRADO",
              "Por favor, registre sus datos en el formulario",
              "error",
              "toast-bottom-center"
            );
            $("#idni").prop("readonly", true);
            $("#idnombre").prop("readonly", false);
            $("#idap").prop("readonly", false);
            $("#idam").prop("readonly", false);
            $("#idcel").prop("readonly", false);
            $("#iddirec").prop("readonly", false);
            $("#idemail").prop("readonly", false);
            $("#idnombre").focus();
          }
          $("#btn_validar").prop("disabled", true);
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

  validarCamposRequeridos("#form_tramite");

  // REGISTRAMOS EL TRAMITE
  $("#form_tramite").on("submit", function (e) {
    e.preventDefault();
    if ($("#idfile").val() == "") {
      MostrarAlerta(
        "Observaciones no Subsanadas",
        "Seleccione un nuevo PDF valido",
        "error"
      );
    } else {
      let formulario = $(this);
      if (!validarCampos(formulario)) {
        MostrarAlerta(
          "Advertencia",
          "Por favor, complete todos los campos requeridos.",
          "error"
        );
      } else {
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se registrará su trámite",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Registrar Trámite",
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData(this);
            formData.append("idusuario", idusuario);
            $("#loader").show();
            $("#loader-text").text(
              "Por favor espere. Estamos registrando su trámite..."
            );
            $.ajax({
              url: `${base_url}/${controlador}/setTramite`,
              type: "POST",
              datatype: "json",
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                objData = JSON.parse(response);
                if (objData.status) {
                  MostrarAlertaHtml(
                    objData.title,
                    `<p>Guarde la siguiente información para realizar el seguimiento de su trámite:</p>
                  <table style="border-collapse: collapse; width: 100%;">
                      <tr>
                          <td style="padding: 8px; text-align: left;">Expediente</td>
                          <td style="padding: 8px; text-align: left;"><b>: ${objData.data.nro_expediente}</b></td>
                      </tr>
                      <tr>
                          <td style="padding: 8px; text-align: left;">Nro. Documento</td>
                          <td style="padding: 8px; text-align: left;"><b>: ${objData.data.nro_doc}</b></td>
                      </tr>
                      <tr>
                          <td style="padding: 8px; text-align: left;">Tipo Documento</td>
                          <td style="padding: 8px; text-align: left;"><b>: ${objData.data.tipodoc}</b></td>
                      </tr>
                      <tr>
                          <td style="padding: 8px; text-align: left;">Remitente</td>
                          <td style="padding: 8px; text-align: left;"><b>: ${objData.data.Datos}</b></td>
                      </tr>
                      <tr>
                          <td style="padding: 8px; text-align: left;">Fecha</td>
                          <td style="padding: 8px; text-align: left;"><b>: ${objData.data.Fecha}</b></td>
                      </tr>
                  </table>`,
                    "success"
                  );
                  $("#loader").hide();
                  $("#form_tramite")[0].reset();
                  $("#nom_pdf").hide();
                  $("#div_juridica").hide();
                  $("#btn_validar").prop("disabled", false);
                  $("#idni").prop("readonly", false);
                  $("#idnombre").prop("readonly", true);
                  $("#idap").prop("readonly", true);
                  $("#idam").prop("readonly", true);
                  $("#idcel").prop("readonly", true);
                  $("#iddirec").prop("readonly", true);
                  $("#idemail").prop("readonly", true);
                  $("#idpersona").val("0");
                  resetVistaNuevoTramite();
                  $("#loader-text").text("Cargando...");
                } else {
                  MostrarAlerta(objData.title, objData.msg, "error");
                }
              },
              error: function (error) {
                MostrarAlerta("Error", "Error al cargar los datos", "error");
                console.error("Error: " + error);
                $("#loader").hide();
                $("#loader-text").text("Cargando...");
              },
              complete: function () {
                $("#loader").hide();
              },
            });
          }
        });
      }
    }
  });

  // LIMPIAR LOS CAMPOS
  $("#btnLimpiar").click(function () {
    resetVistaNuevoTramite();
  });
});

function resetVistaNuevoTramite() {
  $("#form_tramite").trigger("reset");
  $("#nom_pdf").hide();
  $("#div_juridica").hide();
  $("#btn_validar").prop("disabled", false);
  $("#idni").prop("readonly", false);
  $("#idnombre").prop("readonly", true);
  $("#idap").prop("readonly", true);
  $("#idam").prop("readonly", true);
  $("#idcel").prop("readonly", true);
  $("#iddirec").prop("readonly", true);
  $("#idemail").prop("readonly", true);
  $("#idpersona").val("0");
  eliminarValidacion("#form_tramite");
  $("#fileInfo").addClass("d-none");
  $("#fileSize").addClass("d-none");
  $("#archivo").removeClass("d-none");
}

function llenarSelectTipo() {
  $.ajax({
    url: `${base_url}/${controlador}/getSelectTipo`,
    type: "GET",
    datatype: "json",
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      data = JSON.parse(response);
      let select = $("#select_tipo");
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione tipo doc...");
      placeholderOption.attr("disabled", true);
      placeholderOption.attr("selected", true);
      select.append(placeholderOption);
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].idtipodoc);
        option.text(data[i].tipodoc);
        select.append(option);
      }
      $("#loader").hide();
    },
    error: function (error) {
      console.error("Error: " + error);
      MostrarAlerta("Error", "Error al cargar los datos", "error");
      $("#loader").hide();
    },
  });
}
