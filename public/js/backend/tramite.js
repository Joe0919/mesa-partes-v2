let url,
  archivo,
  ok = false,
  Expediente,
  ruta,
  dniRemitente;

// equivalente a $(document).ready(function () {
$(function () {
  $("#loader").hide();
  $("#fileInfo").removeClass("d-none");
  $("#archivo").addClass("d-none");

  llenarSelectTipo();

  setTimeout(function () {
    llenarDatosTramite();
  }, 100);

  $("#idfile").change(function () {
    let resultado = validarArchivo(this); // Validar el archivo

    if (resultado === 0) {
      MostrarAlerta("Archivo Incorrecto", "Solo se aceptan PDFs", "error");
      $(this).val("");
    } else if (resultado === 2) {
      MostrarAlerta(
        "Demasiado grande",
        "El PDF debe tener menos de 10MB",
        "error"
      );
      $(this).val("");
    } else if (resultado === 1) {
      // Si el archivo es válido, continuar con la lógica
      let file = $(this).prop("files")[0];
      $("#archivo").addClass("d-none");

      // Mostrar la información del archivo
      let fileName = file.name;
      let fileSize = (file.size / 1024 / 1024).toFixed(2); // Convertir a MB
      $("#alias").text(fileName);
      $("#fileSize strong").text(fileSize);
      $("#fileInfo").removeClass("d-none"); // Mostrar el contenedor de información del archivo
      $("#link_doc").removeAttr("href").removeAttr("target");
      $("#fileSize").removeClass("d-none");
      $("#btnDescargar").addClass("d-none");
      $("#alias").removeAttr("title");
      $("#link_doc").attr({ title: file.name });
      ok = true;
      archivo = "";
    }
  });

  $("#btnEliminar").click(function () {
    // Limpiar el input de archivo
    $("#idfile").val("");
    $("#fileInfo").addClass("d-none");
    $("#alias").text("Documento");
    $("#fileSize strong").text("0.0");
    $("#archivo").removeClass("d-none");
  });

  $("#btnDescargar").click(function () {
    console.log(url);
    if (archivo !== "") {
      let a = document.createElement("a");
      a.href = url;
      a.download = ""; // Esto sugiere al navegador que descargue el archivo
      document.body.appendChild(a); // Añadir el <a> al DOM
      a.click(); // Simular un clic en el <a>
      document.body.removeChild(a); // Eliminar el <a> del DOM
    } else {
      MostrarAlerta("Accion no valida", "El archivo se eliminó", "error");
    }
  });

  $("#form_tramite_obs").on("submit", function (e) {
    e.preventDefault();
    let formulario = $(this);
    if ($("#idfile").val() == "") {
      MostrarAlerta(
        "Observaciones no Subsanadas",
        "Seleccione un nuevo PDF valido",
        "error"
      );
    } else {
      console.log(validarCampos(formulario));
      if (!validarCampos(formulario)) {
        MostrarAlerta(
          "Advertencia",
          "Por favor, complete todos los campos requeridos.",
          "error"
        );
      } else {
        alert(ruta);
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Al guardar no podra realizar ninguna modificación",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Continuar",
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData(this);
            formData.append("expediente", Expediente);
            formData.append("ruta", ruta);
            formData.append("dni", dniRemitente);
            formData.append("email", emailRemitente);
            $.ajax({
              url: `${base_url}/tramite/putTramite`,
              type: "POST",
              datatype: "json",
              data: formData,
              processData: false,
              contentType: false,
              beforesend: function () {
                $("#loader").show();
              },
              success: function (response) {
                console.log(response);
                objData = $.parseJSON(response);
                if (objData.status) {
                  MostrarAlerta(objData.title, objData.msg, "success");
                  $("#form_tramite_obs")[0].reset();
                  dniRemitente = "";
                  emailRemitente = "";
                  
                } else {
                  MostrarAlerta(objData.title, objData.msg, "error");
                }
              },
              error: function (error) {
                MostrarAlerta("Error", "Error al cargar los datos", "error");
                console.error("Error: " + error);
                $("#loader").hide();
              },
              complete: function () {
                $("#loader").hide();
              },
            });
          }
        });
      }
    }
  });
});

function llenarDatosTramite() {
  $.ajax({
    url: `${base_url}/Tramite/getTramite/${nro_expediente}`,
    type: "GET",
    datatype: "json",
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      objData = $.parseJSON(response);
      if (objData.status) {
        $("#tdExpediente").text(objData.data.nro_expediente);
        Expediente = objData.data.nro_expediente;
        $("#tdFecha").text(objData.data.Fecha);
        $("#tdRemitente").text(objData.data.Datos);
        $("#tdDNI").text(objData.data.dni);
        dniRemitente = objData.data.dni;
        $("#tdTel").text(objData.data.telefono);
        $("#tdRUC").text(objData.data.ruc_institu);
        $("#tdEntidad").text(objData.data.institucion);
        $("#tdDireccion").text(objData.data.direccion);
        $("#tdCorreo").text(objData.data.email);
        emailRemitente = objData.data.email;
        $("#tdObservaciones").text(objData.data.descrip);

        $("#select_tipo").val(objData.data.idtipodoc);
        $("#inrodoc").val(objData.data.nro_doc);
        $("#ifolios").val(objData.data.folios);
        $("#iasunto").val(objData.data.asunto);

        ruta = objData.data.archivo;

        url = base_url + "/public/" + ruta;

        $("#alias").text(extraerSubstring(ruta));
        $("#link_doc").attr({
          title: extraerSubstring(ruta),
        });
        $("#fileSize").addClass("d-none");

        $("#link_doc").attr({
          href: url,
          target: "_blank",
        });
      } else {
        MostrarAlerta(objData.title, objData.msg, "error");
      }
      $("#loader").hide();
    },
    error: function (error) {
      console.error("Error: " + error);
      MostrarAlerta("Error", "Error al cargar los datos", "error");
      $("#loader").hide();
    },
  });
}

function llenarSelectTipo() {
  $.ajax({
    url: `${base_url}/registro-tramite/getSelectTipo`,
    type: "GET",
    datatype: "json",
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (response) {
      data = $.parseJSON(response);
      let select = $("#select_tipo");
      let placeholderOption = $("<option></option>");
      placeholderOption.val("");
      placeholderOption.text("Seleccione tipo doc...");
      placeholderOption.attr("disabled", true);
      placeholderOption.attr("selected", true);
      select.append(placeholderOption);
      for (let i = 0; i < data.length; i++) {
        let option = $("<option></option>");
        option.val(data[i].idtipodoc);
        option.text(data[i].tipodoc);
        select.append(option);
      }
      $("#loader").hide();
    },
    error: function (error) {
      console.error("Error: " + error);
      MostrarAlerta("Error", "Error al cargar los datos", "error");
      $("#loader").hide();
    },
  });
}

function validarCampos(formulario) {
  let valido = true; // Variable para determinar si el formulario es válido

  // Selecciona todos los inputs requeridos dentro del formulario
  formulario.find("input[required]").each(function () {
    // Elimina espacios en blanco al inicio y al final
    const valor = $(this).val().trim();

    // Verifica si el valor está vacío después de eliminar espacios
    if (valor === "") {
      valido = false; // Si algún campo está vacío, cambia a false
    }
  });

  return valido; // Devuelve el resultado de la validación
}