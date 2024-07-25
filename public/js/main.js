$(document).ready(function () {
  let idinst,
    idusu,
    idni,
    logo_bdr = 0;

  idusu = $("#iduser").val();
  idni = $("#dniuser").val();

  $("#loader").hide();

  // contarDocsGeneral(); //Muestra la cantidad de docs pendientes, aceptados y rechazados

  // contarDocsxArea();

  // ********************** ACCIONES GENERALES **********************
  // # DATOS INSTITUCION
  //Boton mostrar datos de Institucion general
  $("#conf-inst").click(function () {
    idinst = 1;
    $("#form_institucion")[0].reset();
    $.ajax({
      url: base_url + "/Institucion/getInstitucion/" + idinst,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idinstitucion").val(objData.data.idinstitucion);
          $("#ruc").val(objData.data.ruc);
          $("#razon").val(objData.data.razon);
          $("#instdirec").val(objData.data.direccion);
          $("#logo").css(
            "background-image",
            "url(" + base_url + "/public/" + objData.data.logo + ")"
          );

          $("#modal_inst").modal({ backdrop: "static", keyboard: false });
        } else {
          MostrarAlerta(objData.title, objData.msg, "error");
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

  //VISUALIZAR LOGO SELECCIONADO
  $("#input_logo").change(function (e) {
    let archivo = e.target.files[0];
    // Validamos si se seleccionó un archivo
    if (archivo) {
      const allowedTypes = ["image/jpeg", "image/png"];
      if (allowedTypes.includes(archivo.type)) {
        let lector = new FileReader();
        lector.onload = function (e) {
          let urlImagen = e.target.result;
          $("#logo").css("background-image", "url(" + urlImagen + ")");
          $("#bdr_logo").val("1");
        };
        lector.readAsDataURL(archivo);
      } else {
        MostrarAlerta(
          "Archivo no permitido",
          "Solo se permiten archivos JPG y PNG.",
          "error"
        );
        $("#input_logo").val("");
      }
    }
  });

  $("#logo").on("click", function () {
    $("#input_logo").click();
  });

  //Editar datos Institucion general
  $("#form_institucion").on("submit", function (e) {
    e.preventDefault();
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
          $("#bdr_logo").val() !== "0" ? (logo_bdr = 1) : (logo_bdr = 0);
          var formData = new FormData(this);
          formData.append("logo_bdr", logo_bdr);
          $.ajax({
            url: base_url + "/Institucion/setInstitucion",
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
              data = $.parseJSON(response);
              if (!data.status) {
                MostrarAlerta(data.title, data.msg, "error");
              } else {
                $("#form_institucion")[0].reset();
                MostrarAlertaxTiempo(data.title, data.msg, "success");
                $("#modal_inst").modal("hide");
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
    } else {
      MostrarAlerta(
        "Advertencia",
        "Por favor, completa los campos requeridos.",
        "error"
      );
    }
  });

  // # DATOS DEL PERFIL
  //Mostrar modal con datos de usuario logeado
  $("#conf-perfil").click(function () {
    $.ajax({
      url: base_url + "/Usuarios/getUsuario/" + idusu,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        console.log(response);
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idusuarioP").val(objData.data.idusuarios);
          $("#idpersonaP").val(objData.data.idpersona);
          $("#foto_perfilP").css(
            "background-image",
            "url(" + base_url + "/public/" + objData.data.foto + ")"
          );
          $("#idniP").val(objData.data.dni);
          $("#idniP").prop("readonly", true);

          $("#inombreP").val(objData.data.nombres);
          $("#iappatP").val(objData.data.ap);
          $("#iapmatP").val(objData.data.am);
          $("#icelP").val(objData.data.telefono);
          $("#idirP").val(objData.data.direccion);
          $("#iemailP").val(objData.data.email);
          $("#inomusuP").val(objData.data.nombre);
          $("#rolP").val(objData.data.rol);
          $("#bdr-photoP").val("0");
          $("#loader").hide();

          $("#modal_EditUser").modal({ backdrop: "static", keyboard: false });
        } else {
          MostrarAlerta(objData.title, objData.msg, "error");
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

  //VISUALIZAR LOGO SELECCIONADO
  $("#input_photoP").change(function (e) {
    let archivo = e.target.files[0];
    // Validamos si se seleccionó un archivo
    if (archivo) {
      const allowedTypes = ["image/jpeg", "image/png"];
      if (allowedTypes.includes(archivo.type)) {
        let lector = new FileReader();
        lector.onload = function (e) {
          let urlImagen = e.target.result;
          $("#foto_perfilP").css("background-image", "url(" + urlImagen + ")");
          $("#bdr-photoP").val("1");
        };
        lector.readAsDataURL(archivo);
      } else {
        MostrarAlerta(
          "Archivo no permitido",
          "Solo se permiten archivos JPG y PNG.",
          "error"
        );
        $("#input_photoP").val("");
      }
    }
  });

  $("#foto_perfilP").on("click", function () {
    $("#input_photoP").click();
  });

  //Editar los datos de usuario logeado
  $("#form_EditUser").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Editar sus datos de usuario",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Editar",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#bdr-photoP").val() !== "0" ? (foto_bdr = 1) : (foto_bdr = 0);
          console.log(foto_bdr);
          let formData = new FormData(this);
          formData.append("foto_bdr", foto_bdr);
          $.ajax({
            url: base_url + "/Usuarios/setPerfil",
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
              data = $.parseJSON(response);
              if (!data.status) {
                MostrarAlerta(data.title, data.msg, "error");
              } else {
                $("#form_EditUser")[0].reset();
                MostrarAlertaxTiempo(data.title, data.msg, "success");
                $("#modal_EditUser").modal("hide");
              }
              $("#loader").hide();
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al editar los datos", "error");
              console.error("Error: " + error);
              $("#loader").hide();
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

  //Mostrar modal general de cambio de contraseña
  $("#conf-psw").click(function () {
    $("#idusuarioC").val(idusu);
    $(".aviso").text("");
    $(".description").empty();
    $(".tituloPsw").text("CAMBIAR CONTRASEÑA DEL PERFIL");
    $("#modal_edit_psw").modal({ backdrop: "static", keyboard: false });
  });

  // Validar similitud de ingreso de contraseñas
  $("#iconfirmpswU").blur(function () {
    if ($("#inewcontraU").val().length < 8) {
      $("#ErrorContraU")
        .text("Debe tener al menos 8 caracteres")
        .css("color", "red");
    } else if ($(this).val() === $("#inewcontraU").val()) {
      $("#ErrorContraU")
        .text("Las contraseñas coinciden")
        .css("color", "green");
    } else {
      $("#ErrorContraU")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  $("#inewcontraU").blur(function () {
    if ($("#inewcontraU").val().length < 8) {
      $("#ErrorContraU")
        .text("Debe tener al menos 8 caracteres")
        .css("color", "red");
    } else if ($(this).val() === $("#iconfirmpswU").val()) {
      $("#ErrorContraU")
        .text("Las contraseñas coinciden")
        .css("color", "green");
    } else {
      $("#ErrorContraU")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  //Enviar para cambiar contraseña del usuario logeado
  $("#form_edit_psw").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      if ($("#inewcontraU").val() === $("#iconfirmpswU").val()) {
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
            $.ajax({
              url: base_url + "/Usuarios/putPasswordUser",
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
                data = $.parseJSON(response);
                if (!data.status) {
                  MostrarAlerta(data.title, data.msg, "error");
                } else {
                  $("#form_edit_psw")[0].reset();
                  $("#modal_edit_psw").modal("hide");
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
      } else {
        MostrarAlerta(
          "Advertencia",
          "No ingreso contraseñas que coincidan.",
          "error"
        );
        $("#iconfirmpswU").select();
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

function resetHidden(form) {
  form[0].reset();
  form.find("input[type=hidden]").each(function () {
    $(this).val("0");
  });
}
