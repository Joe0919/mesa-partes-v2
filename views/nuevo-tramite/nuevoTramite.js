$(document).ready(function () {
  $("#loader").show(); 

  $("#nom_pdf").hide(); 

  
  $("#idnombre").prop("readonly", true);
  $("#idap").prop("readonly", true);
  $("#idam").prop("readonly", true);
  $("#idcel").prop("readonly", true);
  $("#iddirec").prop("readonly", true);
  $("#idcorre").prop("readonly", true);
  $("#idni").focus();

  llenarSelectTipo(); 

  $("#div_juridica").hide(); 
  
  $("input[name='customRadio']").change(function () {
    if ($(this).val() == "juridica") {
      $("#div_juridica").show();
    } else {
      $("#div_juridica").hide();
    }
  });

  $("#idfile").change(function () {
    $("#nom_pdf").show();
    $("#alias").text($(this).prop("files")[0].name);
  });
  
  $("#btn_validar").click(function () {
    opcion = 1;
    let idni = $("#idni").val();
    if (idni.length < 8) {
      alert("El DNI debe tener 8 digitos");
      $("#idni").focus();
    } else {
      $.ajax({
        url: "../../app/controllers/persona-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, idni: idni },
        beforeSend: function () {
          /* * Se ejecuta al inicio de la petición* */
          $("#loader").show();
        },
        success: function (response) {
          data = $.parseJSON(response);
          $("#btn_validar").prop("disabled", true);
          if (!data) {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "No esta registrado",
              text: "Por favor llene los campos con sus datos.",
              showConfirmButton: false,
              timer: 2800,
            });

            $("#loader").hide();
            $("#idnombre").prop("readonly", false);
            $("#idap").prop("readonly", false);
            $("#idam").prop("readonly", false);
            $("#idcel").prop("readonly", false);
            $("#iddirec").prop("readonly", false);
            $("#idemail").prop("readonly", false);
            $("#idnombre").focus();
          } else {
            $("#idnombre").prop("readonly", true);
            $("#idap").prop("readonly", true);
            $("#idam").prop("readonly", true);
            $("#idpersona").val(data["idpersona"]);
            $("#idnombre").val(data["nombres"]);
            $("#idap").val(data["ap_materno"]);
            $("#idam").val(data["ap_paterno"]);
            $("#idcel").val(data["telefono"]);
            $("#iddirec").val(data["direccion"]);
            $("#idemail").val(data["email"]);

            $("#idruc").val(data["ruc_institu"]);
            $("#identi").val(data["institucion"]);
            ruc = data["ruc_institu"];
            if (ruc == null || ruc == "" || ruc == " " || ruc == "  ") {
              $("#radio_natural").prop("checked", true);
              $("#div_juridica").hide();
            } else {
              $("#radio_juridica").prop("checked", true);
              $("#div_juridica").show();
              $("#idruc").prop("readonly", true);
              $("#identi").prop("readonly", true);
            }
            $("#loader").hide();
          }
        },
      });
    }
  });
  
  $("#form_tramite").on("submit", function (e) {
    e.preventDefault();
    opcion = 2;
    if (ValidarPDF()) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Se registrará su trámite",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Enviar",
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData(this);
          formData.append("opcion", opcion);
          $("#loader").show();
          $.ajax({
            url: "../../app/controllers/tramite-controller.php",
            type: "POST",
            datatype: "json",
            data: formData,
            processData: false, 
            contentType: false, 
            beforesend: function () {
              $("#loader").show(); 
            },
            success: function (response) {
              Swal.fire({
                icon: "success",
                title: "TRÁMITE REGISTRADO",
                html: '<div style="text-align:left">' + response + "</div>",
              });
              $("#form_tramite")[0].reset();
              $("#nom_pdf").hide();
              $("#loader").hide();
            },
            error: function (xhr, status, error) {
              
              console.error("Error: " + error);
            },
            complete: function () {
              $("#loader").hide(); 
            },
          });
        }
      });
      return false;
    } else {
      MostrarAlerta(
        "Error de Archivo Subido",
        "Por favor, seleccione un archivo PDF.",
        "error"
      );
    }
  });

  $("#btnLimpiar").click(function () {
    $("#form_tramite")[0].reset();
    $("#nom_pdf").hide();
    $("#div_juridica").hide();
    $("#btn_validar").prop("disabled", false);
  });
});

function llenarSelectTipo() {
  
  let opcion = 4;
  $.ajax({
    url: "../../app/controllers/tramite-controller.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion },
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      let select = $("#select-tipo");
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione tipo...");
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
    error: function (xhr, status, error) {
      
      console.error("Error: " + error);
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

function ValidarCorreo(correo) {
  var expReg =
    /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
  var esValido = expReg.test(correo);
  if (esValido == true) {
    return true;
  } else {
    return false;
  }
}

function generarPas() {
  var pass = "";
  var str =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZ" + "abcdefghijklmnopqrstuvwxyz0123456789.#$";

  for (i = 1; i <= 8; i++) {
    var char = Math.floor(Math.random() * str.length + 1);

    pass += str.charAt(char);
  }

  return pass;
}
