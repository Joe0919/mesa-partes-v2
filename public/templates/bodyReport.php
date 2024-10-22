<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte de <?= $entidad ?></title>
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
            padding: 90px <?= $padding ?>;
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

        .text-left {
            text-align: left;
        }

        .p_tipo {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <table class="header w-100 mb-3">
            <tr>
                <td>
                    <img class="header-img" src="<?= media() ?>/images/sello.jpg">
                </td>
                <td class="col-center">
                    <h3 class="t1">HOSPITAL ANTONIO CALDAS DOMÍNGUEZ - POMABAMBA</h3>
                    <p><b>Dirección:</b> Carretera Norte KM 1 S/N - Huajtchacra</p>
                    <p><b>Teléfono:</b> 043-4510028</p>
                    <p><b>Email:</b> example_1234@gob.pe</p>
                </td>
                <td>
                    <img class="header-img img-right" src="<?= media() ?>/images/logo.jpg">
                </td>
            </tr>
        </table>
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
                        <p><b>Título de Reporte: </b><?= $entidad ?> Registrados</p>
                    </td>
                    <td>
                        <p><b>Fecha: </b><?= date("d/m/Y"); ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Cantidad de <?= $entidad ?> : </b><?= count($data) ?></p>
                    </td>
                    <td>
                        <p><b>Hora: </b><?= date("g:i:s a");; ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <p class="p_tipo"><?= $descripcion ?></p>
        <h3 class="title-detalle t1">DETALLE DE REPORTE:</h3>
        <br>
        <?php if (count($data) > 0) { ?>
            <table class="tabla_detalle">
                <thead>
                    <tr>
                        <?php
                        if (!empty($data)) {
                            $headers = array_keys($data[0]);
                            foreach ($headers as $header) {
                                echo "<th><b>" . htmlspecialchars($header) . "</b></th>";
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $item) {
                        echo "<tr>";
                        $columnIndex = 0;
                        foreach ($item as $value) {
                            if ($columnIndex == $AlignFila) {
                                echo "<td class='text-left'>" . htmlspecialchars($value) . "</td>";
                            } else {
                                echo "<td>" . htmlspecialchars($value) . "</td>";
                            }
                            $columnIndex++;
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>

            </table>
        <?php } else { ?>
            <h2 style="text-align: center;">No se encontraron registros para este reporte</h2>
        <?php } ?>
    </div>
</body>

</html>