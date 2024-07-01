<?php
ob_start();  //activar el almacenamiento en buffer para guardar el html

require_once "validation.php";

require_once "../Tramite.php";
$tramite = new Tramite();

$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '0';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '0';
$anio = (isset($_POST['anio'])) ? $_POST['anio'] : '';
$mes = (isset($_POST['mes'])) ? $_POST['mes'] : '';
$desde = (isset($_POST['desde'])) ? convertirfecha($_POST['desde']) : '';
$hasta = (isset($_POST['hasta'])) ? convertirfecha($_POST['hasta'])  : '';

function convertirfecha($fecha)
{
    if (!is_string($fecha)) {
        return false;
    } else {
        if ($fecha == "") {
            return "";
        } else {
            $partes = explode("/", $fecha);
            return $partes[2] . "-" . $partes[1] . "-" . $partes[0];
        }
    }
}

$variable = "";
$valores = [];
$tipo = "";


// Si el estado es diferente a TODOS
if ($desde == '') {
    // Si no hay FECHA entre rangos
    if ($mes == '') {
        // SI no existe MES
        $variable = "and date_format(fechad, '%Y')= ? "; //Para agregar a la consulta
        $valores = [$anio]; //valores para agregar a la consulta
        $tipo = "Mostrando por Año: <b>" . $anio . "</b>"; //Detalle del reporte
    } else {
        // Existe MES
        $variable = "and date_format(fechad, '%Y')=? and date_format(fechad, '%m')=? ";
        $valores = [$anio, $mes];
        $meses = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
        $tipo = "Mostrando por Año: <b>" . $anio . "</b> y Mes de: <b>" . $meses[$mes - 1] . "</b>";
    }
} else {
    // Existe RANGO DE FECHAS
    $variable = "and fechad between ? and DATE_ADD(?, INTERVAL 1 DAY) ";
    $valores = [$desde, $hasta];
    $tipo = "Mostrando por Fechas entre: <b>" . $_POST['desde'] . "</b> hasta: <b>" . $_POST['hasta'] . "</b>";
}

if ($fecha == '0') {
    // SI QUIERE MOSTRAR TODOS 
    $variable = "";
    $valores = [];
    $tipo = "Mostrando <b>TODOS</b> los Trámites";
}

if ($estado != '0') {
    // Existe ESTADO DE TRAMITE
    $variable = $variable . " and estado= ?";
    array_push($valores, $estado);
    $tipo = $tipo . " con el Estado: <b>" . $estado . "</b>";
}

// GENERAMOS LA CONSULTA DESDE EL SERVIDOR
$tramites = $tramite->listarDocumentos(
    "ROW_NUMBER() OVER (ORDER BY idderivacion) N,nro_expediente expediente,  date_format(fechad, '%d/%m/%Y') Fecha, tipodoc, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, origen, area, estado",
    "where origen='EXTERIOR' $variable",
    $valores
);

$entidad = "Trámites";
?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte de Trámites</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --main-color: #2874a6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "roboto";
            font-size: 12px;
        }

        .t1 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .contenedor {
            padding: 95px;
            margin: 0;
            padding-bottom: 0;
        }

        .w-100 {
            width: 100%;
        }

        .header {
            margin-bottom: 2rem;
        }

        .header-img {
            width: 80px;
            height: 80px;
        }

        .img-right {
            float: right;
        }

        .col-center {
            text-align: center;
            line-height: normal;
        }

        .col-center p {
            margin-bottom: 3px;
        }

        .title {
            padding: 6px 0;
            color: white;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .div-datos {
            border: black 1px solid;
            border-radius: 10px;
            overflow: hidden;
        }

        .div-datos table td {
            width: 50%;
            padding: .5rem 2rem;
        }

        .tabla_datos thead {
            background-color: var(--main-color);
        }

        .tabla_datos {
            border-collapse: collapse;
            width: 100%;
        }

        .tabla_detalle {
            text-align: center;
            border-collapse: collapse;
            width: 100%;
        }

        .tabla_detalle td {
            border: gray 1px solid;
            padding: 0.4rem;
        }

        .tabla_detalle th {
            border: var(--main-color) 1px solid;
            padding: 0.4rem;
        }

        .tabla_detalle thead {
            background-color: var(--main-color);
            color: white;
        }

        .tabla_detalle tbody tr th {
            font-weight: 500;
        }

        .td-datos {
            text-align: left;
        }

        .p_tipo {
            margin-bottom: 10px;
        }
    </style>
</head>


<body>
    <div class="contenedor">
        <?php require_once "report-header.php" ?>

        <div class="div-datos w-100">
            <table class="tabla_datos w-100">
                <thead>
                    <tr>
                        <th colspan="2">
                            <p class="title">DATOS DEL REPORTE</p>
                        </th>
                    </tr>
                </thead>
                <tr>
                    <td>
                        <p><b>Reporte: </b><?php echo $entidad ?> Ingresados a SECRETARIA</p>
                    </td>
                    <td>

                        <p><b>Fecha: </b><?php echo date("d/m/Y"); ?></p>
                    </td>
                </tr>
                <tr>
                    <td>

                        <p><b>Cantidad de <?php echo $entidad ?> Encontrados: </b><?php echo count($tramites) ?></p>
                    </td>
                    <td>
                        <p><b>Hora: </b><?php echo date("g:i:s a");; ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <p class="p_tipo"><?php echo $tipo; ?></p>
        <h2 class="title-detalle t1">DETALLE DE TABLA DE TRÁMITES:</h2>
        <br>
        <table class="tabla_detalle">
            <thead>
                <tr>
                    <th><b>N°</b></th>
                    <th><b>EXPENDIENTE</b></th>
                    <th><b>F. REGISTRO</b></th>
                    <th><b>T. DOC.</b></th>
                    <th><b>DNI</b></th>
                    <th><b>REMITENTE</b></th>
                    <th><b>AREA ACTUAL</b></th>
                    <th><b>ESTADO ACTUAL</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($tramites as $row) {
                ?>
                    <tr>
                        <td><?php echo $row['N']; ?></td>
                        <td><?php echo $row['expediente']; ?></td>
                        <td><?php echo $row['Fecha']; ?></td>
                        <td><?php echo $row['tipodoc']; ?></td>
                        <td><?php echo $row['dni']; ?></td>
                        <td><?php echo $row['Datos']; ?></td>
                        <td><?php echo $row['area']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>

<?php
$html = ob_get_clean(); //guardamos el html en la variable
// echo $html;
require_once '../../../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true)); //Activamos visualizacion de imagenes
$dompdf->setOptions($options);
$dompdf->getOptions()->setDefaultFont('helvetica'); // asignamos la fuente
$dompdf->loadHtml($html); //cargar el html en memoria
$dompdf->setPaper("A4", "landscape"); //Tipo de Hoja y orientacion landscape o portrait
$dompdf->render(); // Generar el pdf en el navegador
$dompdf->stream('Reporte de Trámites HACDP.pdf', array('Attachment' => false)); // Desactivamos descarga por defecto y nombre de archivo
exit;
