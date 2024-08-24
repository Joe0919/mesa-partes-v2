$(document).ready(function () {
  $("#loader").show();

  let idarea = $("#id_areaid").val();
  let area = $("#info-area").val();
  let estado = $("#select_estado").val();

  let iddocumento, expediente, dni, descripcion, idBoton;

  inicializarTabla();
  llenarSelectDestino();

  function inicializarTabla() {
    tablaTramitesRecibidos = $("#tablaTramitesRecibidos").DataTable({
      destroy: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      },
      ajax: {
        url:
          base_url +
          "/tramites-recibidos/getTramites/" +
          idarea +
          "/" +
          area.replace(/ /g, "+") + // Reemplaza espacios con +
          "/" +
          estado.replace(/ /g, "+"), // Reemplaza espacios con +
        dataSrc: "",
      },
      ordering: true,
      autoWidth: false,
      columns: [
        { data: "expediente" },
        { data: "Fecha" },
        { data: "tipodoc" },
        { data: "dni" },
        { data: "Datos" },
        { data: "origen" },
        { data: "area" },
        { data: "estado" },
        { data: "opciones" },
      ],
      initComplete: function () {
        $("#loader").hide();
      },
    });
  }

  $("#select_estado").on("change", function () {
    estado = $(this).val(); // Obtener el nuevo valor del select
    inicializarTabla(); // Llamar a la función inicializarTabla con el nuevo valor de estado
  });

  //Abrir Modal para Aceptar o Rechazar el Trámite
  $(document).on("click", ".btnAceptar", function () {
    //Validamos que el documento tenga el estado pendiente
    if ($.trim($(this).closest("tr").find("td:eq(7)").text()) !== "PENDIENTE") {
      MostrarAlerta(
        "Advertencia",
        "No es posible realizar esta accion",
        "error"
      );
    } else {
      expediente = $(this).closest("tr").find("td:eq(0)").text();
      dni = $(this).closest("tr").find("td:eq(3)").text();
      $("#idnir").val(dni);
      $("#modal-title").text("ACEPTAR/RECHAZAR TRÁMITE N°: " + expediente);
      $.ajax({
        url: base_url + "/Tramites/getTramite/" + expediente,
        type: "GET",
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          objData = $.parseJSON(response);
          if (objData.status) {
            $("#idderivacion").val(objData.data.idderivacion);
            $("#iddocumento").val(objData.data.iddocumento);
            $("#inrodoc_1").val(objData.data.nro_doc);
            $("#ifolio_1").val(objData.data.folios);
            $("#iexpediente_1").val(objData.data.nro_expediente);
            $("#iestado_1").val(objData.data.estado);
            $("#itipodoc_1").val(objData.data.tipodoc);
            $("#iasunto_1").val(objData.data.asunto);
            $("#modal_aceptacion").modal({
              backdrop: "static",
              keyboard: false,
            });
            $("#loader").hide();
          }
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          $("#loader").hide();
        },
      });
    }
  });

  //Realizar Accion de ACEPTAR o RECHAZAR el Tramite sea el Caso
  $(".btnGestion").click(function () {
    idBoton = $(this).attr("id");

    descripcion = $.trim($("#idescripcion").val().toUpperCase());
    iddocumento = $("#iddocumento").val();
    expediente = $("#iexpediente_1").val();
    idni = $("#idnir").val();
    idderivacion = $("#idderivacion").val();

    idBoton === "btnAceptarDoc" ? (accion = "ACEPTAR") : (accion = "RECHAZAR");

    Swal.fire({
      title: "¿Está seguro?",
      text: `Al ${accion} el documento no podrá deshacer la acción`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Continuar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + "/Tramites/putTramiteAceptacion",
          type: "POST",
          datatype: "json",
          data: {
            origen: area,
            descripcion: descripcion,
            iddocumento: iddocumento,
            expediente: expediente,
            dni: dni,
            idderivacion: idderivacion,
            accion: accion,
          },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            objData = $.parseJSON(response);
            if (objData.status) {
              $("#form_aceptacion")[0].reset();
              $("#modal_aceptacion").modal("hide");
              inicializarTabla();
              MostrarAlertaxTiempo(objData.title, objData.msg, "success");
            } else {
              MostrarAlerta(
                "Error",
                "Hubo problemas al realizar la accion",
                "error"
              );
            }
            $("#loader").hide();
          },
          error: function (error) {
            MostrarAlerta("Error", "Error al realizar accion.", "error");
            $("#loader").hide();
            console.error("Error: " + error);
          },
        });
      }
    });
  });

  //Mostrar modal para Derivar o Archivar
  $(document).on("click", ".btnDerivar", function () {
    if ($.trim($(this).closest("tr").find("td:eq(7)").text()) !== "ACEPTADO") {
      //El documento tiene otro estado
      MostrarAlerta(
        "Advertencia",
        "No es posible realizar esta accion",
        "error"
      );
    } else {
      expediente = $(this).closest("tr").find("td:eq(0)").text();
      dni = $(this).closest("tr").find("td:eq(3)").text();
      $("#expediente_d").val(expediente);
      $("#dni_d").val(dni);
      $("#idorigen").val(area);
      $("#p_expediente_d").text(expediente);
      $("#modal_derivacion").modal("show");
      $("#select-destino").attr("required", "required");
    }
  });

  //Ocultar Areas destino al solo ARCHIVAR
  $("#idaccion").change(function () {
    let sel = $(this).val();
    if (sel == "2") {
      $("#column").hide();
      $("#btnEnviarDerivacion").text("Archivar");
      $("#select-destino").removeAttr("required");
    } else {
      $("#column").show();
      $("#btnEnviarDerivacion").text("Derivar");
      $("#select-destino").attr("required", "required");
    }
  });

  //Derivar o Archivar el Trámite
  $("#form_derivacion").on("submit", function (e) {
    e.preventDefault();
    accion = $("#idaccion").val();
    destino = $("#select-destino option:selected").text();
    origen = $("#idorigen").val();
    dni = $("#dni_d").val();
    let formulario = $(this);
    let aux, titulo;
    accion === "1"
      ? ((aux = "DERIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> al área <b>${destino}</b>.`))
      : ((aux = "ARCHIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> en el area <b>${origen}</b>.`));
    if (verificarCampos(formulario)) {
      Swal.fire({
        title: titulo,
        html: html,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          var formData = new FormData(this);
          formData.append("accion", accion);
          formData.append("destino", destino);
          formData.append("dni", dni);
          $.ajax({
            url: base_url + "/Tramites/putTramiteDerivacion",
            type: "POST",
            datatype: "json",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              console.log(response);
              objData = $.parseJSON(response);
              if (objData.status) {
                $("#form_derivacion")[0].reset();
                $("#modal_derivacion").modal("hide");
                inicializarTabla();
                MostrarAlertaxTiempo(objData.title, objData.msg, "success");
              } else {
                MostrarAlerta(
                  "Error",
                  "Hubo problemas al realizar la accion",
                  "error"
                );
              }
              $("#loader").hide();
            },
            error: function (error) {
              MostrarAlerta("Error", "Error al realizar accion.", "error");
              $("#loader").hide();
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

  //Llenar el Select Con Areas distintas al actual
  function llenarSelectDestino() {
    // LLenar el select con opciones de tipos de documentos
    $.ajax({
      url: base_url + "/Tramites/getSelectDestino",
      type: "POST",
      datatype: "json",
      data: { area: area },
      beforeSend: function () {
        $("#loader").show();
      },
      success: function (response) {
        data = $.parseJSON(response);
        let select = $("#select-destino");
        let placeholderOption = $("<option></option>");
        placeholderOption.val("");
        placeholderOption.text("Seleccione destino...");
        placeholderOption.attr("disabled", true);
        placeholderOption.attr("selected", true);
        select.append(placeholderOption);
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].ID);
          option.text(data[i].area);
          select.append(option);
        }
        $("#loader").hide();
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al llenar áreas destino", "error");
        console.error("Error: " + error);
        $("#loader").hide();
      },
    });
  }
});
