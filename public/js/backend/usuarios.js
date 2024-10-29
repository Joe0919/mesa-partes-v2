$(function () {
  let idusuario = 0,
    accion = "",
    foto_bdr = 0,
    dni = "",
    user = "";

  const defaultImageUrl = base_url + "/public/files/images/0/user.png";

  $("#loader").show();

  /*=============================   MOSTRAR TABLA DE USUARIOS  ================================= */
  tablaUsuarios = $("#tablaUsuarios").DataTable({
    destroy: true,
    language: {
      url: "Spanish.json",
    },
    ajax: {
      url: base_url + "/Usuarios/getUsuarios",
      dataSrc: "",
    },
    ordering: false,
    columns: [
      { data: "idusuarios" },
      { data: "dni" },
      { data: "datos" },
      { data: "email" },
      { data: "telefono" },
      { data: "rol" },
      { data: "estado" },
      { data: "opciones" },
    ],
    initComplete: function () {
      $("#loader").hide();
    },
  });

  setTimeout(() => {
    llenarSelectRol();
  }, 200);


  $("#btn_reload").click(function () {
    tablaUsuarios.ajax.reload(null, false);
  });

  //Mostrar modal de nuevo usuario
  $("#btn_new_user").click(function () {
    idusu = null;
    $("#foto_perfilf").css("background-image", "url(" + defaultImageUrl + ")");
    $("#bdr-photo").val("0");
    openModal("new");
    accion = "guardarán";
    $("#idni").prop("readonly", false);
    $(".aviso").text("");
    eliminarValidacion("#form_user");
  });

  //Visualizar Foto Seleccionada
  $("#input_photo").change(function (e) {
    let archivo = e.target.files[0];
    // Validamos si se seleccionó un archivo
    if (archivo) {
      const allowedTypes = ["image/jpeg", "image/png"];
      if (allowedTypes.includes(archivo.type)) {
        // Creamos un objeto FileReader para leer el archivo
        let lector = new FileReader();
        // Cuando se termina de leer el archivo
        lector.onload = function (e) {
          // Obtenemos la URL de la imagen
          let urlImagen = e.target.result;
          // Mostramos la imagen en el div de vista previa
          $("#foto_perfilf").css("background-image", "url(" + urlImagen + ")");
          $("#bdr-photo").val("1");
        };
        // Leemos el archivo como una URL
        lector.readAsDataURL(archivo);
      } else {
        MostrarAlerta(
          "Archivo no permitido",
          "Solo se permiten archivos JPG y PNG.",
          "error"
        );
        $("#input_photo").val("");
      }
    }
  });

  //Validar Campos requeridos y Cambiar Clases
  validarCamposRequeridos("#form_user");

  //Registrar o editar los datos del usuario
  $("#form_user").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (validarCampos(formulario)) {
      if ($("#ipassco").val() !== $("#ipass").val()) {
        MostrarAlerta(
          "Advertencia",
          "No ingreso contraseñas que coincidan.",
          "error"
        );
      } else {
        Swal.fire({
          title: "¿Estás seguro?",
          text: `Se ${accion} los datos del nuevo usuario`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Guardar",
        }).then((result) => {
          if (result.isConfirmed) {
            $("#checkEstado").is(":checked")
              ? $("#iestado").val("ACTIVO")
              : $("#iestado").val("INACTIVO");
            $("#bdr-photo").val() !== "0" ? (foto_bdr = 1) : (foto_bdr = 0);
            let formData = new FormData(this);
            formData.append("foto_bdr", foto_bdr);
            $.ajax({
              url: base_url + "/Usuarios/setUsuario",
              type: "POST",
              datatype: "json",
              data: formData,
              processData: false,
              contentType: false,
              beforeSend: function () {
                $("#loader").show();
              },
              success: function (response) {
                data = JSON.parse(response);
                if (!data.status) {
                  MostrarAlerta(data.title, data.msg, "error");
                  console.error(data.error);
                } else {
                  $("#form_user")[0].reset();
                  tablaUsuarios.ajax.reload(null, false);
                  MostrarAlertaxTiempo(data.title, data.msg, "success");
                  $("#modal_user").modal("hide");
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
      }
    } else {
      MostrarAlerta(
        "Advertencia",
        "Por favor, complete todos los campos requeridos.",
        "error"
      );
    }
  });

  /* =============================   ACCIONES BOTONES EN TABLA  ================================= */

  //Mostrar datos de usuario para edicion
  $(document).on("click", ".btnEditar", function () {
    idusuario = parseInt($(this).closest("tr").find("td:eq(0)").text());
    accion = "editarán";
    $.ajax({
      url: base_url + "/Usuarios/getUsuario/" + idusuario,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = JSON.parse(response);
        if (objData.status) {
          openModal("edit");
          $("#idusuario").val(objData.data.idusuarios);
          $("#idpersona").val(objData.data.idpersona);
          $("#foto_perfilf").css(
            "background-image",
            "url(" + base_url + "/public/" + objData.data.foto + ")"
          );
          $("#idni").val(objData.data.dni);
          $("#idni").prop("readonly", true);

          $("#inombre").val(objData.data.nombres);
          $("#iappat").val(objData.data.ap);
          $("#iapmat").val(objData.data.am);
          $("#icel").val(objData.data.telefono);
          $("#idir").val(objData.data.direccion);
          $("#iemail").val(objData.data.email);
          $("#inomusu").val(objData.data.nombre);
          $("#select-rol").val(objData.data.idroles);
          $("#bdr-photo").val("0");
          if (objData.data.estado == "ACTIVO") {
            $("#checkEstado").prop("checked", true);
            $("#label-estado").text("ACTIVO").css("color", "green");
            $("#estado").val(objData.data.estado);
          } else {
            $("#checkEstado").prop("checked", false);
            $("#label-estado").text("INACTIVO").css("color", "gray");
            $("#estado").val(objData.data.estado);
          }
          $("#loader").hide();
          eliminarValidacion("#form_edit_user");
          $("#modal_edit_user").modal({ backdrop: "static", keyboard: false });
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

  //Mostrar modal cambio de contraseña
  $(document).on("click", ".btnPsw", function () {
    $("#form_edit_psw")[0].reset();
    idusuario = $(this).closest("tr").find("td:eq(0)").text();
    dni = $(this).closest("tr").find("td:eq(1)").text();
    user = $(this).closest("tr").find("td:eq(2)").text();
    $(".description").empty();
    $(".description").html(
      '<p class="mb-2">Usuario: <b id="span-user">' +
        user +
        '</b> con DNI: <b id="span-dni">' +
        dni +
        "</b></p>"
    );
    $("#idusuarioC").val(idusuario);
    $(".tituloPsw").text("CAMBIAR CONTRASEÑA DEL USUARIO");
    $(".aviso").text("");
    eliminarValidacion("#form_edit_psw");
    $("#modal_edit_psw").modal({ backdrop: "static", keyboard: false });
  });

  //Actualizar la contraseña del usuario en tabla
  $("#form_edit_psw").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (validarCampos(formulario)) {
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
                data = JSON.parse(response);
                if (!data.status) {
                  MostrarAlerta(data.title, data.msg, "error");
                  console.error(data.error);
                } else {
                  $("#form_edit_psw")[0].reset();
                  MostrarAlertaxTiempo(data.title, data.msg, "success");
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

  //Borrar usuario
  $(document).on("click", ".btnBorrar", function () {
    dni = parseInt($(this).closest("tr").find("td:eq(1)").text());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará al Usuario",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "" + base_url + "/Usuarios/delUser",
          type: "POST",
          datatype: "json",
          data: { dni: dni },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            data = JSON.parse(response);
            if (data.status) {
              MostrarAlertaxTiempo(data.title, data.msg, "success");
              tablaUsuarios.ajax.reload(null, false);
            } else {
              MostrarAlertaxTiempo(data.title, data.msg, "error");
            }
            $("#loader").hide();
          },
          error: function (error) {
            MostrarAlerta("Error", "Error al eliminar", "error");
            console.error("Error: " + error);
            $("#loader").hide();
          },
        });
      }
    });
  });

  /* =============================   VALIDACIONES DE CAMPOS  ================================= */

  //Validar Formato de Email
  $("#iemail").blur(function () {
    let iemail = $.trim($(this).val());
    if (iemail.length == 0) {
      $("#ErrorEmail").text("").css("color", "red");
    } else {
      !ValidarCorreo(iemail)
        ? $("#ErrorEmail")
            .text("Formato de Email incorrecto")
            .css("color", "red")
        : $("#ErrorEmail").text("").css("color", "green");
    }
  });

  //Autogenerar Nombre de Usuario
  $("#inomusu").focus(function () {
    if (
      $("#idni").val().trim() !== "" &&
      $("#inombre").val().trim() !== "" &&
      $("#iappat").val().trim() !== "" &&
      $("#iapmat").val().trim() !== ""
    ) {
      $(this).val(
        generarNombreUsuario(
          $("#inombre").val(),
          $("#iapmat").val(),
          $("#iappat").val(),
          $("#idni").val()
        )
      );
    }
  });

  // Validar similitud de ingreso de contraseñas
  $("#ipass").blur(function () {
    //Validacion de contraseña
    if ($("#ipassco").val().length < 8) {
      $("#ErrorContra")
        .text("Debe tener al menos 8 caracteres")
        .css("color", "red");
    } else if ($(this).val() === $("#ipassco").val()) {
      $("#ErrorContra").text("Las contraseñas coinciden").css("color", "green");
    } else {
      $("#ErrorContra")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  $("#ipassco").blur(function () {
    //Validacion de contraseña
    if ($("#ipassco").val().length < 8) {
      $("#ErrorContra")
        .text("Debe tener al menos 8 caracteres")
        .css("color", "red");
    } else if ($(this).val() === $("#ipass").val()) {
      $("#ErrorContra").text("Las contraseñas coinciden").css("color", "green");
    } else {
      $("#ErrorContra")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });
  //CAmbiar color y texto de estado
  $("#checkEstado").change(function () {
    if ($(this).is(":checked")) {
      $("#label-estado").text("ACTIVO").css("color", "green");
      $("#estadoE").val("ACTIVO");
    } else {
      $("#label-estado").text("INACTIVO").css("color", "gray");
      $("#estadoE").val("INACTIVO");
    }
  });

  //Ejecutar Evento input file
  $("#foto_perfilf").on("click", function () {
    $("#input_photo").click();
  });
});

function llenarSelectRol() {
  $.ajax({
    url: base_url + "/Roles/getSelectRoles",
    type: "GET",
    datatype: "json",
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      data = JSON.parse(response);
      let select = $("#select-rol");
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione rol...");
      placeholderOption.attr("disabled", true);
      placeholderOption.attr("selected", true);
      select.append(placeholderOption);
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].idroles);
        option.text(data[i].rol);
        select.append(option);
      }
      $("#loader").hide();
    },
    error: function (error) {
      console.error("Error: " + error);
    },
  });
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

function openModal(type) {
  if (type === "edit") {
    // Configuración para la edición
    $("#modal-title").text("EDICIÓN DE DATOS DEL USUARIO");
    $("#password-row").hide();
    $("#estado-row").show();
    $("#submitUsuario").text("Editar");
    $("#ipass").removeAttr("required");
    $("#ipassco").removeAttr("required");
    resetHidden($("#form_user"));
  } else {
    $("#ipass").attr("required", false);
    $("#ipassco").attr("required", false);
    $("#submitUsuario").text("Guardar");
    $("#modal-title").text("INGRESO DE DATOS DEL USUARIO");
    $("#password-row").show();
    $("#estado-row").hide();
    resetHidden($("#form_user"));
  }

  $("#modal_user").modal({ backdrop: "static", keyboard: false });
  $(".aviso").val("");
}
