$(document).ready(function () {
  let idarea = $("#id_areaid").val();
  $(".overlay").hide();

  cargarDatosDashboard();

  function cargarDatosDashboard() {
    consultarDocsGeneral()
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 50));
      })
      .then(() => {
        return consultarDocsArea(idarea);
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 60));
      })
      .then(() => {
        return consultarRanking();
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 70));
      })
      .then(() => {
        return consultarDocsxPeriodo();
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 80));
      })
      .then(() => {
        return consultarIngresoDocs();
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 90));
      })
      .then(() => {
        return consultarProcesDocs();
      })
      .then(() => {
        return new Promise((resolve) => setTimeout(resolve, 100));
      })
      .catch((error) => {
        console.error("Ocurrió un error:", error);
      });
  }

  function consultarDocsGeneral() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "/Dashboard/getDocsGeneral",
        type: "GET",
        beforeSend: function () {
          $("#overlayGrafEstado").show();
        },
        success: function (response) {
          objData = JSON.parse(response);
          $("#span_cant_pendientes").text(objData[0].total_pendiente);
          $("#span_cant_aceptados").text(objData[0].total_aceptado);
          $("#span_cant_archivados").text(objData[0].total_archivado);
          $("#span_cant_rechazados").text(objData[0].total_rechazado);

          const totals = objData[0];
          const labels = [
            "Pendiente",
            "Aceptado",
            "Observado",
            "Rechazado",
            "Archivado",
          ];
          const values = [
            totals.total_pendiente,
            totals.total_aceptado,
            totals.total_observado,
            totals.total_rechazado,
            totals.total_archivado,
          ];

          crearGrafico({ labels: labels, values: values }, "bar", "grafico1");
          $("#overlayGrafEstado").hide();
          resolve();
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          reject(error); // Rechazamos la promesa en caso de error
        },
      });
    });
  }
  function consultarDocsArea(idarea) {
    return new Promise((resolve, reject) => {
      if (idarea != 0) {
        $.ajax({
          url: base_url + "/Dashboard/getDocsArea/" + idarea,
          type: "GET",
          beforeSend: function () {
            $("#overlayArea").show();
          },
          success: function (response) {
            objData = JSON.parse(response);
            $("#span_cant_pendientes_area").text(objData[0].total_pendiente);
            $("#span_cant_aceptados_area").text(objData[0].total_aceptado);
            $("#span_cant_archivados_area").text(objData[0].total_archivado);
            $("#span_cant_rechazados_area").text(objData[0].total_rechazado);
            $("#loader").hide();
            resolve(); // Resolvemos la promesa
          },
          error: function (error) {
            MostrarAlerta("Error", "Error al cargar los datos", "error");
            console.error("Error: " + error);
            $("#loader").hide();
            reject(error); // Rechazamos la promesa en caso de error
          },
        });
      } else {
        resolve(); // Resolvemos la promesa
      }
    });
  }
  function consultarRanking() {
    $("#overlayRanking").show();
    return new Promise((resolve, reject) => {
      tablaRanking = $("#tablaRanking").DataTable({
        destroy: true,
        language: {
          url: "Spanish.json",
        },
        ajax: {
          url: base_url + "/Dashboard/getRanking",
          dataSrc: "",
        },
        pageLength: 5,
        lengthChange: false,
        searching: false,
        info: false,
        paging: true,
        columns: [
          { data: "fila" },
          { data: "area" },
          { data: "total_documentos" },
        ],
        initComplete: function () {
          $("#overlayRanking").hide();
          resolve();
        },
        error: function (error) {
          reject(error);
        },
      });
    });
  }

  function consultarDocsxPeriodo() {
    $("#overlayPeriodo").show();
    return new Promise((resolve, reject) => {
      tablaDocsxTiempo = $("#tablaDocsxTiempo").DataTable({
        destroy: true,
        language: {
          url: "Spanish.json",
        },
        ajax: {
          url: base_url + "/Dashboard/getDocsxTiempo",
          dataSrc: "",
        },
        pageLength: 6,
        lengthChange: false,
        searching: false,
        info: false,
        paging: false,
        columns: [{ data: "fila" }, { data: "periodo" }, { data: "cantidad" }],
        initComplete: function () {
          $("#overlayPeriodo").hide();
          resolve();
        },
        error: function (error) {
          reject(error);
        },
      });
    });
  }

  function consultarIngresoDocs() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url:
          base_url + "/Dashboard/getIngresoDocs/" + $("#selectFiltro1").val(),
        type: "GET",
        beforeSend: function () {
          $("#overlayLineRegistrados").show();
        },
        success: function (response) {
          objData = JSON.parse(response);

          const labels = [];
          const values = [];

          objData.forEach((item) => {
            labels.push(item.fecha); // Agrega la fecha al array de labels
            values.push(item.cantidad); // Agrega la cantidad de documentos al array de values
          });

          crearGraficoLine(
            { labels: labels, values: values },
            "line",
            "grafico2"
          );
          $("#overlayLineRegistrados").hide();
          resolve();
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          reject(error); // Rechazamos la promesa en caso de error
        },
      });
    });
  }

  $("#selectFiltro1").change(function () {
    consultarIngresoDocs();
  });

  function consultarProcesDocs() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: base_url + "/Dashboard/getProcesDocs/" + $("#selectFiltro2").val(),
        type: "GET",
        beforeSend: function () {
          $("#overlayLineProcesados").show();
        },
        success: function (response) {
          objData = JSON.parse(response);

          const labels1 = [];
          const values1 = [];

          objData.forEach((item) => {
            labels1.push(item.fecha); // Agrega la fecha al array de labels
            values1.push(item.cantidad); // Agrega la cantidad de documentos al array de values
          });

          crearGraficoLine(
            { labels: labels1, values: values1 },
            "line",
            "grafico3"
          );
          $("#overlayLineProcesados").hide();
          resolve();
        },
        error: function (error) {
          MostrarAlerta("Error", "Error al cargar los datos", "error");
          console.error("Error: " + error);
          reject(error);
        },
      });
    });
  }
  $("#selectFiltro2").change(function () {
    consultarProcesDocs();
  });

  $("#prueba").click(function () {
    $.ajax({
      url: base_url + "/Dashboard/pruebaEmail",
      type: "POST",
      success: function (response) {
        if (response) {
          MostrarAlerta("Exito", "Revise su bandeja", "success");
        } else {
          MostrarAlerta("Error", "No se envio", "error");
        }
      },
      error: function (error) {
        MostrarAlerta("Error", "Error al cargar los datos", "error");
        console.error("Error: " + error);
      },
    });
  });
});

