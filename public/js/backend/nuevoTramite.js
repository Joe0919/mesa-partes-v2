let controlador;

$(document).ready(function () {
  $("#loader").hide();

  let idusuario = $("#iduser").length > 0 ? $("#iduser").val() : "0";
  $("#nom_pdf").hide();

  // Acciones para la vista Home
  $("#btnNuevoTramite").hide();
  controlador = page_id == "15" ? "registro-tramite" : "Tramites";

  $("#idnombre").prop("readonly", true);
  $("#idap").prop("readonly", true);
  $("#idam").prop("readonly", true);
  $("#idcel").prop("readonly", true);
  $("#iddirec").prop("readonly", true);
  $("#idcorre").prop("readonly", true);
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
    $("#nom_pdf").show();
    $("#alias").text($(this).prop("files")[0].name);
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
          objData = $.parseJSON(response);
          if (objData.status) {
            $("#btn_validar").prop("disabled", true);

            $("#idni").prop("readonly", true);
            $("#idnombre").prop("readonly", true);
            $("#idap").prop("readonly", true);
            $("#idam").prop("readonly", true);
            $("#idpersona").val(objData.data.idpersona);
            $("#idap").val(objData.data.ap_paterno);
            $("#idam").val(objData.data.ap_materno);
            $("#idnombre").val(objData.data.nombres);
            $("#idemail").val(objData.data.email);
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
          } else {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: "No esta registrado",
              text: "Por favor llene los campos con sus datos.",
              showConfirmButton: false,
              timer: 2800,
            });
            $("#idni").prop("readonly", true);
            $("#idnombre").prop("readonly", false);
            $("#idap").prop("readonly", false);
            $("#idam").prop("readonly", false);
            $("#idcel").prop("readonly", false);
            $("#iddirec").prop("readonly", false);
            $("#idemail").prop("readonly", false);
            $("#idnombre").focus();
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

  // REGISTRAMOS EL TRAMITE
  $("#form_tramite").on("submit", function (e) {
    e.preventDefault();

    if (ValidarPDF()) {
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
          $.ajax({
            url: `${base_url}/${controlador}/setTramite`,
            type: "POST",
            datatype: "json",
            data: formData,
            processData: false,
            contentType: false,
            beforesend: function () {
              $("#loader").show();
            },
            success: function (response) {
              objData = $.parseJSON(response);
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
              } else {
                MostrarAlerta(objData.title, objData.msg, "error");
              }
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al cargar los datos", "error");
              console.error("Error: " + error);
              $("#loader").hide();
            },
            complete: function () {
              $("#loader").hide();
            },
          });
        }
      });
    } else {
      MostrarAlerta(
        "Error de Archivo Subido",
        "Por favor, seleccione un archivo PDF.",
        "error"
      );
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
      data = $.parseJSON(response);
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

function ValidarPDF() {
  var archivo = document.getElementById("idfile").value;
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  if (extensiones != ".pdf") {
    return false;
  } else {
    return true;
  }
}
