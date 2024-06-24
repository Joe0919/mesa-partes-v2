$(document).ready(function () {
  $("#loader").show(); // Mostrar DIv de carga
  let id, expediente, archivo, ruc, idarea, area, estado, accion, dni, destino;
  opcion = 5;

  //Esperamos que se carguen los datos del usuario logueado
  setTimeout(function () {
    inicializarTabla();
  }, 100);

  function inicializarTabla() {
    opcion = 5;
    idarea = $("#id_areaid").val();
    area = $("#info-area").val();
    estado = $("#select_estado").val();
    /*=============================   MOSTRAR TABLA DE TRAMITES  ================================= */
    tablaTramitesRecibidos = $("#tablaTramitesRecibidos").DataTable({
      destroy: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      },
      ajax: {
        url: "../../app/controllers/tramite-controller.php",
        method: "POST", //usamos el metodo POST
        data: {
          opcion: opcion,
          area: area,
          estado: estado,
          idarea: idarea,
        },
        dataSrc: "",
      },
      columnDefs: [{ targets: -1, width: "10px" }],
      ordering: false,
      columns: [
        {
          data: "expediente",
          render: function (data, type) {
            return "<b>" + data + "</b>";
          },
        },
        { data: "Fecha" },
        { data: "tipodoc" },
        { data: "dni" },
        { data: "Datos" },
        { data: "origen" },
        { data: "area" },
        {
          data: "estado",
          render: function (data, type) {
            let color = "";
            switch (data) {
              case "PENDIENTE":
                color = "bg-black";
                break;
              case "ACEPTADO":
                color = "bg-success";
                break;
              case "RECHAZADO":
                color = "bg-danger";
                break;
              case "ARCHIVADO":
                color = "bg-primary";
                break;
            }
            return (
              '<span style="font-size:14px"  class="badge ' +
              color +
              '">' +
              data +
              "</span> "
            );
          },
        },
        {
          defaultContent: `<div class='text-center'>
              <div class='btn-group'>
                    <button class='btn btn-outline-dark btn-sm btn-table btnMas' title='Más Información'>
                      <i class='material-icons'>add_circle</i></button>
              </div>
            </div>`,
        },
        {
          //Personalizamos la columna dependiento del estado
          data: null,
          render: function (data, type, row) {
            let botones = "";
            switch (row.estado) {
              case "PENDIENTE":
                botones = `<button class='btn btn-success btn-sm btn-table btnAceptar' title='Aceptar Trámite'>
                          <i class='material-icons'>task_alt</i></button>`;
                break;
              case "ACEPTADO":
                botones = `<button class='btn btn-warning btn-sm btn-table btnSeguimiento' title='Ver Historial'>
                  <i class='material-icons'>search</i></button>
                  <button class='btn btn-danger btn-sm btn-table btnDerivar' title='Derivar Documento'>
                  <i class='material-icons'>output</i></button>`;
                break;
              default:
                botones = `<button class='btn btn-warning btn-sm btn-table btnSeguimiento' title='Ver Historial'>
                    <i class='material-icons'>search</i></button>`;
                break;
            }
            return `<div class='text-center'>
              <div class='btn-group'>
                    ${botones}
              </div>
            </div>`;
          },
        },
      ],
      initComplete: function () {
        // Oculta el loader una vez que los datos se hayan cargado
        $("#loader").hide();
        //Validamos que botones se deben de mostrar dependiendo del estado del tramite
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
      //El documento tiene otro estado
      MostrarAlerta(
        "Advertencia",
        "No es posible realizar esta accion",
        "error"
      );
    } else {
      opcion = 3;
      expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente
      dni = $(this).closest("tr").find("td:eq(3)").text(); //capturo el DNI
      $("#idnir").val(dni);
      $.ajax({
        url: "../../app/controllers/tramite-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, expediente: expediente },
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          data = $.parseJSON(response);
          if (data.length > 0) {
            $("#idderivacion").val(data[0]["ID"]);
            $("#iddocumento").val(data[0]["doc"]);
            $("#inrodoc_1").val(data[0]["nro_doc"]);
            $("#ifolio_1").val(data[0]["folios"]);
            $("#iexpediente_1").val(data[0]["nro_expediente"]);
            $("#iestado_1").val(data[0]["estado"]);
            $("#itipodoc_1").val(data[0]["tipodoc"]);
            $("#iasunto_1").val(data[0]["asunto"]);
            $("#modal_aceptacion").modal({
              backdrop: "static",
              keyboard: false,
            });
            $("#loader").hide();
          }
        },
        error: function (xhr, status, error) {
          // Manejar errores de la petición AJAX
          console.error("Error: " + error);
        },
      });
    }
  });

  //Realizar Accion de ACEPTAR o RECHAZAR el Tramite sea el Caso
  $(".btnGestion").click(function () {
    let idBoton = $(this).attr("id");

    opcion = 6;
    origen = $("#info-area").val();
    descripcion = $.trim($("#idescripcion").val().toUpperCase());
    id = $("#iddocumento").val();
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
          url: "../../app/controllers/tramite-controller.php",
          type: "POST",
          datatype: "json",
          data: {
            opcion: opcion,
            origen: origen,
            descripcion: descripcion,
            id: id,
            expediente: expediente,
            idni: idni,
            idderivacion: idderivacion,
            accion: accion,
          },
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (response) {
            $("#form_aceptacion")[0].reset();
            $("#modal_aceptacion").modal("hide");
            inicializarTabla();
            accion === "ACEPTAR"
              ? (accion = "ACEPTADO")
              : (accion = "RECHAZADO");
            MostrarAlerta("Hecho", `El trámite ha sido ${accion}`, "success");
            $("#loader").hide();
          },
          error: function (error) {
            // Manejar errores de la petición AJAX
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
      expediente = $(this).closest("tr").find("td:eq(0)").text(); //capturo el Nro expediente
      dni = $(this).closest("tr").find("td:eq(3)").text(); //capturo el DNI DEL remitente
      $("#expediente_d").val(expediente);
      $("#dni_d").val(dni);
      $("#idorigen").val($("#info-area").val());
      $("#p_expediente_d").text(expediente);
      $("#modal_derivacion").modal("show");
      opcion = 3;
      $.ajax({
        url: "../../app/controllers/tramite-controller.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion, expediente: expediente },
        beforeSend: function () {
          $("#loader").show();
        },
        success: function (response) {
          data = $.parseJSON(response);
          if (data.length > 0) {
            $("#iddoc_d").val(data[0]["doc"]);
            llenarSelectDestino();
            $("#select-destino").attr("required", "required");
          }
        },
        error: function (error) {
          console.error("Error: " + error);
        },
      });
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

  //Registrar o Editar los datos del formulario
  $("#form_derivacion").on("submit", function (e) {
    e.preventDefault();
    accion = $("#idaccion").val();
    destino = $("#select-destino option:selected").text();
    origen = $("#idorigen").val();
    let opcion = 8; // Opcion para el switch del controlador
    let formulario = $(this);
    let aux, titulo;
    accion === "1"
      ? ((aux = "DERIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> a <b>${destino}</b>.`))
      : ((aux = "ARCHIVAR"),
        (titulo = `¿Está seguro de ${aux}?`),
        (html = `El documento se va a <b>${aux}</b> en <b>${origen}</b>.`));
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
          formData.append("opcion", opcion);
          formData.append("accion", accion);
          $.ajax({
            url: "../../app/controllers/tramite-controller.php",
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
              accion === "1" ? (aux = "DERIVADO") : (aux = "ARCHIVADO");
              MostrarAlerta(
                `Hecho`,
                `El documento fue ${aux} correctamente`,
                "success"
              );
              $("#form_derivacion")[0].reset();
              $("#modal_derivacion").modal("hide");
              inicializarTabla();
              $("#loader").hide();
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
  });

  //Llenar el Select Con Areas distintas al actual
  function llenarSelectDestino() {
    // LLenar el select con opciones de tipos de documentos
    opcion = 7;
    area = $("#info-area").val();
    $.ajax({
      url: "../../app/controllers/tramite-controller.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion, area: area },
      beforeSend: function () {
        /* * Se ejecuta al inicio de la petición* */
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
        // Recorre los datos devueltos y crea las opciones del select
        for (let i = 0; i < data.length; i++) {
          let option = $("<option></option>");
          option.val(data[i].ID);
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

    // # NOTA: LA FUNCION DE MAS INFORMACION Y SEGUIMIENTO ESTAN EN MAIN.JS EN PUBLIC
});
