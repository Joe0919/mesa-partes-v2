$(document).ready(function () {
    $("#loader").show(); // Mostrar DIv de carga
    /*=============================   MOSTRAR TABLA DE AREAS  ================================= */
    tablaEmpleados = $("#tablaEmpleados").DataTable({
      destroy: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      },
      ajax: {
        url: "../../app/controllers/empleado-controller.php",
        method: "POST", //usamos el metodo POST
        data: { opcion: opcion }, //enviamos opcion 1 para que haga un SELECT
        dataSrc: "",
      },
      // columnDefs: [
      //   { targets: -2, width: "20px" }, // -2 se refiere a la penúltima columna
      // ],
      ordering: false,
      columns: [
        { data: "ID" },
        { data: "Codigo" },
        { data: "dni" },
        { data: "Datos" },
        { data: "telefono" },
        { data: "area" },
        {
          defaultContent: `<div class='text-center'>
                <div class='btn-group'>
                    <button class='btn btn-primary btn-sm btn-table btnEditarEmpleado' title='Editar'>
                      <i class='material-icons'>edit</i></button>
                    <button class='btn btn-danger btn-sm btn-table btnBorrarEmpleado' title='Borrar'>
                      <i class='material-icons'>lock</i></button>
                </div>
            </div>`,
        },
      ],
      initComplete: function () {
        // Oculta el loader una vez que los datos se hayan cargado
        $("#loader").hide(); // Mostrar DIv de carga
      },
    });
  
    llenarSelectAreas();
    llenarSelectUsuarios();
  
    //Mostrar modal de nuevo usuario
    $("#btn_new_employed").click(function () {
      $("#div_users").show();
      $("#select-user").attr("required", "required");
      $("#form_empleado")[0].reset();
      $("#submitEmpleado").text("Guardar");
      $("#codEmpleado").val(generarCodigo("tablaEmpleados", 0, "E")); //Sugerimos un codigo
      $("#modal_empleado").modal({ backdrop: "static", keyboard: false });
    });
  
    //Mostrar datos del usuario al seleccionar
    $("#select-user").change(function () {
      opcion = 11;
      idusu = $(this).val();
      $.ajax({
        url: "../../app/controllers/usuario-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, idusu: idusu },
        success: function (response) {
          data = $.parseJSON(response);
          $("#idusuE").val(data["IDUSU"]);
          $("#idperE").val(data["IDPER"]);
          $("#dniU").val(data["dni"]);
          $("#nomU").val(data["nombres"]);
          $("#apU").val(data["ap"]);
          $("#amU").val(data["am"]);
          $("#celU").val(data["telefono"]);
          $("#dirU").val(data["direccion"]);
        },
        error: function (xhr, status, error) {
          // Manejar errores de la petición AJAX
          console.error("Error: " + error);
        },
      });
    });
  
    //Registrar o Editar los datos del formulario
    $("#form_empleado").on("submit", function (e) {
      e.preventDefault();
      //SI NO HAY ID SERA INSERCIÓN
      if ($("#idempleado").val() === "0") {
        let opcion = 2; // Opcion para el switch del controlador
        let formulario = $(this);
        if (verificarCampos(formulario)) {
          Swal.fire({
            title: "¿Estás seguro?",
            text: "Se guardarán los datos ingresados",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, Guardar",
          }).then((result) => {
            if (result.isConfirmed) {
              var formData = new FormData(this);
              formData.append("opcion", opcion); // Agrega la variable "opcion" al objeto FormData
              $.ajax({
                url: "../../app/controllers/empleado-controller.php",
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
                  switch (data) {
                    case 1:
                      MostrarAlerta(
                        "Datos duplicados",
                        "El Código ya se encuentra registrados",
                        "error"
                      );
                      $("#loader").hide();
                      break;
                    default:
                      $("#loader").hide();
                      $("#form_empleado")[0].reset();
                      tablaEmpleados.ajax.reload(null, false); //Recargar la tabla
                      MostrarAlertaxTiempo(
                        "Registrado",
                        "Los datos fueron registrados.",
                        "success"
                      );
                      $("#modal_empleado").modal("hide");
                      break;
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
      } else {
        // CASO CONTRARIO SERA EDICIÓN
        $("#select-user").removeAttr("required");
        let opcion = 4;
        let formulario = $(this);
        if (verificarCampos(formulario)) {
          Swal.fire({
            title: "¿Estás seguro?",
            text: "Se editarán los datos del empleado",
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
                url: "../../app/controllers/empleado-controller.php",
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
                  switch (data) {
                    case 1:
                      MostrarAlerta(
                        "Datos duplicados",
                        "El Código ya se encuentra registrados",
                        "error"
                      );
                      $("#loader").hide();
                      break;
                    case 2:
                      MostrarAlertaxTiempo(
                        "Sin cambios",
                        "No realizo cambios en los datos.",
                        "success"
                      );
                      $("#loader").hide();
                      $("#form_empleado")[0].reset();
                      $("#modal_empleado").modal("hide");
                      break;
                    default:
                      $("#loader").hide();
                      $("#form_empleado")[0].reset();
                      tablaEmpleados.ajax.reload(null, false); //Recargar la tabla
                      MostrarAlertaxTiempo(
                        "Actualizado",
                        "Los datos fueron actualizados.",
                        "success"
                      );
                      $("#modal_empleado").modal("hide");
                      break;
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
      }
    });
  
    //Mostrar datos de usuario para edicion
    $(document).on("click", ".btnEditarEmpleado", function () {
      opcion = 3;
      idni = parseInt($(this).closest("tr").find("td:eq(2)").text()); //capturo el DNI
      $("#form_empleado")[0].reset();
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
          $("#div_users").hide();
          $("#idempleado").val(data["ID"]);
          $("#dniU").val(data["dni"]);
          $("#nomU").val(data["nombres"]);
          $("#apU").val(data["ap"]);
          $("#amU").val(data["am"]);
          $("#celU").val(data["telefono"]);
          $("#dirU").val(data["direccion"]);
          $("#codEmpleado").val(data["cod"]);
          $("#select-area").val(data["ID2"]);
  
          $("#loader").hide();
          $("#submitEmpleado").text("Actualizar");
  
          $("#modal_empleado").modal({ backdrop: "static", keyboard: false });
        },
        error: function (xhr, status, error) {
          // Manejar errores de la petición AJAX
          console.error("Error: " + error);
        },
      });
    });
  
    //Borrar registro
    $(document).on("click", ".btnBorrarArea", function () {
      id = parseInt($(this).closest("tr").find("td:eq(0)").text());
      opcion = 5; //eliminar
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará el Area permanentemente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "../../app/controllers/area-controller.php",
            type: "POST",
            datatype: "json",
            data: { opcion: opcion, id: id },
            beforeSend: function () {
              /* * Se ejecuta al inicio de la petición* */
              $("#loader").show();
            },
            success: function (response) {
              data = $.parseJSON(response);
              switch (data) {
                case 1:
                  MostrarAlerta(
                    "No se puede borrar",
                    "Existen documentos asociados a esta Área",
                    "error"
                  );
                  $("#loader").hide();
                  break;
                case 2:
                  MostrarAlerta(
                    "No se puede borrar",
                    "Existen empleados asociados a esta Área",
                    "error"
                  );
                  $("#loader").hide();
                  break;
                default:
                  MostrarAlertaxTiempo(
                    "Eliminado",
                    "Se eliminó el Área",
                    "success"
                  );
                  tablaAreas.ajax.reload(null, false); //Recargar la tabla
                  $("#loader").hide();
                  break;
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
  
  function llenarSelectAreas() {
    let opcion = 1;
    $.ajax({
      url: "../../app/controllers/area-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        let select = $("#select-area");
        let placeholderOption = $("<option></option>");
        placeholderOption.val("");
        placeholderOption.text("Seleccione...");
        placeholderOption.attr("disabled", true);
        placeholderOption.attr("selected", true);
        select.append(placeholderOption);
        // Recorre los datos devueltos y crea las opciones del select
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].IdAInst);
          option.text(data[i].area);
          select.append(option);
        }
        $("#loader").hide();
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  }
  
  function llenarSelectUsuarios() {
    let opcion = 6;
    $.ajax({
      url: "../../app/controllers/empleado-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        let select = $("#select-user");
        let placeholderOption = $("<option></option>");
        placeholderOption.val("");
        placeholderOption.text("Seleccione...");
        placeholderOption.attr("disabled", true);
        placeholderOption.attr("selected", true);
        select.append(placeholderOption);
        // Recorre los datos devueltos y crea las opciones del select
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].ID);
          option.text(data[i].Datos);
          select.append(option);
        }
        $("#loader").hide();
      },
      error: function (xhr, status, error) {
        // Manejar errores de la petición AJAX
        console.error("Error: " + error);
      },
    });
  }
  
  function generarCodigo(idtabla, posicion, caracter) {
    // Obtener el DataTable
    let table = $("#" + idtabla).DataTable();
    // Obtener los datos de la columna deseada
    let columnData = table.column(posicion).data();
    // Obtener el último registro de la columna
    let ultimoDato = columnData[columnData.length - 1];
  
    //   let Cod =
    //     caracter +
    //     ("000" + (parseInt(ultimoDato.substring(ultimoDato.length - 4)) + 1)).slice(
    //       -4
    //     );
    let Cod = caracter + ("0000" + parseInt(ultimoDato + 1)).slice(-5);
  
    // Imprimir el último registro
    return Cod;
  }
  