function crearGrafico(datos, tipoGrafico, canvas) {
  const ctx = document.getElementById(canvas).getContext("2d");

  const colores = [
    "rgba(75, 192, 192, 0.2)",
    "rgba(255, 99, 132, 0.2)",
    "rgba(255, 206, 86, 0.2)",
    "rgba(54, 162, 235, 0.2)",
    "rgba(153, 102, 255, 0.2)",
    "rgba(255, 159, 64, 0.2)",
  ];

  // Creamos un array de colores para el dataset
  const backgroundColors = colores.slice(0, datos.labels.length);
  const borderColors = colores.map((color) => color.replace("0.2", "1")); // Cambiar la opacidad para el borde

  const grafico = new Chart(ctx, {
    type: tipoGrafico,
    data: {
      labels: datos.labels, // Asumiendo que los datos tienen un campo 'labels'
      datasets: [
        {
          data: datos.values, // Asumiendo que los datos tienen un campo 'values'
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: false,
          max: Math.max(...datos.values) + 1, // Ajusta el valor máximo
          grid: {
            display: false,
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
      plugins: {
        legend: {
          display: false, // No mostrar la leyenda
        },
        // Usamos el plugin de datalabels para mostrar los valores
        datalabels: {
          anchor: "end",
          align: "end",
          color: "#000", // Color del texto
          formatter: (value) => {
            return value; // Muestra el valor
          },
        },
      },
    },
    plugins: [ChartDataLabels], // Asegúrate de incluir el plugin
  });
}

let graficos = {}; // Objeto para almacenar las instancias de los gráficos

function crearGraficoLine(datos, tipoGrafico, canvas) {
  // Destruir el gráfico existente si existe
  if (graficos[canvas]) {
    graficos[canvas].destroy();
  }

  const ctx = document.getElementById(canvas).getContext("2d");
  graficos[canvas] = new Chart(ctx, {
    type: tipoGrafico,
    data: {
      labels: datos.labels, // Asumiendo que los datos tienen un campo 'labels'
      datasets: [
        {
          data: datos.values, // Asumiendo que los datos tienen un campo 'values'
          fill: false,
          borderColor: "rgb(75, 192, 192)",
          tension: 0.1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: false,
          max: Math.max(...datos.values) + 2, // Ajusta el valor máximo
          grid: {
            display: false,
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        datalabels: {
          anchor: "end",
          align: "end",
          color: "#000",
          formatter: (value) => {
            return value;
          },
        },
      },
    },
    plugins: [ChartDataLabels],
  });
}
