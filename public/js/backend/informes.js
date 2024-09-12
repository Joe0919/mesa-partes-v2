$(document).ready(function () {
  let bdr = false;

  //LLenamos el select de fechas
  llenarSelect(
    "#select_fechas",
    ["TODOS", "POR AÑO", "POR AÑO Y MES", "POR RANGO DE FECHAS"],
    true
  );

  $("#select_fechas").change(function () {
    let sel = $(this).val();
    let contenidoHTML;
    switch (sel) {
      case "1":
        contenidoHTML = `
                  <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Año</label><span class="span-red"> (*)</span>
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
                              <label>Año</label><span class="span-red"> (*)</span>
                              <select class="form-control text-center font-w-600" name="anio" id="select_anio" required></select>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Mes</label><span class="span-red"> (*)</span>
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
                              <label>Rango de fechas</label><span class="span-red"> (*)</span>
                              <div class="input-daterange input-group" id="datepicker">
                                  <span class="input-group-addon mr-2">Desde: </span>
                                  <input type="text" class="input-sm form-control font-w-600" name="desde" id="desde" required/>
                                  <span class="input-group-addon mx-2"> hasta </span>
                                  <input type="text" class="input-sm form-control font-w-600" name="hasta" id="hasta" required/>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
        break;
    }
    $(".div_informes .div_principal").next().remove();
    $(".div_informes").append(contenidoHTML);

    switch (sel) {
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
        $("#sandbox-container .input-daterange").datepicker({
          language: "es",
          autoclose: true,
        });
        break;
    }
  });

  $(document).on("change", "#select_anio", function () {
    if (bdr) {
      $("#select_mes").empty();
      llenarSelectAjax(2, "#select_mes", $("#select_anio").val());
      $("#select_mes").prop("disabled", false);
    }
  });
  //  ***************** FUNCIONES *****************

  // Funcion general para llenar un select
  function llenarSelect(select, opciones, numerosAscendentes) {
    $("#loader").show();
    $(select).empty();
    let placeholderOption = $("<option></option>");
    placeholderOption.val("");
    placeholderOption.text("Seleccione...");
    placeholderOption.attr("disabled", true);
    placeholderOption.attr("selected", true);
    $(select).append(placeholderOption);

    opciones.forEach((opcion, index) => {
      let option = $("<option></option>");
      if (numerosAscendentes) {
        option.val(index);
        option.text(opcion);
      } else {
        option.val(opcion);
        option.text(opcion);
      }
      $(select).append(option);
    });

    $("#loader").hide();
  }

  function llenarSelectAjax(opcion, select1, anio = "") {
    // LLenar el select con opciones de tipos de documentos
    let select = $(select1);
    let dataToSend = { opcion: opcion };
    if (anio !== "") {
      dataToSend.anio = anio;
    }
    $.ajax({
      url: base_url + "/Tramites/getFechas",
      type: "POST",
      datatype: "json",
      data: dataToSend,
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        console.log(response);
        data = $.parseJSON(response);
        let placeholderOption = $("<option></option>");
        placeholderOption.val("");
        placeholderOption.text("Seleccione...");
        placeholderOption.attr("disabled", true);
        placeholderOption.attr("selected", true);
        select.append(placeholderOption);
        // Recorre los datos devueltos y crea las opciones del select
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");

          option.val(data[i].dato);

          if (opcion == 2) {
            let mes = darNombreMes(data[i].dato);
            option.text(mes);
          } else {
            option.text(data[i].dato);
          }
          select.append(option);
        }
        $("#loader").hide();
      },
      error: function (error) {
        console.error("Error: " + select1 + " " + error);
      },
    });
  }

  function darNombreMes(numeroMes) {
    const meses = [
      "ENERO",
      "FEBRERO",
      "MARZO",
      "ABRIL",
      "MAYO",
      "JUNIO",
      "JULIO",
      "AGOSTO",
      "SETIEMBRE",
      "OCTUBRE",
      "NOVIEMBRE",
      "DICIEMBRE",
    ];
    return meses[numeroMes - 1];
  }

  function convertirfecha(fecha) {
    if (typeof fecha != "string") {
      return false;
    } else {
      if (fecha == "") {
        return "";
      } else {
        let partes = fecha.split("/");
        return partes[2] + "-" + partes[1] + "-" + partes[0];
      }
    }
  }
});
