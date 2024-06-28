<?php
ob_start();  //activar el almacenamiento en buffer para guardar el html

require_once "validation.php";

require_once "../Area.php";
$area = new Area();

$areas = $area->listarAreas(
    "ROW_NUMBER() OVER (ORDER BY idarea) N, cod_area, area",
    "area",
);

$entidad = "Áreas";

?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte de Áreas</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            font-size: 13px;
        }

        .t1 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .contenedor {
            padding: 85px 95px;
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
                        <p><b>Reporte: </b><?php echo $entidad ?> Registrados</p>
                    </td>
                    <td>

                        <p><b>Fecha: </b><?php echo date("d/m/Y"); ?></p>
                    </td>
                </tr>
                <tr>
                    <td>

                        <p><b>Cantidad de <?php echo $entidad ?> : </b><?php echo count($areas) ?></p>
                    </td>
                    <td>
                        <p><b>Hora: </b><?php echo date("g:i:s a");; ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <h3 class="title-detalle t1">DETALLE DE TABLA DE ÁREAS:</h3>
        <br>
        <table class="tabla_detalle">
            <thead>
                <tr>
                    <th><b>N°</b></th>
                    <th><b>CÓDIGO</b></th>
                    <th><b>ÁREA</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($areas as $row) {
                ?>
                    <tr>
                        <td><?php echo $row['N']; ?></td>
                        <td><?php echo $row['cod_area']; ?></td>
                        <td><?php echo $row['area']; ?></td>
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
$dompdf->setPaper("A4", "portrait"); //Tipo de Hoja y orientacion landscape o portrait
$dompdf->render(); // Generar el pdf en el navegador
$dompdf->stream('Reporte Areas HACDP.pdf', array('Attachment' => false)); // Desactivamos descarga por defecto y nombre de archivo
exit;
