$(document).ready(function () {
  let idarea = 0,
    accion = "";

  $("#loader").show();
  llenarSelectInst();
  /*=============================   MOSTRAR TABLA DE AREAS  ================================= */
  tablaAreas = $("#tablaAreas").DataTable({
    destroy: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "/Areas/getAreas",
      dataSrc: "",
    },
    ordering: false,
    columns: [
      { data: "ID" },
      { data: "cod_area" },
      { data: "area" },
      { data: "asociados" },
      { data: "opciones" },
    ],
    initComplete: function () {
      $("#loader").hide();
    },
  });

  //Mostrar modal de nueva area
  $("#nueva_area").click(function () {
    $("#form_area")[0].reset();
    $("#submitArea").text("Guardar");
    $("#modal-title-area").text("REGISTRAR NUEVA ÁREA");
    $("#idarea").val("0");
    $("#modal_area").modal({ backdrop: "static", keyboard: false });
    accion = "guardarán";
  });

  validarCamposRequeridos("#form_area");

  //Registrar o Editar los datos del formulario
  $("#form_area").on("submit", function (e) {
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
            url: base_url + "/Areas/setArea",
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
                $("#form_area")[0].reset();
                tablaAreas.ajax.reload(null, false);
                MostrarAlertaxTiempo(data.title, data.msg, "success");
                $("#modal_area").modal("hide");
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
    idarea = parseInt($(this).closest("tr").find("td:eq(0)").text());
    accion = "editarán";
    $("#form_area")[0].reset();
    $("#modal-title-area").text("EDITAR DATOS DE ÁREA");
    $.ajax({
      url: base_url + "/Areas/getArea/" + idarea,
      type: "GET",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        objData = $.parseJSON(response);
        if (objData.status) {
          $("#idarea").val(objData.data.idarea);
          $("#icodarea").val(objData.data.cod_area);
          $("#iarea").val(objData.data.area);
          $("#select_inst").val(objData.data.idinstitucion);

          $("#submitArea").text("Editar");
          $("#modal_area").modal({ backdrop: "static", keyboard: false });
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
    idarea = parseInt($(this).closest("tr").find("td:eq(0)").text());
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Se eliminará el área",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "" + base_url + "/Areas/delArea",
          type: "POST",
          datatype: "json",
          data: { idarea: idarea },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            data = $.parseJSON(response);
            if (data.status) {
              MostrarAlertaxTiempo(data.title, data.msg, "success");
              tablaAreas.ajax.reload(null, false);
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

  function llenarSelectInst() {
    $.ajax({
      url: base_url + "/Institucion/getSelectInst",
      type: "GET",
      datatype: "json",
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        let select = $("#select_inst");
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].idinstitucion);
          option.text(data[i].razon);
          select.append(option);
        }
        $("#loader").hide();
      },
      error: function (error) {
        console.error("Error: " + error);
      },
    });
  }
});
