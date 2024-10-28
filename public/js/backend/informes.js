$(document).ready(function () {
  let bdr = false;

  //LLenamos el select de fechas
  llenarSelect(
    "#select_fechas",
    ["TODOS", "POR AÑO", "POR AÑO Y MES", "POR RANGO DE FECHAS"],
    true
  );

  //Dibujamos segun seleccion
  $("#select_fechas").change(function () {
    let seleccion = $(this).val();
    let contenidoHTML;
    switch (seleccion) {
      case "1":
        contenidoHTML = `
                  <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Año</label><span class="span-required"></span>
                              <select class="form-control text-center font-w-600" name="anio" id="select_anio" required></select>
                          </div>
                      </div>
                  </div>
              `;
        break;
      case "2":
        contenidoHTML = `
                  <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Año</label><span class="span-required"></span>
                              <select class="form-control text-center font-w-600" name="anio" id="select_anio" required></select>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Mes</label><span class="span-required"></span>
                              <select class="form-control text-center font-w-600" name="mes" id="select_mes" required></select>
                          </div>
                      </div>
                  </div>
              `;
        break;
      case "3":
        contenidoHTML = `
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group" id="sandbox-container">
                              <label>Rango de fechas</label><span class="span-required"></span>
                              <div class="input-daterange input-group" id="datepicker">
                                  <span class="input-group-addon mr-2">Desde: </span>
                                  <input type="text" class="input-sm form-control font-w-600 desde" name="desde" id="desde" required/>
                                  <span class="input-group-addon mx-2"> hasta </span>
                                  <input type="text" class="input-sm form-control font-w-600 hasta" name="hasta" id="hasta" required/>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
        break;
    }
    $(".div_informes .div_principal").next().remove();
    $(".div_informes").append(contenidoHTML);

    switch (seleccion) {
      case "1":
        llenarSelectAjax(1, "#select_anio");
        bdr = false;
        break;
      case "2":
        llenarSelectAjax(1, "#select_anio");
        $("#select_mes").prop("disabled", true);
        bdr = true;
        break;
      case "3":
        initializeDatepickers();
        break;
    }
  });

  //Crear Select de Meses
  $(document).on("change", "#select_anio", function () {
    if (bdr) {
      $("#select_mes").empty();
      llenarSelectAjax(2, "#select_mes", $("#select_anio").val());
      $("#select_mes").prop("disabled", false);
    }
  });

  validarCamposRequeridos("#form_informes");

  $("#btnLimpiarI").click(() => {
    $("#form_informes").trigger("reset");
    $(".div_informes .div_principal").next().remove();
    eliminarValidacion("#form_informes");
  });

  let today = new Date();

  function initializeDatepickers() {
    $("#sandbox-container .input-daterange").datepicker({
      format: "dd/mm/yyyy",
      endDate: today,
      autoclose: true,
      language: "es",
    });
    // Sincronizar las fechas
    $(".input-daterange .desde").on("changeDate", function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $(this)
        .closest(".input-daterange")
        .find(".hasta")
        .datepicker("setStartDate", minDate);
    });

    $(".input-daterange .hasta").on("changeDate", function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $(this)
        .closest(".input-daterange")
        .find(".desde")
        .datepicker("setEndDate", maxDate);
    });
  }
});
