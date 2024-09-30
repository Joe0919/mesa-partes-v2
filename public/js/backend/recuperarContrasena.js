$(document).ready(function () {
  let idusuario, usuario, correo;

  $("#fondo1").css(
    "background-image",
    "url(" + base_url + "/public/images/fondo1.webp)"
  );

  // Enviar los datos para verificacion de usuario
  $("#form_recuperar").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (!verificarCampos(formulario)) {
      MostrarAlerta(
        "Advertencia",
        "Por favor, complete todos los campos requeridos.",
        "error"
      );
    } else {
      if (!ValidarCorreo($("#correo").val())) {
        MostrarAlerta(
          "Advertencia",
          "El correo ingresado no es válido.",
          "error"
        );
      } else {
        let formData = new FormData(this);
        $.ajax({
          url: base_url + "/recuperar-contrasena/getUsuario",
          type: "POST",
          datatype: "json",
          data: formData,
          processData: false,
          contentType: false,
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            console.log(response);
            objData = $.parseJSON(response);
            if (!objData.status) {
              MostrarAlerta(objData.title, objData.msg, "error");
            } else {
              idusuario = objData.data.idusuarios;
              usuario = objData.data.datos;
              correo = objData.data.email;

              Swal.fire({
                title: "Advertencia",
                html:
                  "<span>Se generará una nueva contraseña y será enviada al correo registrado del usuario: </span>" +
                  "<br><b>" +
                  usuario +
                  "</b><br><br>" +
                  "<b>¿Desea continuar?</b><br><b>" +
                  "</b>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Si, Continuar",
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: base_url + "/recuperar-contrasena/setPswUsuario",
                    type: "POST",
                    datatype: "json",
                    data: {
                      idusuario: idusuario,
                      usuario: usuario,
                      correo: correo,
                    },
                    success: function (response) {
                      console.log(response);
                      objData = $.parseJSON(response);
                      if (objData.status) {
                        $("#form_recuperar")[0].reset();
                        idusuario = "";
                        usuario = "";
                        Swal.fire({
                          title: "Enviando al correo",
                          text: "Por favor, espere.",
                          allowOutsideClick: false,
                          didOpen: () => {
                            Swal.showLoading();
                          },
                        });
                        setTimeout(function () {
                          MostrarAlerta(
                            "Contraseña Cambiada",
                            "Se le envió la nueva contraseña con éxito a su correo.",
                            "success"
                          );
                        }, 1000);
                      } else {
                        MostrarAlerta(objData.title, objData.msg, "error");
                      }
                    },
                    error: function (error) {
                      MostrarAlerta(
                        "Error",
                        "Error al enviar al correo",
                        "error"
                      );
                      console.error("Error: " + error);
                    },
                  });
                }
              });
            }
          },
          error: function (error) {
            MostrarAlerta("Error", "Error al enviar los datos", "error");
            console.error("Error: " + error);
          },
        });
      }
    }
  });
});

function MostrarAlerta(titulo, descripcion, tipoalerta) {
  Swal.fire({
    title: titulo,
    text: descripcion,
    icon: tipoalerta,
    confirmButtonText: "Entendido", // Cambia el texto del botón de confirmación
  });
}

function verificarCampos(formulario) {
  let camposVacios = formulario.find("input[required]").filter(function () {
    return $.trim($(this).val()) === "";
  });

  return camposVacios.length === 0;
}

function ValidarCorreo(correo) {
  // let expReg = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  let expReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (expReg.test(correo)) {
    return true; // El correo electrónico es válido
  } else {
    return false; // El correo electrónico no es válido
  }
}
