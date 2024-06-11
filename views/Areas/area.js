$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  opcion = 1;
  /*=============================   MOSTRAR TABLA DE AREAS  ================================= */
  tablaAreas = $("#tablaAreas").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: "../../app/controllers/area-controller.php",
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
      { data: "cod_area" },
      { data: "area" },
      {
        defaultContent: `<div class='text-center'>
            <div class='btn-group'>
                <button class='btn btn-primary btn-sm btn-table btnEditarArea' title='Editar'>
                  <i class='material-icons'>edit</i></button>
                <button class='btn btn-danger btn-sm btn-table btnBorrarArea' title='Borrar'>
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

  llenarSelectInstitucion();

  //Mostrar modal de nuevo usuario
  $("#btn_new_area").click(function () {
    $("#icodarea").attr("readonly", false);
    $("#form_area")[0].reset();
    $("#submitArea").text("Guardar");
    $("#icodarea").val(generarCodigo("tablaAreas", 0, "A")); //Sugerimos un codigo
    $("#modal_area").modal({ backdrop: "static", keyboard: false });
  });

  //Registrar o Editar los datos del formulario
  $("#form_area").on("submit", function (e) {
    e.preventDefault();

    //SI NO HAY ID SERA INSERCIÓN
    if ($("#idarea").val() === "0") {
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
              url: "../../app/controllers/area-controller.php",
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
                      "Advertencia",
                      "Código o Area ya estan registrados",
                      "error"
                    );
                    $("#loader").hide();
                    break;
                  default:
                    $("#loader").hide();
                    $("#form_area")[0].reset();
                    tablaAreas.ajax.reload(null, false); //Recargar la tabla
                    MostrarAlertaxTiempo(
                      "Registrado",
                      "Los datos fueron registrados.",
                      "success"
                    );
                    $("#modal_area").modal("hide");
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
      let opcion = 4;
      let formulario = $(this);
      if (verificarCampos(formulario)) {
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se editarán los datos del area",
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
              url: "../../app/controllers/area-controller.php",
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
                      "Advertencia",
                      "Código o Area ya estan registrados",
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
                    $("#form_area")[0].reset();
                    $("#modal_area").modal("hide");
                    break;
                  default:
                    $("#loader").hide();
                    $("#form_area")[0].reset();
                    tablaAreas.ajax.reload(null, false); //Recargar la tabla
                    MostrarAlertaxTiempo(
                      "Actualizado",
                      "Los datos fueron actualizados.",
                      "success"
                    );
                    $("#modal_area").modal("hide");
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
  $(document).on("click", ".btnEditarArea", function () {
    opcion = 3;
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text()); //capturo el ID
    $("#form_area")[0].reset();
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

        $("#idarea").val(data["ID"]);
        $("#icodarea").val(data["cod_area"]);
        $("#icodarea").attr("readonly", true);
        $("#iarea").val(data["area"]);
        $("#inst").val(data["idinstitucion"]);

        $("#loader").hide();
        $("#submitArea").text("Actualizar");

        $("#modal_area").modal({ backdrop: "static", keyboard: false });
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

function llenarSelectInstitucion() {
  let opcion = 1;
  $.ajax({
    url: "../../app/controllers/institucion-controller.php",
    type: "POST",
    datatype: "json",
    data: { opcion: opcion },
    beforeSend: function () {
      /* * Se ejecuta al inicio de la petición* */
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      let select = $(".select-inst");
      // Recorre los datos devueltos y crea las opciones del select
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].idinstitucion);
        option.text(data[i].razon);
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
  let Cod =
    caracter +
    ("000" + (parseInt(ultimoDato + 1))).slice(
      -4
    );

  // Imprimir el último registro
  return Cod;
}
