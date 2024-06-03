$(document).ready(function () {
  let idusu = $("#iduser").val();
  let idni = $("#dniuser").val();

  $("#loader").hide(); // Ocultar DIv de carga
  datosUsuarioLogeado($("#dniuser").val());

  // ACCIONES GENERALES
  //Boton mostrar datos de Institucion general
  $("#conf-inst").click(function () {
    opcion = 1;
    $.ajax({
      url: "../../app/controllers/institucion-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion },
      success: function (response) {
        data = $.parseJSON(response);

        $("#idinst").val(data["idinstitucion"]);
        $("#iruci").val(data["ruc"]);
        $("#irazoni").val(data["razon"]);
        $("#idirei").val(data["dirección"]);
        $("#modalinstitu").modal({ backdrop: "static", keyboard: false });
      },
    });
  });

  //Editar datos Institucion general
  $("#form-institucion").on("submit", function (e) {
    e.preventDefault();
    let opcion = 2; // Opcion para el switch del controlador
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Editar los datos de la institución",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, editar",
      }).then((result) => {
        if (result.isConfirmed) {
          var formData = new FormData(this);
          formData.append("opcion", opcion); // Agrega la variable "opcion" al objeto FormData
          $.ajax({
            url: "../../app/controllers/institucion-controller.php",
            type: "POST",
            datatype: "json",
            data: formData,
            beforeSend: function () {
              /* * Se ejecuta al inicio de la petición* */
              $("#loader").show();
            },
            success: function (response) {
              // Manejar la respuesta del servidor
              data = $.parseJSON(response);
              if (data == 1) {
                MostrarAlerta(
                  "Advertencia",
                  "El RUC y/o Razon ya están registrados",
                  "error"
                );
              } else {
                $("#loader").hide();
                ResetForm("formperfil");
                MostrarAlerta("Hecho", "Se actualizaron sus datos.", "success");
                $("#modalinstitu").modal("hide");
              }
            },
            error: function (xhr, status, error) {
              // Manejar errores de la petición AJAX
              console.error("Error: " + error);
            },
            processData: false, // Evita que jQuery procese los datos del formulario
            contentType: false, // Evita que jQuery establezca el encabezado Content-Type
          });
        }
      });
    } else {
      alert("Por favor. Complete los campos requeridos");
    }
  });

  //Mostrar modal con datos de usuario logeado
  $("#conf-perfil").click(function () {
    opcion = 2;
    idusu = $("#iduser").val();
    idni = $("#dniuser").val();
    $.ajax({
      url: "../../app/controllers/usuario-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, idusu: idusu, idni: idni },
      success: function (response) {
        data = $.parseJSON(response);
        $("#idusup").val(data["ID1"]);
        $("#idperp").val(data["ID2"]);
        $("#idnip").val(data["dni"]);
        $("#idnip").prop("readonly", true);
        $("#inombrep").val(data["nombres"]);
        $("#iappatp").val(data["ap"]);
        $("#iapmatp").val(data["am"]);
        $("#icelp").val(data["telefono"]);
        $("#idirp").val(data["direccion"]);
        $("#iemailp").val(data["email"]);
        $("#inomusup").val(data["nombre"]);

        $("#modalUsu").modal({ backdrop: "static", keyboard: false });
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  });

  //Editar los datos de usuario logeado
  $("#formperfil").on("submit", function (e) {
    e.preventDefault();
    let opcion = 3; // Opcion para el switch del controlador
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Editar los datos del usuario",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, editar",
      }).then((result) => {
        if (result.isConfirmed) {
          var formData = new FormData(this);
          formData.append("opcion", opcion); // Agrega la variable "opcion" al objeto FormData
          $.ajax({
            url: "../../app/controllers/usuario-controller.php",
            type: "POST",
            datatype: "json",
            data: formData,
            processData: false, // Evita que jQuery procese los datos del formulario
            contentType: false, // Evita que jQuery establezca el encabezado Content-Type
            beforeSend: function () {
              /* * Se ejecuta al inicio de la petición* */
              $("#loader").show();
            },
            success: function (response) {
              // Manejar la respuesta del servidor
              data = $.parseJSON(response);
              if (data == 1) {
                MostrarAlerta(
                  "Advertencia",
                  "El correo y/o email ya están registrados",
                  "error"
                );
              } else {
                $("#loader").hide();
                ResetForm("formperfil");
                MostrarAlerta("Hecho", "Se actualizaron sus datos.", "success");
                $("#modalUsu").modal("hide");
              }
            },
            error: function (xhr, status, error) {
              // Manejar errores de la petición AJAX
              console.error("Error: " + error);
            },
          });
        }
      });
    } else {
      alert("Por favor. Complete los campos requeridos");
    }
  });

  //Mostrar modal de cambio de foto de perfil
  $("#conf-foto").click(function () {
    $("#foto_perfil").css(
      "background-image",
      "url(../../public/" + $("#foto_user").val() + ")"
    );
    $("#modalfotop").modal({ backdrop: "static", keyboard: false });
  });

  //VISUALIZAR FOTO SELECCIONADA
  $("#idfilep").change(function (e) {
    // Obtenemos el archivo seleccionado
    let archivo = e.target.files[0];
    // Validamos si se seleccionó un archivo
    if (archivo) {
      // Validamos si el archivo es una imagen
      if (archivo.type.startsWith("image/")) {
        // Creamos un objeto FileReader para leer el archivo
        let lector = new FileReader();
        // Cuando se termina de leer el archivo
        lector.onload = function (e) {
          // Obtenemos la URL de la imagen
          let urlImagen = e.target.result;
          // Mostramos la imagen en el div de vista previa
          $("#foto_perfil").css("background-image", "url(" + urlImagen + ")");
        };
        // Leemos el archivo como una URL
        lector.readAsDataURL(archivo);
      } else {
        // El archivo seleccionado no es una imagen
        alert("Por favor, selecciona un archivo de imagen.");
      }
    }
  });
  //Accion para cambiar foto del usuario logeado
  $("#FormFotop").on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Cambiar la foto de su perfil",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Actualizar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "../../app/controllers/usuario-controller.php",
          data: new FormData(this),
          contentType: false,
          processData: false,
          beforeSend: function () {
            /* * Se ejecuta al inicio de la petición* */
            $("#loader").show();
          },
          success: function (msg) {
            console.log(msg);
            $("#loader").hide();
            MostrarAlerta(
              "Hecho",
              "Se hizo el cambio de la foto de perfil",
              "success"
            );
            $("#idfilep").val("");
            $("#modalfotop").modal("hide");
          },
          error: function (xhr, status, error) {
            // Manejar errores de la petición AJAX
            console.error("Error: " + error);
          },
        });
      }
    });
  });

  //Mostrar modal general de cambio de contraseña
  $("#conf-psw").click(function () {
    $("#modaleditpswG").modal({ backdrop: "static", keyboard: false });
  });

  //Enviar para cambiar contraseña del usuario logeado
  $("#form-psw").on("submit", function (e) {
    e.preventDefault();
    opcion = 6;
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      if ($("#inewcontra").val() === $("#iconfirmpsw").val()) {
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se hará el cambio de contraseña",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Actualizar",
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData(this);
            formData.append("opcion", opcion); // Agrega la variable  al objeto FormData
            formData.append("idusu", idusu); //
            $.ajax({
              url: "../../app/controllers/usuario-controller.php",
              type: "POST",
              datatype: "json",
              data: formData,
              processData: false, // Evita que jQuery procese los datos del formulario
              contentType: false, // Evita que jQuery establezca el encabezado Content-Type
              beforeSend: function () {
                /* * Se ejecuta al inicio de la petición* */
                $("#loader").show();
              },
              success: function (response) {
                data = $.parseJSON(response);
                if (data == 1) {
                  MostrarAlerta(
                    "Incorrecto",
                    "La contraseña actual ingresada es incorrecta",
                    "error"
                  );
                  $("#loader").hide();
                  $("#icontra").select();
                } else {
                  $("#modaleditpswG").modal("hide");
                  ResetForm("form-psw");
                  $("#error3").text("");
                  $("#loader").hide();
                  MostrarAlerta(
                    "Éxito",
                    "Se hizo el cambio de contraseña",
                    "success"
                  );
                }
              },
            });
          }
        });
      } else {
        alert("La contraseña nueva no coincide en la confirmación");
        $("#iconfirmpsw").select();
      }
    } else {
      alert("Por favor. Complete los campos obligatorios");
    }
  });
});

