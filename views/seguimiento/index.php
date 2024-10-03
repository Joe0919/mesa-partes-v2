<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="<?php echo media() ?>/images/logo.wepb">
    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>

</head>

<body class="hold-transition sidebar-mini layout-fixed body">


    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper" id="wrapper_content">

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-xl bg-color-gray px-0">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header bg-color-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col d-flex justify-content-center">
                            <h3 class="m-0 font-weight-bold text-center">MESA DE PARTES VIRTUAL</h3>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content px-2">
                <div class="container-fluid">
                    <div class="d-flex my-3 justify-content-end">
                        <a href="<?= base_url(); ?>/registro-tramite" id="btnNuevoTramite" class="btn btn2 bg-gradient-success ml-2" title="Registrar nuevo Trámite">
                            <i class="fa fa-plus"></i>
                            <b>Nuevo Trámite</b>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-12" id="div_busqueda">
                            <div class="card card-info my-1" id="div_form">
                                <div class="card-header py-2">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8 col-lg-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-search mr-2"></i><b>SEGUIMIENTO DE TRÁMITES</b></h3>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mt-1">
                                            <button type="button" id="btnLimpiarB" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <form id="form_busqueda" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header bg-color-header2">
                                                        <h3 class="card-title text-bold">DATOS DEL TRÁMITE</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>N° Expediente </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" name="expediente" id="expediente_b" onkeypress='return validaNumericos(event)' required maxlength="6" minlength="6" title="Ingrese el N° de Expediente">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>DNI </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" name="dni" id="dni_b" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required title="Ingrese su DNI">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Año</label><span class="span-red"> (*)</span>
                                                                    <select class="form-control select-tipo text-center text-bold" name="anio" id="select-año" required>
                                                                        <?php
                                                                        $currentYear = date('Y');
                                                                        for ($i = $currentYear; $i >= 2020; $i--) {
                                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <span class="span-red">(*) Campos Obligatorios </span>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-block bg-gradient-blue">
                                                                    <i class="nav-icon fas fa-search mr-1"></i><b>Buscar Trámite</b></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="div_no_encontrado">
                                <div class="callout callout-warning">
                                    <div class="row">
                                        <div class="col-sm-3" align="right">
                                            <img class="img-no-search" src="<?= media() ?>/images/error-404.png">
                                        </div>
                                        <div class="col-sm-7">
                                            <br>
                                            <h2><i class="fas fa-exclamation-triangle text-warning"></i> TRÁMITE NO ENCONTRADO.</h2>

                                            <p class="lh-base">
                                                No se encontró el trámite con el expediente <b id="expediente-info"></b>
                                                y el DNI <b id="dni-info"></b> presentado el <b id="anio-info"></b>,
                                                tal vez colocó datos que no son los correctos.<br>
                                                <b>Por favor, intente realizar nuevamente la búsqueda ingresando los datos correctos.<b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-info" id="datos_buscados">
                                <div class="card-header">
                                    <h3 class="card-title font-w-600 d-flex-gap"><i class="fas fa-file-pdf "></i> DATOS DEL TRÁMITE ENCONTRADO
                                    </h3>
                                </div>
                                <!-- TABLA CON INFORMACION -->
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-danger ml-2" id="btnNuevaBusqueda"><i class="fa fa-search mr-2"></i>Nueva Búsqueda</button>
                                            <button type="button" class="btn bg-gradient-purple ml-2" id="btnHistorial"><i class="fa fa-plus mr-2"></i>Mostrar Historial</button>
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="callout callout-success">

                                                <table border="2" class="table-doc table-data" cellspacing="0" cellpadding="5" id="tableDoc">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                                <p class="font-w-600">DATOS DEL DOCUMENTO</p>
                                                                </font>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Expediente</th>
                                                            <td>
                                                                <p id="celdaexpe"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>N° Documento</th>
                                                            <td>
                                                                <p id="celdanro"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tipo</th>
                                                            <td>
                                                                <p id="celdatipo"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Asunto</th>
                                                            <td>
                                                                <p id="celdasunto"></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="callout callout-info">
                                                <table border="2" class="table-remitente table-data" cellspacing="0" cellpadding="5" id="tableRemitente">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                                <p class="font-w-600">DATOS DEL REMITENTE</p>

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>DNI</th>
                                                            <td>
                                                                <p id="celdadni"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Datos</th>
                                                            <td>
                                                                <p id="celdadatos"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>RUC</th>
                                                            <td>
                                                                <p id="celdaruc"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Entidad</th>
                                                            <td>
                                                                <p id="celdaenti"></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- LINEA DE TIEMPO DEL DOCUMENTO -->
                            <div id="linea_tiempo">

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- /CONTENIDO PRINCIPAL -->

        <?php

        require_once "views/inc/Modals/Modals.php";

        ?>

    </div>

    <!-- jQuery -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        const base_url = "<?= base_url(); ?>";
        const page_id = "<?= $data['page_id'] ?>";
    </script>
    <script src="<?= media() ?>/js/funciones.js"></script>
    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>