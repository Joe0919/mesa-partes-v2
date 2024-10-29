$(document).ready(function () {
  let idusuario, usuario, correo;

  $("#fondo1").css(
    "background-image",
    "url(" + base_url + "/public/images/recovery.webp)"
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
            objData = JSON.parse(response);
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
                    beforeSend: function () {
                      Swal.fire({
                        title: "Enviando al correo",
                        text: "Por favor, espere.",
                        allowOutsideClick: false,
                        didOpen: () => {
                          Swal.showLoading();
                        },
                      });
                    },
                    success: function (response) {
                      objData = JSON.parse(response);
                      Swal.close(); 

                      if (objData.status) {
                        $("#form_recuperar")[0].reset();
                        idusuario = "";
                        usuario = "";
                        MostrarAlerta(
                          "Contraseña Cambiada",
                          "Se le envió la nueva contraseña a su correo.",
                          "success"
                        );
                      } else {
                        MostrarAlerta(objData.title, objData.msg, "error");
                      }
                    },
                    error: function (error) {
                      Swal.close();
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


