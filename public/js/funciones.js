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
  });
}
function MostrarAlertaHtml(titulo, html, tipoalerta) {
  Swal.fire({
    title: titulo,
    html: html,
    icon: tipoalerta,
    showConfirmButton: true,
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
    confirmButtonText: "Entendido", // Cambia el texto del botón de confirmación
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

  // Si no se encuentra el carácter '/', retornar null o un mensaje
  if (ultimaPosicion === -1) {
    return null; // O puedes retornar un mensaje como "No se encontró '/'"
  }

  // Extraer el substring a partir de la posición siguiente al '/'
  return texto.substring(ultimaPosicion + 1);
}

function validarArchivo(input) {
  // Obtener el archivo seleccionado
  const archivo = input.files[0];

  // Si no se seleccionó ningún archivo (se canceló)
  if (!archivo) {
    return; // No hacer nada
  }

  // Validar si el archivo es un PDF
  if (archivo.type !== "application/pdf") {
    return 0; // Retorna 0 si el archivo no es un PDF
  }

  // Validar el tamaño del archivo (10 MB = 10 * 1024 * 1024 bytes)
  if (archivo.size > 10 * 1024 * 1024) {
    return 2; // Retorna 2 si el archivo es mayor a 10 MB
  }

  return 1; // Retorna 1 si el archivo es un PDF y cumple con el tamaño
}

// Agregar el evento change al input
const archivoInput = document.getElementById("idfile");

if (archivoInput) {
  archivoInput.addEventListener("change", function (event) {
    const resultado = validarArchivo(event.target);
    // Aquí puedes manejar el resultado como desees
  });
}
