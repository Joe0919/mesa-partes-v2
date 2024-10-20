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
