$(document).ready(function () {
  let idempleado = 0,
    idusuario = 0;
  accion = "";

  $("#loader").show();

  /*=============================   MOSTRAR TABLA DE AREAS  ================================= */
  tablaEmpleados = $("#tablaEmpleados").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "/Empleados/getEmpleados",
      dataSrc: "",
    },
    ordering: false,
    columns: [
      { data: "ID" },
      { data: "Codigo" },
      { data: "dni" },
      { data: "Datos" },
      { data: "telefono" },
      { data: "area" },
      { data: "opciones" },
    ],
    initComplete: function () {
      $("#loader").hide();
    },
  });

  llenarSelectAreas().catch((error) => {
    console.error("Error al cargar áreas:", error);
  });

  //Mostrar modal de nueva area
  $("#nuevo_empleado").click(function () {
    $("#form_empleado")[0].reset();
    $("#submitEmpleado").text("Guardar");
    $("#modal-title-empleado").text("REGISTRAR NUEVO EMPLEADO");
    $("#idempleado").val("0");
    accion = "guardarán";
    $("#div_users").show();
    $("#select_usuario").prop("required", true);
    $("#modal_empleado").modal({ backdrop: "static", keyboard: false });
    llenarSelectUsuarios().catch((error) => {
      console.error("Error al cargar usuarios:", error);
    });
  });

  //Mostrar datos del usuario al seleccionar
  $("#select_usuario").change(function () {
    idusuario = $(this).val();
    $.ajax({
      url: base_url + "/Usuarios/getUsuario/" + idusuario,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idpersonaU").val(objData.data.idpersona);
          $("#idusuarioU").val(objData.data.idusuarios);
          $("#dniU").val(objData.data.dni);
          $("#nomU").val(objData.data.nombres);
          $("#apU").val(objData.data.ap);
          $("#amU").val(objData.data.am);
          $("#celU").val(objData.data.telefono);
          $("#dirU").val(objData.data.direccion);

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

  validarCamposRequeridos("#form_empleado");

  //Registrar o Editar los datos del formulario
  $("#form_empleado").on("submit", function (e) {
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
            url: base_url + "/Empleados/setEmpleado",
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
                $("#form_empleado")[0].reset();
                tablaEmpleados.ajax.reload(null, false);
                MostrarAlertaxTiempo(data.title, data.msg, "success");
                $("#modal_empleado").modal("hide");
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

  //Mostrar datos de area para edicion
  $(document).on("click", ".btnEditar", function () {
    idempleado = parseInt($(this).closest("tr").find("td:eq(0)").text());
    accion = "editarán";
    $("#form_empleado")[0].reset();
    $("#modal-title-empleado").text("EDITAR DATOS DEL EMPLEADO");
    $.ajax({
      url: base_url + "/Empleados/getEmpleado/" + idempleado,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {

        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idempleado").val(objData.data.idempleado);
          $("#idpersona").val(objData.data.idpersona);
          $("#dniU").val(objData.data.dni);
          $("#nomU").val(objData.data.nombres);
          $("#apU").val(objData.data.ap);
          $("#amU").val(objData.data.am);
          $("#celU").val(objData.data.telefono);
          $("#dirU").val(objData.data.direccion);
          $("#codEmpleado").val(objData.data.cod_empleado);
          $("#select_area").val(objData.data.idarea);

          $("#div_users").hide();
          $("#select_usuario").prop("required", false);

          $("#submitEmpleado").text("Editar");
          $("#modal_empleado").modal({ backdrop: "static", keyboard: false });
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
    idempleado = parseInt($(this).closest("tr").find("td:eq(0)").text());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará el empleado",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "" + base_url + "/Empleados/delEmpleado",
          type: "POST",
          datatype: "json",
          data: { idempleado: idempleado },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            data = $.parseJSON(response);
            if (data.status) {
              MostrarAlertaxTiempo(data.title, data.msg, "success");
              tablaEmpleados.ajax.reload(null, false);
            } else {
              MostrarAlerta(data.title, data.msg, "error");
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

  async function llenarSelectUsuarios() {
    try {
      const response = await fetch(base_url + "/Empleados/getSelectUsuarios", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!response.ok) {
        throw new Error("Error en la respuesta de la red");
      }

      const data = await response.json();
      let select = $("#select_usuario");
      select.empty();

      if (data.length === 0) {
        // Si no hay usuarios, mostrar mensaje de no encontrado
        let noUserOption = $("<option></option>");
        noUserOption.val("");
        noUserOption.text("No se encontraron usuarios");
        noUserOption.attr("disabled", true);
        noUserOption.attr("selected", true);
        select.append(noUserOption);
      } else {
        // Si hay usuarios, mostrar lista de usuarios
        let placeholderOption = $("<option></option>");
        placeholderOption.val("");
        placeholderOption.text("Seleccione usuario...");
        placeholderOption.attr("disabled", true);
        placeholderOption.attr("selected", true);
        select.append(placeholderOption);

        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].idusuarios);
          option.text(data[i].Datos);
          select.append(option);
        }
      }
      $("#loader").hide();
    } catch (error) {
      console.error("Error al llenar select Usuarios: ", error);
    }
  }

  async function llenarSelectAreas() {
    try {
      const response = await fetch(base_url + "/Areas/getSelectAreas", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!response.ok) {
        throw new Error("Error en la respuesta de la red");
      }
      const data = await response.json();
      let select = $("#select_area");
      select.empty();
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione área...");
      placeholderOption.attr("disabled", true);
      placeholderOption.attr("selected", true);
      select.append(placeholderOption);
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].IdAInst);
        option.text(data[i].area);
        select.append(option);
      }
      $("#loader").hide();
    } catch (error) {
      console.error("Error al llenar select Area: ", error);
    }
  }

  async function cargarDatos() {
    await llenarSelectUsuarios();
    await llenarSelectAreas();
  }

  cargarDatos();
});