function datosUsuarioLogeado() {
  let opcion = 2;
  let idni = $("#dniuser").val();
  $.ajax({
    url: "../../app/controllers/empleado-controller.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion, idni: idni },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      nombres = data["nombres"] + " " + data["ap"] + " " + data["am"] + " ";
      $("#info-datos").text(nombres);
      $("#idareaid").val(data["IDArea"]);
      $("#info-area").val(data["Area"]);
      $("#info-area1").text(data["Area"]);
      $("#idinstitu").val(data["IDInst"]);
      $("#loader").hide();
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
      console.error("Error: " + error);
    },
  });
}

function salir() {
  window.location = "../../app/controllers/salir.php";
}

function validaNumericos(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  }
  return false;
}
function MostrarAlerta(mensaje, descripcion, tipoalerta) {
  Swal.fire(mensaje, descripcion, tipoalerta);
}

function verificarCampos(formulario) {
  let camposVacios = formulario.find("input[required]").filter(function () {
    return $.trim($(this).val()) === "";
  });

  return camposVacios.length === 0;
}

function ResetForm(id) {
  document.getElementById(id).reset();
}

function ValidarFormato(formato) {
  var archivo = document.getElementById("idfile").value;
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  if (extensiones != formato) {
    return false;
  } else {
    return true;
  }
}

function mostrarImagen() {
  var archivo = document.getElementById("idfilep").files[0];
  var lector = new FileReader();

  lector.onloadend = function () {
    var imagen = document.createElement("img");
    imagen.src = lector.result;
    imagen.style.width = "100%";
    imagen.style.height = "100%";

    var contenedor = document.getElementById("foto_perfil");
    contenedor.innerHTML = "";
    contenedor.appendChild(imagen);
  };

  if (archivo) {
    lector.readAsDataURL(archivo);
  }
}

function ResetForm(id) {
  document.getElementById(id).reset();
}