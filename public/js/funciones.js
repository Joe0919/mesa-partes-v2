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
