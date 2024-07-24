$(document).ready(function () {
  let idrol = 0,
    rol = "", accion = "";
  $("#loader").show();
  /*=============================   MOSTRAR TABLA DE USUARIOS  ================================= */
  tablaRoles = $("#tablaRoles").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "/Roles/getRoles",
      dataSrc: "",
    },
    ordering: false,
    columns: [
      { data: "idroles" },
      { data: "rol" },
      { data: "descripcion" },
      { data: "asociados" },
      { data: "estado" },
      { data: "opciones" },
    ],
    initComplete: function () {
      $("#loader").hide();
    },
  });

  //Mostrar modal de nuevo rol
  $("#nuevo_rol").click(function () {
    $("#form_roles")[0].reset();
    $("#submitRol").text("Guardar");
    $("#modal_roles .modal-title").text("REGISTRAR NUEVO ROL");
    $("#idrol").val("0");
    $("#modal_roles").modal({ backdrop: "static", keyboard: false });
    accion = "guardarán";
  });

  //Registrar o Editar los datos del formulario
  $("#form_roles").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: "¿Estás seguro?",
        text: `Se ${accion} los datos ingresados`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          let formData = new FormData(this);
          $.ajax({
            url: base_url + "/Roles/setRol",
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
                $("#form_roles")[0].reset();
                tablaRoles.ajax.reload(null, false);
                MostrarAlertaxTiempo(data.title, data.msg, "success");
                $("#modal_roles").modal("hide");
              }
              $("#loader").hide();
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al enviar los datos", "error");
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

  //Evento al presionar boton de Edición y mostrar los datos
  $(document).on("click", ".btnEditar", function () {
    idrol = parseInt($(this).closest("tr").find("td:eq(0)").text());
    accion = "editarán";
    $("#form_roles")[0].reset();
    $("#modal_roles .modal-title").text("EDITAR ROL EXISTENTE");
    $.ajax({
      url: base_url + "/Roles/getRol/" + idrol,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idrol").val(objData.data.idroles);
          $("#irol").val(objData.data.rol);
          $("#idescripcion").val(objData.data.descripcion);
          $("#estado").val(objData.data.estado);

          $("#submitRol").text("Editar");
          $("#modal_roles").modal({ backdrop: "static", keyboard: false });
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

  //Borrar registro
  $(document).on("click", ".btnBorrar", function () {
    idrol = parseInt($(this).closest("tr").find("td:eq(0)").text());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará el rol",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "" + base_url + "/Roles/delRol",
          type: "POST",
          datatype: "json",
          data: { idrol: idrol },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            data = $.parseJSON(response);
            if (data.status) {
              MostrarAlertaxTiempo(data.title, data.msg, "success");
              tablaRoles.ajax.reload(null, false);
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

  //Evento al presionar boton de Permisos y mostrarlos
  $(document).on("click", ".btnPermisos", function () {
    idrol = parseInt($(this).closest("tr").find("td:eq(0)").text());
    rol = $(this).closest("tr").find("td:eq(1)").text();

    $.ajax({
      url: base_url + "/Permisos/getPermisosRol/" + idrol,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        $("#contentAjax").html(response);
        $("#modal_permisos").modal({ backdrop: "static", keyboard: false });
        $("#loader").hide();
        $("#span_rol").text(rol);
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al cargar los datos", "error");
        console.error("Error: " + error);
        $("#loader").hide();
      },
    });
  });

  //Guardar los permisos
  $(document).on("click", "#submitPermisos", function () {
    let formData = new FormData(document.getElementById("form_permisos"));
    $.ajax({
      url: base_url + "/Permisos/setPermisos",
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
          MostrarAlerta("¡Error!", data.msg, "error");
        } else {
          MostrarAlertaxTiempo("¡Hecho!", data.msg, "success");
        }
        $("#loader").hide();
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al enviar los datos", "error");
        console.error("Error: " + error);
        $("#loader").hide();
      },
    });
  });

  //Marcar check al presionar el div
  $("#contentAjax").on("click", ".toggle-flip", function (e) {
    if (!$(e.target).is("input")) {
      let checkbox = $(this).find('input[type="checkbox"]');
      checkbox.prop("checked", !checkbox.prop("checked"));
    }
  });

  //Marcar todos los permisos con un check
  $("#contentAjax").on("change", ".row-checkbox", function () {
    let row = $(this).closest("tr");
    let isChecked = $(this).is(":checked");
    row.find(".other_check").prop("checked", isChecked);
  });

  //Valida si los checks estan todos marcados
  $("#contentAjax").on("change", ".other_check", function () {
    let row = $(this).closest("tr");
    let allChecked =
      row.find(".other_check").length ===
      row.find(".other_check:checked").length;
    row.find(".row-checkbox").prop("checked", allChecked);
  });
});
