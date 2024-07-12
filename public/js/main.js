$(document).ready(function () {
  let idusu, idni, opcion;

  idusu = $("#iduser").val();
  idni = $("#dniuser").val();

  $("#loader").hide(); // Ocultar DIv de carga

  // contarDocsGeneral(); //Muestra la cantidad de docs pendientes, aceptados y rechazados

  // contarDocsxArea();

  // ********************** ACCIONES GENERALES **********************
  //Boton mostrar datos de Institucion general
  $("#conf-inst").click(function () {
    opcion = 1;
    $.ajax({
      url: "../../app/controllers/InstitucionController.php.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        $("#loader").hide();
        $("#idinst").val(data["idinstitucion"]);
        $("#iruci").val(data["ruc"]);
        $("#irazoni").val(data["razon"]);
        $("#idirei").val(data["dirección"]);
        $("#modalinstitu").modal({ backdrop: "static", keyboard: false });
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
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
            url: "../../app/controllers/InstitucionController.php.php",
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
                MostrarAlertaxTiempo(
                  "Hecho",
                  "Se actualizaron sus datos.",
                  "success"
                );
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
      MostrarAlerta(
        "Advertencia",
        "Por favor, completa los campos requeridos.",
        "error"
      );
    }
  });

  //Mostrar modal con datos de usuario logeado
  $("#conf-perfil").click(function () {
    opcion = 2;
    idusu = $("#iduser").val();
    idni = $("#dniuser").val();
    $.ajax({
      url: "../../app/controllers/UsuarioController.php.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, idusu: idusu, idni: idni },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
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
        $("#estadop").val(data["estado"]);
        $("#loader").hide();

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
            url: "../../app/controllers/UsuarioController.php.php",
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
                $("#loader").hide();
              } else {
                $("#loader").hide();
                ResetForm("formperfil");
                MostrarAlertaxTiempo(
                  "Hecho",
                  "Se actualizaron sus datos.",
                  "success"
                );
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
      MostrarAlerta(
        "Advertencia",
        "Por favor, complete todos los campos requeridos.",
        "error"
      );
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
        MostrarAlerta(
          "Advertencia",
          "Por favor, selecciona un archivo de imagen.",
          "error"
        );
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
          url: "../../app/controllers/UsuarioController.php.php",
          data: new FormData(this),
          contentType: false,
          processData: false,
          beforeSend: function () {
            /* * Se ejecuta al inicio de la petición* */
            $("#loader").show();
          },
          success: function (msg) {
            $("#loader").hide();
            MostrarAlertaxTiempo(
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

  $("#iconfirmpsw").blur(function () {
    //Validacion de contraseña
    if ($("#iconfirmpsw").val().length < 8) {
      $("#ErrorContraG").text("").css("color", "red");
    } else if ($(this).val() === $("#inewcontra").val()) {
      $("#ErrorContraG")
        .text("Las contraseñas coinciden")
        .css("color", "green");
    } else {
      $("#ErrorContraG")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  $("#inewcontra").blur(function () {
    //Validacion de contraseña
    if ($("#iconfirmpsw").val().length < 8) {
      $("#ErrorContraG").text("").css("color", "red");
    } else if ($(this).val() === $("#iconfirmpsw").val()) {
      $("#ErrorContraG")
        .text("Las contraseñas coinciden")
        .css("color", "green");
    } else {
      $("#ErrorContraG")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
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
              url: "../../app/controllers/UsuarioController.php.php",
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
                  MostrarAlertaxTiempo(
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
        MostrarAlerta(
          "Advertencia",
          "No ingreso contraseñas que coincidan.",
          "error"
        );
        $("#iconfirmpsw").select();
      }
    } else {
      MostrarAlerta(
        "Advertencia",
        "Por favor, complete todos los campos requeridos.",
        "error"
      );
    }
  });

  //*************** ACCIONES PARA MOSTRAR MAS INFORMACION DEL TRAMITE ***************

  //Mostrar mas informacion del tramite
  $(document).on("click", ".btnMas", function () {
    opcion = 3;
    expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente
    console.log("Presionaste esto");
    $.ajax({
      url: "../../app/controllers/TramiteController.php.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, expediente: expediente },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        if (data.length > 0) {
          // $("#div_iframePDF").show();
          // $("#loaderPDF").hide();
          // $("#error-message").hide();

          $("#iddoc").val(data[0]["iddocumento"]);
          $("#inrodoc").val(data[0]["nro_doc"]);
          $("#ifolio").val(data[0]["folios"]);
          $("#iexpediente").val(data[0]["nro_expediente"]);
          $("#iestad").val(data[0]["estado"]);
          $("#itipodoc").val(data[0]["tipodoc"]);
          $("#iasunt").val(data[0]["asunto"]);
          $("#iddni1").val(data[0]["dni"]);
          $("#idremi").val(data[0]["Datos"]);

          $("#iruc").val(data[0]["ruc_institu"]);
          $("#iinsti").val(data[0]["institucion"]);

          archivo = data[0]["archivo"];

          $("#iframePDF").attr("src", "../../public/" + archivo);

          // $("#iframePDF").on("load", function () {
          //   $("#div_iframePDF").hide();
          //   $("#loaderPDF").show();
          //   $("#error-message").hide();
          // });

          // $("#iframePDF").on("error", function () {
          //   $("#div_iframePDF").hide();
          //   $("#loaderPDF").hide();
          //   $("#error-message").show();
          // });

          ruc = data[0]["ruc_institu"];

          if (ruc == null || ruc == "" || ruc == " " || ruc == "  ") {
            $("#radio_natural").prop("checked", true);
          } else {
            $("#radio_juridica").prop("checked", true);
          }

          ResetModalMas(); //Solo mostrar los divs necesarios

          $("#modalmas").modal({ backdrop: "static", keyboard: false });
          $("#loader").hide();
        }
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  });

  //Redirige a una nueva pestaña para ver el PDF
  $("#btn_NuevoPDF").click(function () {
    $(this).attr("href", "../../public/" + archivo);
    $(this).find("img").attr("src", "../images/inst/logo.png");
  });

  //CERRAR MODAL y resetear valores
  $("#btnCerrarMas").click(function () {
    $("#modalmas").modal("hide");
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").removeClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#NuevoPDF").hide();
    $("#iframePDF").attr("src", "");
    $("#radio_natural").prop("checked", false);
    $("#radio_juridica").prop("checked", false);
    ruc = "";
    archivo = "";
  });

  // VALIDACION PARA MOSTRAR U OCULTAR ELEMENTOS DEL MODAL
  $("#btn_tramite").click(function () {
    $("#btn_remitente").addClass("btn btn-light");
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  });
  $("#btn_remitente").click(function () {
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#btn_tramite").addClass("btn btn-light");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").hide();
    $("#div_remitente").show();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  });
  $("#btn_vistaprevia").click(function () {
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-light");
    $(this).removeClass("btn btn-light");
    $(this).addClass("btn btn-primary");
    $("#div_tramite").hide();
    $("#div_remitente").hide();
    $("#div_vistaprevia").show();
    $("#btn_NuevoPDF").show();
  });

  function ResetModalMas() {
    $("#btn_remitente").addClass("btn btn-light");
    $("#btn_tramite").removeClass("btn btn-light");
    $("#btn_tramite").addClass("btn btn-primary");
    $("#btn_vistaprevia").addClass("btn btn-light");
    $("#div_tramite").show();
    $("#div_remitente").hide();
    $("#div_vistaprevia").hide();
    $("#btn_NuevoPDF").hide();
  }

  //*************** ACCIONES PARA MOSTRAR TABLA SEGUIMIENTO DEL TRAMITE ***************
  //Mostrar tabla de seguimienton del tramite
  $(document).on("click", ".btnSeguimiento", function () {
    opcion = 3;
    expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente
    $("#p_expediente").text(expediente);
    $("#modal_historial").modal("show");

    tablaSeguimiento = $("#tablaSeguimiento").DataTable({
      destroy: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      },
      ajax: {
        url: "../../app/controllers/TramiteController.php.php",
        method: "POST", //usamos el metodo POST
        data: { opcion: opcion, expediente: expediente },
        dataSrc: "",
      },
      columns: [
        { data: "ID" },
        { data: "Fecha" },
        { data: "area" },
        { data: "descripcion" },
      ],
    });
  });
});

function datosUsuarioLogeado(callback) {
  let opcion = 3;
  let idni = $("#dniuser").val();
  $.ajax({
    url: "../../app/controllers/EmpleadoController.php.php",
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
      $("#id_areaid").val(data["IDArea"]);
      $("#info-area").val(data["Area"]);
      $("#info-area-desc").text(data["Area"]);
      $("#info-area1").text(data["Area"]);
      $("#idinstitu").val(data["IDInst"]);
      $("#loader").hide();
      callback(); // llamar a la funcion despues de cargar los datos
      datosCargados = true;
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
      console.error("Error: " + error);
    },
  });
}
function contarDocsxArea() {
  let opcion = 2;
  let idubicacion = $("#id_areaid").val();
  $.ajax({
    url: "../../app/controllers/DocumentoController.php.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion, idubicacion: idubicacion },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      $("#span_cant_rechazados_area").text(data["cantidad_rechazado_area"]);
      $("#span_cant_pendientes_area").text(data["cantidad_pendiente_area"]);
      $("#span_cant_aceptados_area").text(data["cantidad_aceptado_area"]);
      $("#loader").hide();
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
      console.error("Error: " + error);
    },
  });
}
function contarDocsGeneral() {
  let opcion = 1;
  $.ajax({
    url: base_url + "/app/controllers/DocumentoController.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      console.log(response);
      data = $.parseJSON(response);
      $("#span_cant_rechazados").text(data["cantidad_rechazado"]);
      $("#span_cant_pendientes").text(data["cantidad_pendiente"]);
      $("#span_cant_aceptados").text(data["cantidad_aceptado"]);
      $("#loader").hide();
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
      console.error("Error: " + error);
    },
  });
}
function cargarDatosInstitucion() {
  opcion = 1;
  $.ajax({
    url: "../../app/controllers/InstitucionController.php.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      $("#loader").hide();
      $("#inst_logo").attr("src", "../../public/" + data[0]["logo"]);
      $("#inst_footer").text(data[0]["razon"]);
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
      console.error("Error: " + error);
    },
  });
}
function validaNumericos(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  }
  return false;
}
function MostrarAlerta(titulo, descripcion, tipoalerta) {
  Swal.fire(titulo, descripcion, tipoalerta);
}
function MostrarAlertaxTiempo(titulo, descripcion, tipoalerta) {
  Swal.fire({
    title: titulo,
    text: descripcion,
    icon: tipoalerta,
    showConfirmButton: false,
    timer: 2000,
  });
}

function verificarCampos(formulario) {
  let camposVacios = formulario.find("input[required]").filter(function () {
    return $.trim($(this).val()) === "";
  });

  return camposVacios.length === 0;
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

