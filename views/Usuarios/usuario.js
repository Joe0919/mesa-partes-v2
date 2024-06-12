$(document).ready(function () {
  let idusu, idper, opcion, idni, ruc, archi, año, area, estado, bdr;

  opcion = 1;

  area = $("#info-area").val();

  bdr = 1;

  $("#loader").show(); // Mostrar DIv de carga
  /*=============================   MOSTRAR TABLA DE USUARIOS  ================================= */
  tablaUsuarios = $("#tablaUsuarios").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: "../../app/controllers/usuario-controller.php",
      method: "POST", //usamos el metodo POST
      data: { opcion: opcion }, //enviamos opcion 1 para que haga un SELECT
      dataSrc: "",
    },
    columnDefs: [
      { targets: -2, width: "20px" }, // -2 se refiere a la penúltima columna
    ],
    ordering: false,
    columns: [
      { data: "idusuarios" },
      { data: "nombre" },
      { data: "dni" },
      { data: "email" },
      {
        data: "estado",
        render: function (data, type) {
          let country = "";
          switch (data) {
            case "ACTIVO":
              country = "bg-success";
              break;
            case "INACTIVO":
              country = "bg-gray";
              break;
          }
          return '<span  class="badge ' + country + '">' + data + "</span> ";
        },
      },
      {
        defaultContent: `<div class='text-center'>
              <div class='btn-group'>
                <button class='btn btn-warning btn-sm btn-table btnEditfoto' title='Cambiar foto'>
                  <i class='material-icons'>account_circle</i>
                </button>
              </div>
            </div>`,
      },
      {
        defaultContent: `<div class='text-center'>
              <div class='btn-group'>
                <button class='btn btn-primary btn-sm btn-table btnEditar' title='Editar'>
                  <i class='material-icons'>edit</i></button>
                <button class='btn btn-secondary btn-sm btn-table btnPsw' title='Cambiar contraseña'>
                  <i class='material-icons'>lock</i></button>
                <button class='btn btn-danger btn-sm btn-table btnBorrar' title='Eliminar'>
                  <i class='material-icons'>delete</i></button>
              </div>
            </div>`,
      },
    ],
    initComplete: function () {
      // Oculta el loader una vez que los datos se hayan cargado
      $("#loader").hide(); // Mostrar DIv de carga
    },
  });

  llenarSelectRol();

  //Mostrar modal de nuevo usuario
  $("#btn_new_user").click(function () {
    idusu = null;
    $("#form_new_user")[0].reset();
    $("#modal_new_user").modal({ backdrop: "static", keyboard: false });
    $(".aviso").val("");
  });

  //Guardar los datos del nuevo usuario
  $("#form_new_user").on("submit", function (e) {
    e.preventDefault();
    let opcion = 8; // Opcion para el switch del controlador
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      if ($("#ipassco").val() !== $("#ipass").val()) {
        MostrarAlerta(
          "Advertencia",
          "No ingreso contraseñas que coincidan.",
          "error"
        );
      } else {
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se guardarán los datos del nuevo usuario",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Guardar",
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData(this);
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
                    "DNI, Usuario, Email o Celular ya estan registrados",
                    "error"
                  );
                  $("#loader").hide();
                } else {
                  $("#loader").hide();
                  $("#form_new_user")[0].reset();
                  tablaUsuarios.ajax.reload(null, false); //Recargar la tabla
                  MostrarAlertaxTiempo(
                    "Registrado",
                    "Los datos fueron registrados.",
                    "success"
                  );
                  $("#modal_new_user").modal("hide");
                }
              },
              error: function (xhr, status, error) {
                // Manejar errores de la petición AJAX
                console.error("Error: " + error);
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

  /* =============================   VALIDACIONES DE CAMPOS  ================================= */

  $("#idni").blur(function () {
    //Consulta de disponibilidad de DNI al cambiar el click
    idni = $(this).val();
    if (idni.length == 8) {
      opcion = 7;
      $.ajax({
        url: "../../app/controllers/usuario-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, idni: idni },
        success: function (response) {
          switch (response) {
            case "0":
              $("#ErrorDNI").text("DNI disponible").css("color", "green");
              break;
            case "1":
              $("#ErrorDNI").text("DNI ya registrado").css("color", "red");
              break;
            default:
              $("#ErrorDNI").text("Error").css("color", "red");
              break;
          }
        },
      });
    } else {
      $("#ErrorDNI").text("").css("color", "red");
    }
  });

  $("#icel").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    icel = $(this).val();
    if (icel.length < 9) {
      $("#ErrorCel").text("").css("color", "red");
    } else {
      opcion = 7;
      $.ajax({
        url: "../../app/controllers/usuario-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, icel: icel },
        success: function (response) {
          switch (response) {
            case "0":
              $("#ErrorCel").text("N° Telef. disponible").css("color", "green");
              break;
            case "1":
              $("#ErrorCel").text("N° Telef. registrado").css("color", "red");
              break;
            default:
              $("#ErrorCel").text("Error").css("color", "red");
              break;
          }
        },
      });
    }
  });

  $("#iemail").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    let iemail = $.trim($(this).val());
    if (iemail.length == 0) {
      $("#ErrorEmail").text("").css("color", "red");
    } else {
      if (!ValidarCorreo(iemail)) {
        $("#ErrorEmail")
          .text("Formato de Email incorrecto")
          .css("color", "red");
      } else {
        opcion = 7;
        $.ajax({
          url: "../../app/controllers/usuario-controller.php",
          type: "POST",
          datatype: "json",
          data: { opcion: opcion, iemail: iemail },
          success: function (response) {
            switch (response) {
              case "0":
                $("#ErrorEmail")
                  .text("Correo disponible")
                  .css("color", "green");
                break;
              case "1":
                $("#ErrorEmail")
                  .text("Correo ya registrado")
                  .css("color", "red");
                break;
              default:
                $("#ErrorEmail").text("Error").css("color", "red");
                break;
            }
          },
        });
      }
    }
  });

  $("#inomusu").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    inomusu = $.trim($(this).val());
    if (inomusu.length < 4) {
      $("#ErrorNomUsu").text("").css("color", "red");
    } else {
      opcion = 7;
      $.ajax({
        url: "../../app/controllers/usuario-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, inomusu: inomusu },
        success: function (response) {
          switch (response) {
            case "0":
              $("#ErrorNomUsu")
                .text("Nombre de Usuario disponible")
                .css("color", "green");
              break;
            case "1":
              $("#ErrorNomUsu")
                .text("Nombre de Usuario ya registrado")
                .css("color", "red");
              break;
            default:
              $("#ErrorNomUsu").text("Error").css("color", "red");
              break;
          }
        },
      });
    }
  });

  $("#inomusu").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    inomusu = $.trim($(this).val());
    if (inomusu.length < 4) {
      $("#ErrorNomUsu").text("").css("color", "red");
    } else {
      opcion = 7;
      $.ajax({
        url: "../../app/controllers/usuario-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, inomusu: inomusu },
        success: function (response) {
          switch (response) {
            case "0":
              $("#ErrorNomUsu")
                .text("Nombre de Usuario disponible")
                .css("color", "green");
              break;
            case "1":
              $("#ErrorNomUsu")
                .text("Nombre de Usuario ya registrado")
                .css("color", "red");
              break;
            default:
              $("#ErrorNomUsu").text("Error").css("color", "red");
              break;
          }
        },
      });
    }
  });

  $("#ipassco").blur(function () {
    //Validacion de contraseña
    if ($("#ipassco").val().length < 8) {
      $("#ErrorContra").text("").css("color", "red");
    } else if ($(this).val() === $("#ipass").val()) {
      $("#ErrorContra").text("Las contraseñas coinciden").css("color", "green");
    } else {
      $("#ErrorContra")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  $("#ipass").blur(function () {
    //Validacion de contraseña
    if ($("#ipassco").val().length < 8) {
      $("#ErrorContra").text("").css("color", "red");
    } else if ($(this).val() === $("#ipassco").val()) {
      $("#ErrorContra").text("Las contraseñas coinciden").css("color", "green");
    } else {
      $("#ErrorContra")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });

  $("#checkEstado").change(function () {
    if ($(this).is(":checked")) {
      $("#label-estado").text("ACTIVO").css("color", "green");
      $("#estadoE").val("ACTIVO");
    } else {
      $("#label-estado").text("INACTIVO").css("color", "gray");
      $("#estadoE").val("INACTIVO");
    }
  });

  $("#iconfirmpswU").blur(function () {
    //Validacion de contraseña
    if ($("#iconfirmpswU").val().length < 8) {
      $("#ErrorContraU").text("").css("color", "red");
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
    //Validacion de contraseña
    if ($("#iconfirmpswU").val().length < 8) {
      $("#ErrorContraU").text("").css("color", "red");
    } else if ($(this).val() === $("#iconfirmpswU").val()) {
      $("#ErrorContraG")
        .text("Las contraseñas coinciden")
        .css("color", "green");
    } else {
      $("#ErrorContraU")
        .text("Las contraseñas no coinciden")
        .css("color", "red");
    }
  });
  /* =============================   ACCIONES BOTONES EN TABLA  ================================= */
  // Mostrar modal de cambio de foto
  $(document).on("click", ".btnEditfoto", function () {
    opcion = 2;
    fila = $(this).closest("tr");
    idusu = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    idni = fila.find("td:eq(2)").text();
    $.ajax({
      url: "../../app/controllers/usuario-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, idusu: idusu, idni: idni },
      success: function (response) {
        data = $.parseJSON(response);
        $("#idnif").val(idni);
        $("#idusuf").val(idusu);
        $("#foto_perfilf").css(
          "background-image",
          "url(../../public/" + data["foto"] + ")"
        );
        $("#modalfoto").modal({ backdrop: "static", keyboard: false });
      },
    });
  });

  //VISUALIZAR FOTO SELECCIONADA
  $("#idfilef").change(function (e) {
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
          $("#foto_perfilf").css("background-image", "url(" + urlImagen + ")");
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

  //Accion para cambiar foto del usuario
  $("#FormFoto").on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Cambiar la foto del perfil del usuario",
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
            $("#loader").hide();
            MostrarAlertaxTiempo(
              "Foto Cambiada",
              "Se hizo el cambio de la foto de perfil",
              "success"
            );
            $("#idfilef").val("");
            $("#modalfoto").modal("hide");
          },
          error: function (xhr, status, error) {
            // Manejar errores de la petición AJAX
            console.error("Error: " + error);
          },
        });
      }
    });
  });

  //Mostrar datos de usuario para edicion
  $(document).on("click", ".btnEditar", function () {
    opcion = 2;
    fila = $(this).closest("tr");
    idusu = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    idni = fila.find("td:eq(2)").text();
    $("#form_edit_user")[0].reset();
    $.ajax({
      url: "../../app/controllers/usuario-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, idusu: idusu, idni: idni },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        $("#idusuE").val(data["ID1"]);
        $("#idperE").val(data["ID2"]);
        $("#idniE").val(data["dni"]);
        $("#inombreE").val(data["nombres"]);
        $("#iappatE").val(data["ap"]);
        $("#iapmatE").val(data["am"]);
        $("#icelE").val(data["telefono"]);
        $("#idirE").val(data["direccion"]);
        $("#iemailE").val(data["email"]);
        $("#inomusuE").val(data["nombre"]);
        $("#irolE").val(data["IDR"]);
        if (data["estado"] == "ACTIVO") {
          $("#checkEstado").prop("checked", true);
          $("#label-estado").text("ACTIVO").css("color", "green");
          $("#estadoE").val("ACTIVO");
        } else {
          $("#checkEstado").prop("checked", false);
          $("#label-estado").text("INACTIVO").css("color", "gray");
          $("#estadoE").val("INACTIVO");
        }
        $("#loader").hide();

        $("#modal_edit_user").modal({ backdrop: "static", keyboard: false });
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  });

  //Editar los datos del usuario en tabla
  $("#form_edit_user").on("submit", function (e) {
    e.preventDefault();
    let opcion = 3; // Opcion para el switch del controlador
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Se editarán los datos del usuario",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Editar",
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData(this);
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
                $("#loader").hide();
                MostrarAlerta(
                  "Advertencia",
                  "DNI, Usuario, Email o Celular ya estan registrados",
                  "error"
                );
              } else {
                $("#loader").hide();
                $("#form_edit_user")[0].reset();
                tablaUsuarios.ajax.reload(null, false); //Recargar la tabla
                MostrarAlertaxTiempo(
                  "Actualizado",
                  "Los datos del usuario fueron actualizados.",
                  "success"
                );
                $("#modal_edit_user").modal("hide");
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

  //Mostrar modal cambio de contraseña
  $(document).on("click", ".btnPsw", function () {
    $(".aviso").val("");
    $("#form_edit_psw")[0].reset();
    fila = $(this).closest("tr");
    idusu = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    $("#idusuU").val(idusu);
    $("#modal_edit_psw").modal({ backdrop: "static", keyboard: false });
  });

  //Actualizar la contraseña del usuario en tabla
  $("#form_edit_psw").on("submit", function (e) {
    e.preventDefault();
    opcion = 6;
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
            formData.append("opcion", opcion); // Agrega la variable  al objeto FormData
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
                  $("#icontraU").select();
                } else {
                  $("#modal_edit_psw").modal("hide");
                  $("#form_edit_psw")[0].reset();
                  $("#ErrorContraU").text("");
                  $("#loader").hide();
                  MostrarAlertaxTiempo(
                    "Contraseña Actualizada",
                    "Se hizo el cambio de contraseña",
                    "success"
                  );
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
    idni = parseInt($(this).closest("tr").find("td:eq(2)").text());
    opcion = 4; //eliminar
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará al usuario permanentemente",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, eliminar!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../app/controllers/usuario-controller.php",
          type: "POST",
          datatype: "json",
          data: { opcion: opcion, idni: idni },
          beforeSend: function () {
            /* * Se ejecuta al inicio de la petición* */
            $("#loader").show();
          },
          success: function (response) {
            data = $.parseJSON(response);
            if (data == 1) {
              MostrarAlerta(
                "Se tiene asociado datos",
                "El registro tiene datos asociado por lo que no se puede eliminar",
                "error"
              );
              $("#loader").hide();
            } else {
              MostrarAlertaxTiempo("Eliminado", "Se eliminó al usuario", "success");
              tablaUsuarios.ajax.reload(null, false); //Recargar la tabla
              $("#loader").hide();
            }
          },
          error: function (xhr, status, error) {
            // Manejar errores de la petición AJAX
            console.error("Error: " + error);
          },
        });
      }
    });
  });
});

function llenarSelectRol() {
  let opcion = 10;
  $.ajax({
    url: "../../app/controllers/usuario-controller.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      let select = $(".select-rol"); // Reemplaza "selectId" con el ID de tu select
      // Recorre los datos devueltos y crea las opciones del select
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].idroles);
        option.text(data[i].rol);
        select.append(option);
      }
    },
    error: function (xhr, status, error) {
      // Manejar errores de la petición AJAX
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
