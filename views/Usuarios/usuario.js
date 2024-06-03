$(document).ready(function () {
  var user_id, id, opcion, dnipersona, ruc, archi, año, area, estado, bdr;
  opcion = 1;

  idarea = $("#idareaid").val();
  area = $("#idarealogin").val();

  bdr = 1;

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
      { targets: -2, width: '20px' } // -2 se refiere a la penúltima columna
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
            case "DESACTIVADO":
              country = "bg-gray";
              break;
          }
          return (
            '<span style="font-size:14px"  class="badge ' +
            country +
            '">' +
            data +
            "</span> "
          );
        },
      },
      {
        defaultContent: `<div class='text-center'>
              <div class='btn-group'>
                <button class='btn btn-warning btn-sm btn-table btnEditfoto'>
                  <i class='material-icons'>account_circle</i>
                </button>
              </div>
            </div>`,
      },
      {
        defaultContent: `<div class='text-center'>
              <div class='btn-group'>
                <button class='btn btn-primary btn-sm btn-table btnEditar'>
                  <i class='material-icons'>edit</i></button>
                <button class='btn btn-secondary btn-sm btn-table btnpsw'>
                  <i class='material-icons'>lock</i></button>
                <button class='btn btn-danger btn-sm btn-table btnBorrar'>
                  <i class='material-icons'>delete</i></button>
              </div>
            </div>`,
      },
    ],
  });

  /*=============================   INICIO DE CRUD DE LAS TABLAS  ================================= */

  /*=============================   CRUD DE TABLA USUARIOS  ================================= */
  $("#idni").blur(function () {
    //Consulta de disponibilidad de DNI al cambiar el click
    idni = $("#idni").val();
    if (idni.length == 0) {
      $("#Aviso").text("Ingrese el Número de DNI").css("color", "red");
    } else {
      if (idni.length == 8) {
        opcion = 5;
        $.ajax({
          url: "../../controller/crudusu.php",
          type: "POST",
          datatype: "json",
          data: { opcion: opcion, idni: idni },
          success: function (response) {
            alert(response);
            switch (response) {
              case "1":
                $("#Aviso").text("DNI ya está registrado").css("color", "red");
                break;
              case "2":
                $("#Aviso").text("DNI no registrado").css("color", "green");
                break;
              default:
                $("#Aviso").text("Error").css("color", "red");
                break;
            }
          },
        });
      } else {
        $("#Aviso").text("El DNI debe tener 8 dígitos.").css("color", "red");
      }
    }
  });

  // $("#idni").keypress(function(e) { //Consulta de disponibilidad de DNI al dar enter
  //   if(e.which == 13) {
  //     e.preventDefault();
  //     idni = $('#idni').val();
  //     if(idni.length == 0){
  //       $('#Aviso').text("Ingrese el Número de DNI").css("color","red");
  //     }else{
  //       if(idni.length == 8){
  //         opcion = 5;
  //         $.ajax({
  //           url: "../../controller/crudusu.php",
  //           type: "POST",
  //           datatype:"json",
  //           data:  {opcion:opcion, idni:idni},
  //           success: function(response) {
  //             switch(response){
  //               case '1':
  //                 $('#Aviso').text("DNI ya está registrado").css("color","red");
  //                 break;
  //               case '2':
  //                 $('#Aviso').text("DNI no registrado").css("color","green");
  //                 break;
  //               default:
  //                 $('#Aviso').text("Error").css("color","red");
  //                 break;
  //             }
  //           }
  //         });
  //       }else{
  //         $('#Aviso').text("El DNI debe tener 8 dígitos.").css("color","red");
  //       }
  //     }
  //   }
  // });
  //submit para el Alta y Actualización

  $("#iemail").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    iemail = $.trim($("#iemail").val());
    if (iemail.length == 0) {
      $("#AvisoE").text("Ingrese el Email").css("color", "red");
    } else {
      opcion = 7;
      $.ajax({
        url: "../../controller/crudusu.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, iemail: iemail },
        success: function (response) {
          switch (response) {
            case "1":
              $("#AvisoE").text("Email ya registrado").css("color", "red");
              break;
            case "2":
              $("#AvisoE").text("Email no registrado").css("color", "green");
              break;
            default:
              $("#AvisoE").text("Error").css("color", "red");
              break;
          }
        },
      });
    }
  });

  $("#inomusu").blur(function () {
    //Consulta de disponibilidad de EMAIL al cambiar el click
    inomusu = $.trim($("#inomusu").val());
    if (inomusu.length == 0) {
      $("#error1").text("Ingrese el Nombre de Usuario").css("color", "red");
    } else {
      opcion = 8;
      $.ajax({
        url: "../../controller/crudusu.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, inomusu: inomusu },
        success: function (response) {
          switch (response) {
            case "1":
              $("#error1")
                .text("Nombre de Usuario no Disponible")
                .css("color", "red");
              break;
            case "2":
              $("#error1")
                .text("Nombre de Usuario Disponible")
                .css("color", "green");
              break;
            default:
              $("#error1").text("Error").css("color", "red");
              break;
          }
        },
      });
    }
  });

  $("#guardar").click(function () {
    opcion = 1;
    idni = $.trim($("#idni").val());
    inombre = $.trim($("#inombre").val());
    iappat = $.trim($("#iappat").val());
    iapmat = $.trim($("#iapmat").val());
    icel = $.trim($("#icel").val());
    idir = $.trim($("#idir").val());
    iemail = $.trim($("#iemail").val());
    inomusu = $.trim($("#inomusu").val());
    tipo = $.trim($("#tipo").val());
    ipassco = $.trim($("#ipassco").val());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Guardar los datos registrados",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, guardar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../controller/crudusu.php",
          type: "POST",
          datatype: "json",
          data: {
            idni: idni,
            inombre: inombre,
            iappat: iappat,
            iapmat: iapmat,
            icel: icel,
            idir: idir,
            iemail: iemail,
            inomusu: inomusu,
            tipo: tipo,
            ipassco: ipassco,
            opcion: opcion,
          },
          success: function (data) {
            limpiarcampos();
            MostrarAlerta("Hecho", "Se agregó el registro", "success");
            tablaUsuarios.ajax.reload(null, false);
            $("#modalusuario").modal("hide");
          },
        });
      }
    });
  });

  //para limpiar los campos antes de dar de Alta una Persona
  $("#Nuevo").click(function () {
    opcion = 1; //alta
    user_id = null;
    limpiarcampos();
    $("#modalusuario").modal("show");
  });

  $(document).on("click", ".btnpsw", function () {
    fila = $(this);
    user_id = parseInt($(this).closest("tr").find("td:eq(0)").text());
    usu = $(this).closest("tr").find("td:eq(1)").text();
    $("#modaleditpsw1").modal({ backdrop: "static", keyboard: false });
    $("#idc").text(usu);
  });

  $(document).on("click", ".btnEditfoto", function () {
    $("#FotoP").attr("src", "");
    opcion = 6;
    fila = $(this).closest("tr");
    user_id = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    idni = fila.find("td:eq(2)").text();
    $.ajax({
      url: "../../controller/crudusu.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, user_id: user_id, idni: idni },
      success: function (response) {
        data = $.parseJSON(response);
        $("#iddni1").val(idni);
        $("#idusua").val(user_id);
        $("#FotoP").attr("src", "/Sistema_MesaPartes/" + data[0]["foto"]);
        $("#modalfoto").modal("show");
      },
    });
  });

  $("#guardar").click(function () {
    //Editar usuario
    opcion = 1;
    idni = $.trim($("#idni").val());
    inombre = $.trim($("#inombre").val());
    iappat = $.trim($("#iappat").val());
    iapmat = $.trim($("#iapmat").val());
    icel = $.trim($("#icel").val());
    idir = $.trim($("#idir").val());
    iemail = $.trim($("#iemail").val());
    inomusu = $.trim($("#inomusu").val());
    tipo = $.trim($("#tipo").val());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Guardar los datos registrados",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, guardar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../controller/crudusu.php",
          type: "POST",
          datatype: "json",
          data: {
            idni: idni,
            inombre: inombre,
            iappat: iappat,
            iapmat: iapmat,
            icel: icel,
            idir: idir,
            iemail: iemail,
            inomusu: inomusu,
            tipo: tipo,
            ipassco: ipassco,
            opcion: opcion,
          },
          success: function (data) {
            limpiarcampos();
            MostrarAlerta("Hecho", "Se agregó el registro", "success");
            tablaUsuarios.ajax.reload(null, false);
            $("#modalusuario").modal("hide");
          },
        });
      }
    });
  });

  $(document).on("click", ".btnEditar", function () {
    //Mostrar datos de usuario para edicion
    opcion = 6;
    fila = $(this).closest("tr");
    user_id = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    idni = fila.find("td:eq(2)").text();
    $.ajax({
      url: "../../controller/crudusu.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, user_id: user_id, idni: idni },
      success: function (response) {
        data = $.parseJSON(response);
        $("#idusu").val(data[0]["ID1"]);
        $("#idper").val(data[0]["ID2"]);
        $("#idni1").val(data[0]["dni"]);
        $("#inombre1").val(data[0]["nombres"]);
        $("#iappat1").val(data[0]["ap"]);
        $("#iapmat1").val(data[0]["am"]);
        $("#icel1").val(data[0]["telefono"]);
        $("#idir1").val(data[0]["direccion"]);
        $("#iemail1").val(data[0]["email"]);
        $("#inomusu1").val(data[0]["nombre"]);
        $("#tipo1").val(data[0]["IDR"]);
        $("#estado1").val(data[0]["estado"]);

        $("#modalEdusuario").modal("show");
      },
    });
  });

  //EDITAR DATOS DE USUARIO
  $("#Editar").click(function () {
    opcion = 2;
    idper = $("#idper").val();
    user_id = $("#idusu").val();
    idni = $.trim($("#idni1").val());
    inombre = $.trim($("#inombre1").val());
    iappat = $.trim($("#iappat1").val());
    iapmat = $.trim($("#iapmat1").val());
    icel = $.trim($("#icel1").val());
    idir = $.trim($("#idir1").val());
    iemail = $.trim($("#iemail1").val());
    inomusu = $.trim($("#inomusu1").val());
    tipo = $("#tipo1").val();
    estado = $("#estado1").val();
    if (
      idni.length <= 7 ||
      inombre.length <= 0 ||
      iappat.length <= 0 ||
      iapmat.length <= 0 ||
      icel.length <= 0 ||
      idir.length <= 0 ||
      iemail.length <= 0 ||
      inomusu.length <= 0
    ) {
      alert("Debe Completar correctamente todos los campos");
    } else {
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
          $.ajax({
            url: "../../controller/crudusu.php",
            type: "POST",
            datatype: "json",
            data: {
              opcion: opcion,
              idper: idper,
              user_id: user_id,
              idni: idni,
              inombre: inombre,
              iappat: iappat,
              iapmat: iapmat,
              icel: icel,
              idir: idir,
              iemail: iemail,
              inomusu: inomusu,
              tipo: tipo,
              estado: estado,
            },
            success: function (response) {
              data = $.parseJSON(response);
              if (data == 1) {
                alert(
                  "Hay registros que se repiten, asegurese de ingresar valores únicos"
                );
              } else {
                if (data == 2) {
                  limpiarcampos();
                  MostrarAlerta("Hecho", "Usted realizo el cambio", "success");
                  tablaUsuarios.ajax.reload(null, false);
                  $("#modalEdusuario").modal("hide");
                } else {
                  limpiarcampos();
                  MostrarAlerta(
                    "Hecho",
                    "Los datos fueron actualizados",
                    "success"
                  );
                  tablaUsuarios.ajax.reload(null, false);
                  $("#modalEdusuario").modal("hide");
                }
              }
            },
          });
        }
      });
    }
  });

  //Borrar usuario
  $(document).on("click", ".btnBorrar", function () {
    fila = $(this);
    idni = parseInt($(this).closest("tr").find("td:eq(2)").text());
    opcion = 3; //eliminar
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará al usuario seleccionado",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, eliminar!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../controller/crudusu.php",
          type: "POST",
          datatype: "json",
          data: { opcion: opcion, idni: idni },
          success: function (response) {
            data = $.parseJSON(response);
            if (data == 1) {
              MostrarAlerta(
                "Se tiene asociado datos",
                "El registro tiene datos asociado por lo que no se puede eliminar",
                "error"
              );
            } else {
              MostrarAlerta("Hecho", "Se eiiminó al usuario", "success");
              tablaUsuarios.row(fila.parents("tr")).remove().draw();
            }
          },
        });
      }
    });
  });

  //EDITAR CONTRASEÑA
  $("#BtnContra").click(function () {
    opcion = 9;
    ipswa = $("#ipsw").val();
    ipsw = $("#ipasss1").val();
    ipswn = $("#ipassco1").val();
    if (ipswa.length <= 0 || ipsw.length <= 0 || ipswn.length <= 0) {
      alert("Los campos no deben estar vacios");
    } else {
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
          $.ajax({
            url: "../../controller/crudusu.php",
            type: "POST",
            datatype: "json",
            data: {
              opcion: opcion,
              user_id: user_id,
              ipswa: ipswa,
              ipswn: ipswn,
            },
            success: function (response) {
              data = $.parseJSON(response);
              alert(data);
              if (data == 1) {
                MostrarAlerta(
                  "Incorrecto",
                  "La contraseña actual ingresada es incorrecta",
                  "error"
                );
              } else {
                $("#modaleditpsw").modal("hide");
                ResetForm("formC");
                $("#error3").text("");
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
    }
  });

  $("#SalirC").click(function () {
    ResetForm("formC");
    $("#error3").text("");
  });

  //CAMBIO DE FOTO
  $("#FormFoto").on("submit", function (e) {
    e.preventDefault();
    opcion = 10;
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Cambiar la foto de perfil",
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
          url: "../../controller/crudusu.php",
          data: new FormData(this),
          contentType: false,
          processData: false,
          beforeSend: function () {},
          success: function (msg) {
            MostrarAlerta(
              "Hecho",
              "Se hizo el cambio de la foto de perfil",
              "success"
            );
            ResetForm("FormFoto");
            $("#modalfoto").modal("hide");
            $("#FotoP").attr("src", "");
          },
        });
      }
    });
  });

  $("#idfile1").change(function () {
    var file = this.files[0];
    var imagefile = file.type;
    var match = "image/jpeg";
    if (imagefile != match) {
      alert("Porfavor selecciona un imagen de tipo: JPG.");
      $("#idfile1").val("");
      return false;
    }
  });

  $("#idfilep").change(function () {
    var file = this.files[0];
    var imagefile = file.type;
    var match = "image/jpeg";
    if (imagefile != match) {
      alert("Porfavor selecciona un imagen de tipo: JPG.");
      $("#idfilep").val("");
      return false;
    } else {
    }
  });

  $("#Conf").click(function () {
    //Mostrar modal de datos del perfil
    opcion = 6;
    user_id = $("#iduser").val();
    idni = $("#dniuser").val();
    $.ajax({
      url: "../../controller/crudusu.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, user_id: user_id, idni: idni },
      success: function (response) {
        data = $.parseJSON(response);
        $("#idusup").val(data[0]["ID1"]);
        $("#idperp").val(data[0]["ID2"]);
        $("#idnip").val(data[0]["dni"]);
        $("#idnip").prop("readonly", true);
        $("#inombrep").val(data[0]["nombres"]);
        $("#iappatp").val(data[0]["ap"]);
        $("#iapmatp").val(data[0]["am"]);
        $("#icelp").val(data[0]["telefono"]);
        $("#idirp").val(data[0]["direccion"]);
        $("#iemailp").val(data[0]["email"]);
        $("#inomusup").val(data[0]["nombre"]);

        $("#modalUsu").modal({ backdrop: "static", keyboard: false });
      },
    });
  });

  $("#Actualizar").click(function () {
    opcion = 12;
    idper = $("#idperp").val();
    user_id = $("#idusup").val();
    inombre = $.trim($("#inombrep").val());
    iappat = $.trim($("#iappatp").val());
    iapmat = $.trim($("#iapmatp").val());
    icel = $.trim($("#icelp").val());
    idir = $.trim($("#idirp").val());
    iemail = $.trim($("#iemailp").val());
    inomusu = $.trim($("#inomusup").val());
    if (
      idni.length <= 7 ||
      inombre.length <= 0 ||
      iappat.length <= 0 ||
      iapmat.length <= 0 ||
      icel.length <= 0 ||
      idir.length <= 0 ||
      iemail.length <= 0 ||
      inomusu.length <= 0
    ) {
      alert("Debe Completar correctamente todos los campos");
    } else {
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
          $.ajax({
            url: "../../controller/crudusu.php",
            type: "POST",
            datatype: "json",
            data: {
              opcion: opcion,
              idper: idper,
              user_id: user_id,
              inombre: inombre,
              iappat: iappat,
              iapmat: iapmat,
              icel: icel,
              idir: idir,
              iemail: iemail,
              inomusu: inomusu,
            },
            success: function (response) {
              data = $.parseJSON(response);
              if (data == 1) {
                alert("El Email o nombre de usuario genera duplicidad");
              } else {
                if (data == 2) {
                  limpiarcampos();
                  MostrarAlerta("Hecho", "Usted realizo el cambio", "success");
                  tablaUsuarios.ajax.reload(null, false);
                  $("#modalEdusuario").modal("hide");
                } else {
                  ResetForm("formperfil");
                  MostrarAlerta(
                    "Hecho",
                    "Se actualizaron sus datos.",
                    "success"
                  );
                  $("#modalUsu").modal("hide");
                }
              }
            },
          });
        }
      });
    }
  });

  $("#Fot").click(function () {
    //Mostrar modal de foto de perfil
    $("#modalfotop").modal({ backdrop: "static", keyboard: false });
  });

  $("#FormFotop").on("submit", function (e) {
    e.preventDefault();
    opcion = 13;
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
          url: "../../controller/crudusu.php",
          data: new FormData(this),
          contentType: false,
          processData: false,
          beforeSend: function () {},
          success: function (msg) {
            alert(msg);
            MostrarAlerta(
              "Hecho",
              "Se hizo el cambio de la foto de perfil",
              "success"
            );
            $("#idfilep").val("");
            $("#modalfotop").modal("hide");
          },
        });
      }
    });
  });
});
