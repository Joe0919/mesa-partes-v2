$(document).ready(function () {
  $("#fondo").css(
    "background-image",
    "url(" + base_url + "/public/images/fondo.webp)"
  );

  // Enviar los datos para verificacion de usuario
  $("#form_acceso").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
      url: base_url + "/Acceso/login",
      type: "POST",
      datatype: "json",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        Swal.fire({
          title: "Cargando...",
          text: "Por favor, espere.",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });
      },
      success: function (response) {
        data = $.parseJSON(response);
        Swal.close();
        if (!data.status) {
          MostrarAlerta(data.title, data.msg, "error");
        } else {
          Swal.fire({
            title: "Ingresando al sistema",
            text: "Por favor, espere.",
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            },
          });

          setTimeout(function () {
            window.location.href = base_url + "/dashboard";
          }, 1000);
        }
        $("#loader").hide();
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al enviar los datos", "error");
        console.error("Error: " + error);
        Swal.close();
      },
    });
  });
});
