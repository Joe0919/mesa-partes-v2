document.addEventListener("DOMContentLoaded", function () {
  // Selecciona el botón del menú y el sidebar
  const pushMenuButton = document.querySelector('[data-widget="pushmenu"]');
  const sidebar = document.querySelector(".main-sidebar");

  // Añade un evento de clic al botón
  pushMenuButton.addEventListener("click", function (e) {
    e.preventDefault();

    // Alterna la clase d-none en el sidebar
    if (sidebar.classList.contains("d-none")) {
      sidebar.classList.remove("d-none");
    } else {
      sidebar.classList.add("d-none");
    }
  });
});

$(function () {
  let idinst,
    idusu,
    idni,
    idarea,
    idusuario,
    logo_bdr = 0,
    expediente = "",
    area = "",
    controlador = "",
    tabla = "",
    estado,
    iddocumento,
    dni,
    descripcion,
    idBoton;

  idusu = $("#iduser").val();
  idni = $("#dniuser").val();
  idarea = $("#id_areaid").val();
  idusuario = $("#iduser").val();

  $("#loader").hide();

  if (modulo == 6) {
    controlador = "tramites";
    tabla = "tablaTramites";
  } else if (modulo == 8) {
    controlador = "tramites-recibidos";
    tabla = "tablaTramitesRecibidos";
  } else if (modulo == 9) {
    controlador = "tramites-enviados";
  }

  // ********************** ACCIONES GENERALES **********************
  // # **************************** DATOS INSTITUCION ****************************
  //Boton mostrar datos de Institucion general
  $("#conf-inst").click(function () {
    idinst = 1;
    $("#form_institucion")[0].reset();
    eliminarValidacion("#form_institucion");
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

  //Accion al presionar el logo
  $("#logo").on("click", function () {
    $("#input_logo").click();
  });

  validarCamposRequeridos("#form_institucion");

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

  // # **************************** DATOS DEL PERFIL ****************************
  //Mostrar modal con datos de usuario logeado
  $("#conf-perfil").click(function () {
    $.ajax({
      url: base_url + "/Usuarios/getUsuarioPerfil/" + idusu,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
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
          eliminarValidacion("#form_EditUser");
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

  validarCamposRequeridos("#form_EditUser");

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
    eliminarValidacion("#form_edit_psw");
  });

  //Mostrar/Ocultar contraseña En General
  $(".toggle-password").click(function () {
    // Encuentra el input más cercano
    const passwordInput = $(this)
      .closest(".form-group")
      .find('input[type="password"], input[type="text"]');
    const eyeIcon = $(this).find("i");

    // Alternar el tipo de input entre password y text
    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text");
      eyeIcon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
      passwordInput.attr("type", "password");
      eyeIcon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
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

  validarCamposRequeridos("#form_edit_psw");

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

  //*************** ACCIONES PARA ACEPTAR Y DERIVAR EL TRAMITE ***************

  //Abrir Modal para Aceptar o Rechazar el Trámite
  $(document).on("click", ".btnAceptar", function () {
    //Validamos que el documento tenga el estado pendiente
    if ($.trim($(this).closest("tr").find("td:eq(6)").text()) !== "PENDIENTE") {
      MostrarAlerta(
        "Advertencia",
        "No es posible realizar esta accion....",
        "error"
      );
    } else {
      area = $(this).closest("tr").find("td:eq(5)").text();
      expediente = $(this).closest("tr").find("td:eq(0)").text();
      dni = $(this).closest("tr").find("td:eq(2)").text();
      $("#idnir").val(dni);
      $("#modal-title").text("ACEPTAR/RECHAZAR TRÁMITE N°: " + expediente);
      $.ajax({
        url: base_url + "/" + controlador + "/getTramite/" + expediente,
        type: "GET",
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          objData = $.parseJSON(response);
          if (objData.status) {
            $("#idderivacion").val(objData.data.idderivacion);
            $("#iddocumento").val(objData.data.iddocumento);
            $("#inrodoc_1").val(objData.data.nro_doc);
            $("#ifolio_1").val(objData.data.folios);
            $("#iexpediente_1").val(objData.data.nro_expediente);
            $("#iestado_1").val(objData.data.estado);
            $("#itipodoc_1").val(objData.data.tipodoc);
            $("#iasunto_1").val(objData.data.asunto);
            $("#modal_aceptacion").modal({
              backdrop: "static",
              keyboard: false,
            });
            $("#loader").hide();
          }
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          $("#loader").hide();
        },
      });
    }
  });

  //Cambiar el color del boton Observar/Rechazar y el valor del input
  $(".dropdown-item").on("click", function () {
    var action = $(this).data("action");
    var colorClass = $(this).data("color");
    var value = $(this).data("value");

    $("#btnObservarRechazarDoc").text(action);

    $("#btnObservarRechazarDoc")
      .removeClass("btn-danger btn-info")
      .addClass("btn-" + colorClass);
    $("#btnObservarRechazarDoc")
      .next(".dropdown-toggle")
      .removeClass("btn-danger btn-info")
      .addClass("btn-" + colorClass);
  });

  //Realizar Accion de ACEPTAR , OBSERVAR o RECHAZAR el Tramite sea el Caso
  $(".btnGestion").click(function () {
    idBoton = $(this).attr("id");

    descripcion = $.trim($("#idescripcion").val().toUpperCase());
    iddocumento = $("#iddocumento").val();
    expediente = $("#iexpediente_1").val();
    idni = $("#idnir").val();
    idderivacion = $("#idderivacion").val();

    idBoton === "btnAceptarDoc"
      ? (accion = "ACEPTAR")
      : $(".dropdown-item").data("action") == "Rechazar"
      ? (accion = "RECHAZAR")
      : (accion = "OBSERVAR");

    if (
      (accion === "OBSERVAR" || accion === "RECHAZAR") &&
      $("#idescripcion").val().trim() === ""
    ) {
      MostrarAlerta(
        "Advertencia",
        "Ingrese una descripción por la cual realiza este acción",
        "error"
      );
      $("#idescripcion").val("");
      $("#idescripcion").focus();
    } else {
      Swal.fire({
        title: "¿Está seguro?",
        text: `Al ${accion} el documento no podrá deshacer la acción`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + "/Tramites/putTramiteAceptacion",
            type: "POST",
            datatype: "json",
            data: {
              origen: area,
              descripcion: descripcion,
              iddocumento: iddocumento,
              expediente: expediente,
              dni: dni,
              idderivacion: idderivacion,
              accion: accion,
              idusuario: idusuario,
            },
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              console.log(response);
              objData = $.parseJSON(response);
              if (objData.status) {
                $("#form_aceptacion")[0].reset();
                $("#modal_aceptacion").modal("hide");
                inicializarTablaTramites(tabla, controlador);
                MostrarAlertaxTiempo(objData.title, objData.msg, "success");
              } else {
                MostrarAlerta(
                  "Error",
                  "Hubo problemas al realizar la accion",
                  "error"
                );
              }
              $("#loader").hide();
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al realizar accion.", "error");
              $("#loader").hide();
              console.error("Error: " + error);
            },
          });
        }
      });
    }
  });

  //Mostrar modal para Derivar o Archivar
  $(document).on("click", ".btnDerivar", function () {
    if ($.trim($(this).closest("tr").find("td:eq(6)").text()) !== "ACEPTADO") {
      //El documento tiene otro estado
      MostrarAlerta(
        "Advertencia",
        "No es posible realizar esta accion",
        "error"
      );
    } else {
      expediente = $(this).closest("tr").find("td:eq(0)").text();
      dni = $(this).closest("tr").find("td:eq(2)").text(); //Tomar DNI del Remitente
      area = $(this).closest("tr").find("td:eq(5)").text();
      llenarSelectDestino(area);
      $("#expediente_d").val(expediente);
      $("#dni_d").val(dni);
      $("#idorigen").val($(this).closest("tr").find("td:eq(5)").text());
      $("#p_expediente_d").text(expediente);
      $("#modal_derivacion").modal("show");
      $("#select-destino").attr("required", "required");
    }
  });

  //Ocultar Areas destino al solo ARCHIVAR
  $("#idaccion").change(function () {
    let sel = $(this).val();
    if (sel == "2") {
      $("#column").hide();
      $("#btnEnviarDerivacion").text("Archivar");
      $("#select-destino").removeAttr("required");
    } else {
      $("#column").show();
      $("#btnEnviarDerivacion").text("Derivar");
      $("#select-destino").attr("required", "required");
    }
  });

  //Derivar o Archivar el Trámite
  $("#form_derivacion").on("submit", function (e) {
    e.preventDefault();
    accion = $("#idaccion").val();
    destino = $("#select-destino option:selected").text();
    origen = $("#idorigen").val();
    dni = $("#dni_d").val();
    let formulario = $(this);
    let aux, titulo;
    accion === "1"
      ? ((aux = "DERIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> al área <b>${destino}</b>.`))
      : ((aux = "ARCHIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> en el area <b>${origen}</b>.`));
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: titulo,
        html: html,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          var formData = new FormData(this);
          formData.append("accion", accion);
          formData.append("destino", destino);
          formData.append("dni", dni);
          formData.append("idusuario", idusuario);
          $.ajax({
            url: base_url + "/Tramites/putTramiteDerivacion",
            type: "POST",
            datatype: "json",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              objData = $.parseJSON(response);
              if (objData.status) {
                $("#form_derivacion")[0].reset();
                $("#modal_derivacion").modal("hide");
                inicializarTablaTramites(tabla, controlador);
                MostrarAlertaxTiempo(objData.title, objData.msg, "success");
              } else {
                MostrarAlerta(
                  "Error",
                  "Hubo problemas al realizar la accion",
                  "error"
                );
              }
              $("#loader").hide();
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al realizar accion.", "error");
              $("#loader").hide();
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

  //*************** ACCIONES PARA MOSTRAR MAS INFORMACION DEL TRAMITE ***************

  //Mostrar mas informacion del tramite
  $(document).on("click", ".btnMas", function () {
    expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente
    $("#n_tramite").text("TRÁMITE N° " + expediente);
    $.ajax({
      url: base_url + "/Tramites/getTramite/" + expediente,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#div_iframePDF").show();
          $("#loaderPDF").hide();
          $("#error-message").hide();

          $("#iddoc").val(objData.data.iddocumento);
          $("#inrodoc").val(objData.data.nro_doc);
          $("#ifolio").val(objData.data.folios);
          $("#iexpediente").val(objData.data.nro_expediente);
          $("#iestad").val(objData.data.estado);
          $("#itipodoc").val(objData.data.tipodoc);
          $("#iasunt").val(objData.data.asunto);
          $("#iddni1").val(objData.data.dni);
          $("#idremi").val(objData.data.Datos);

          $("#iruc").val(objData.data.ruc_institu);
          $("#iinsti").val(objData.data.institucion);

          archivo = objData.data.archivo;

          $("#iframePDF").attr("src", base_url + "/public/" + archivo);

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

          ruc = objData.data.ruc_institu;

          if (ruc == null || ruc == "" || ruc == " " || ruc == "  ") {
            $("#radio_natural").prop("checked", true);
          } else {
            $("#radio_juridica").prop("checked", true);
          }

          ResetModalMas(); //Solo mostrar los divs necesarios

          $("#modalmas").modal({ backdrop: "static", keyboard: false });
          $("#loader").hide();
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

  //Redirige a una nueva pestaña para ver el PDF
  $("#btn_NuevoPDF").click(function () {
    $(this).attr("href", base_url + "/public/" + archivo);
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
    expediente = $(this).closest("tr").find("td:eq(0)").text();
    $("#title_historial").text("HISTORIAL DEL TRAMITE N° " + expediente);

    tablaSeguimiento = $("#tablaSeguimiento").DataTable({
      destroy: true,
      language: {
        url: "Spanish.json",
      },
      ajax: {
        url: base_url + "/" + controlador + "/getHistorial/" + expediente,
        method: "GET",
        dataSrc: "",
      },
      ordering: false,
      columns: [
        { data: "accion" },
        { data: "fecha" },
        { data: "area" },
        { data: "descrip" },
      ],
    });

    $("#modal_historial").modal("show");
  });
});

//******************** FUNCIONES *******************

//Llenar el Select Con Areas distintas al actual
function llenarSelectDestino(area) {
  $.ajax({
    url: base_url + "/Tramites/getSelectDestino",
    type: "POST",
    datatype: "json",
    data: { area: area },
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      let select = $("#select-destino");
      select.empty();
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione destino...");
      placeholderOption.attr("disabled", true);
      placeholderOption.attr("selected", true);
      select.append(placeholderOption);
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].ID);
        option.text(data[i].area);
        select.append(option);
      }
      $("#loader").hide();
    },
    error: function (error) {
      MostrarAlerta("Error", "Error al llenar áreas destino", "error");
      console.error("Error: " + error);
      $("#loader").hide();
    },
  });
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
