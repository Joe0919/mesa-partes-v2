function validaNumericos(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  }
  return false;
}
function MostrarAlertaxTiempo(titulo, descripcion, tipoalerta) {
  Swal.fire({
    title: titulo,
    text: descripcion,
    icon: tipoalerta,
    showConfirmButton: false,
    timer: 2000,
    confirmButtonText: "Entendido",
  });
}
function MostrarAlertaHtml(titulo, html, tipoalerta) {
  Swal.fire({
    title: titulo,
    html: html,
    icon: tipoalerta,
    showConfirmButton: true,
    confirmButtonText: "Entendido",
  });
}

function ValidarFormato(formato) {
  var archivo = document.getElementById("idfile").value;
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  if (extensiones != formato) {
    return false;
  } else {
    return true;
  }
}

function resetHidden(form) {
  form[0].reset();
  form.find("input[type=hidden]").each(function () {
    $(this).val("0");
  });
}
function generarCodigo(idtabla, posicion, caracter, numCeros) {
  let table = $("#" + idtabla).DataTable();
  let columnData = table.column(posicion).data();
  let ultimoDato = columnData[columnData.length - 1];
  let numero = parseInt(ultimoDato) + 1;
  let ceros = "0".repeat(numCeros);
  let Cod = caracter + (ceros + numero).slice(-numCeros);

  return Cod;
}

function MostrarAlerta(titulo, descripcion, tipoalerta) {
  Swal.fire({
    title: titulo,
    text: descripcion,
    icon: tipoalerta,
    confirmButtonText: "Entendido",
  });
}

function verificarCampos(formulario) {
  let camposVacios = formulario.find("input[required]").filter(function () {
    return $.trim($(this).val()) === "";
  });

  return camposVacios.length === 0;
}

function ValidarCorreo(correo) {
  // let expReg = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  let expReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (expReg.test(correo)) {
    return true; // El correo electrónico es válido
  } else {
    return false; // El correo electrónico no es válido
  }
}

function extraerSubstring(texto) {
  let ultimaPosicion = texto.lastIndexOf("/");

  if (ultimaPosicion === -1) {
    return null;
  }
  return texto.substring(ultimaPosicion + 1);
}

function validarArchivo(input) {
  const archivo = input.files[0];

  if (!archivo) {
    return;
  }

  if (archivo.type !== "application/pdf") {
    return 0;
  }

  if (archivo.size > 10 * 1024 * 1024) {
    return 2;
  }

  return 1;
}

function validarCampos(formulario) {
  let valido = true;

  formulario.find("input[required]").each(function () {
    const valor = $(this).val().trim();

    if (valor === "") {
      valido = false;
      $(this).removeClass("is-valid").addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
    }
  });

  return valido;
}

// Agregar el evento change al input
const archivoInput = document.getElementById("idfile");

if (archivoInput) {
  archivoInput.addEventListener("change", function (event) {
    const resultado = validarArchivo(event.target);
    // Aquí puedes manejar el resultado como desees
  });
}

function generarNombreUsuario(nombre, apellido1, apellido2, numero) {
  nombre = nombre.trim();
  apellido1 = apellido1.trim();
  apellido2 = apellido2.trim();
  numero = numero.trim();

  let nombreUsuario = nombre.split(" ")[0];

  let iniciales =
    apellido1.charAt(0).toUpperCase() + apellido2.charAt(0).toUpperCase();

  let ultimosDigitos = numero.slice(-2);

  nombreUsuario =
    nombreUsuario.charAt(0).toUpperCase() +
    nombreUsuario.slice(1).toLowerCase();
  let resultado = nombreUsuario + iniciales + ultimosDigitos;

  return resultado;
}

function validarCamposRequeridos(formularioID) {
  $(
    `${formularioID} input[required], ${formularioID} select[required], ${formularioID} textarea[required]`
  ).on("blur", function () {
    // Ignorar checkboxes
    if ($(this).attr("type") === "checkbox") {
      return; // Si es un checkbox, no hacer nada
    }

    const valor =
      $(this).is("input") || $(this).is("textarea")
        ? $(this).val().trim()
        : $(this).val();

    // Validación para inputs de tipo email
    if ($(this).attr("type") === "email") {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar el formato del email
      if (!emailPattern.test(valor)) {
        $(this).removeClass("is-valid").addClass("is-invalid"); // Cambia a is-invalid
        return; // Salir de la función si no cumple
      }
    }

    // Validación para minlength
    const minlength = $(this).attr("minlength");
    if (minlength && valor.length < minlength) {
      $(this).removeClass("is-valid").addClass("is-invalid");
      return;
    }

    // Verifica si el valor está vacío
    if (valor === "" || valor === null) {
      $(this).removeClass("is-valid").addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
    }
  });
}

function eliminarValidacion(formularioID) {
  // Seleccionar los elementos con el atributo required dentro del formulario
  $(`${formularioID} input[required], ${formularioID} select[required], ${formularioID} textarea[required]`).each(function() {
    // Eliminar las clases is-invalid e is-valid de cada uno de los elementos
    $(this).removeClass("is-invalid is-valid");
  });
}

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

// LLenar el select con opciones de tipos de documentos
function llenarSelectAjax(opcion, select1, anio = "") {
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

function inicializarTablaTramites(tabla, controlador) {
  const url =
    base_url +
    "/" +
    controlador +
    "/getTramites/" +
    idarea +
    "/" +
    area.replace(/ /g, "+") +
    "/" +
    estado.replace(/ /g, "+");

  tabla = $("#" + tabla).DataTable({
    destroy: true,
    language: {
      url: "Spanish.json",
    },
    ajax: {
      url: url,
      dataSrc: "",
    },
    ordering: true,
    autoWidth: false,
    columns: [
      { data: "expediente" },
      { data: "Fecha" },
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

