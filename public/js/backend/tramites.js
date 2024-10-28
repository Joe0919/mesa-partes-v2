$(document).ready(function () {
  $("#loader").show();

  cargarVistaTramites();

  function cargarTabla() {
    idarea = $("#selectAreas").val();
    area = $("#selectAreas option:selected").text();
    estado = $("#selectEstados").val();
    inicializarTablaTramites("tablaTramites", "tramites");
  }

  $("#btnFiltrar").click(function () {
    cargarTabla();
  });

  function cargarVistaTramites() {
    llenarSelectAreasFiltrar()
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 50));
      })
      .then(() => {
        return cargarTabla();
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 60));
      })
      .catch((error) => {
        console.error("Ocurrió un error:", error);
      });
  }

  //Llenar el Select Con Areas para el Filtrado
  function llenarSelectAreasFiltrar() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "/Areas/getSelectAreas",
        type: "GET",
        datatype: "json",
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          data = $.parseJSON(response);
          let select = $("#selectAreas");
          let placeholderOption = $("<option></option>");
          placeholderOption.val("-1"); // al usar 0 el controlador no lo detecta
          placeholderOption.text("TODOS");
          placeholderOption.attr("selected", true);
          select.append(placeholderOption);
          for (let i = 0; i < data.length; i++) {
            let option = $("<option></option>");
            option.val(data[i].ID);
            option.text(data[i].area);
            select.append(option);
          }
          $("#loader").hide();
          resolve();
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al llenar áreas", "error");
          console.error("Error: " + error);
          $("#loader").hide();
          reject(error);
        },
      });
    });
  }

  $("#btnMostrarFiltro").on("click", function () {
    $("#divFiltro").collapse("toggle");

    $("#iconFiltro").toggleClass("fa-filter fa-times");
  });

  $("#btn_reload").click(function () {
    let tablaTramites = $("#tablaTramites").DataTable();
    tablaTramites.ajax.reload(null, false);
  });
});
