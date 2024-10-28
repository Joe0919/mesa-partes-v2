<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte de <?= $entidad ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @page {
            margin: 140px 75px 35px;
        }

        :root {
            --main-color: #2874a6;
        }

        * {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            position: fixed;
            top: -85px;
            width: 100%;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid gray;
        }

        .header-table td {
            border-right: 1px solid gray;
            padding: 6px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 20%;
            text-align: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            float: left;
        }

        .text-header {
            padding: 0 5px;
            font-size: 8px;
            margin-left: 1rem;
            float: left;
        }

        .text-header strong {
            font-size: 13px;
        }

        .text-header .info-cell {
            width: 40%;
        }

        .info-cell {
            text-align: center;
        }

        .div-cell {
            background: red;
        }

        .titulo-cell {
            font-weight: bold;
            text-align: center;
        }

        .report-cell {
            width: 48%;
            font-size: 14px;
        }

        .report-cell table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-cell td {
            border: none;
            padding: 3px;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            width: 100%;
        }

        .footer-table {
            border-top: 1px solid gray;
            padding: 6px;
            vertical-align: middle;
            text-align: center;
            width: 100%;
        }

        .p-tipo {
            margin: 0;
        }

        .content {
            margin: 0 0 1rem;
        }

        .tabla_detalle {
            text-align: center;
            border-collapse: collapse;
            width: 100%;
        }

        .tabla_detalle td,
        .tabla_detalle th {
            border: 1px solid gray;
            padding: 0.4rem;
        }

        .tabla_detalle thead {
            background-color: var(--main-color);
            color: white;
        }

        .title-detalle,
        .p_tipo {
            margin: .7rem 0;
        }


        .title-detalle {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td class="info-cell">
                    <img src="<?= media() ?>/images/logo.png" alt="Logo" class="logo">
                    <div class="text-header">
                        <strong><?= $arrInst['razon'] ?></strong><br>
                        <span>Ruc: <?= $arrInst['ruc'] ?></span><br>
                        <span>Email: <?= $arrInst['email'] ?></span><br>
                        <span>Teléfono: <?= $arrInst['telefono'] ?></span>
                    </div>
                </td>
                <?php if ($orientacion == 'landscape') { ?>
                    <td class="titulo-cell">
                        MESA DE PARTES VIRTUAL
                    </td>
                <?php } ?>
                <td class="report-cell">
                    <table>
                        <tr>
                            <td><strong>Título de reporte:</strong></td>
                            <td></b><?= $entidad ?> Registrados</td>
                        </tr>
                        <tr>
                            <td><strong>Cantidad de Registros:</strong></td>
                            <td><?= count($data) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha y hora del Reporte:</strong></td>
                            <td><?= date("d/m/Y") . ' - ' . date("g:i:s a"); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>Página 1 de 5</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p class="p_tipo"><?= $descripcion ?></p>
        <?php if (count($data) > 0) { ?>
            <h2 class="title-detalle t1">DETALLE DE REPORTE:</h2>
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
            <h2 style="text-align: center;font-size: 20px">No se encontraron registros para este reporte</h2>
        <?php } ?>

    </div>

</body>

</html>