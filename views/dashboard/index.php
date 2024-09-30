<?php // require_once "views/inc/Validacion/Validacion.php" 
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Menu de Navegacion  -->
        <?php require_once "views/inc/MainSidebar/MainSidebar.php" ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-10 d-flex justify-content-center">
                            <h4 class="m-0 font-weight-bold">BIENVENIDO</h3>
                        </div><!-- /.col -->
                        <div class="col-sm-2">
                            <ol class="breadcrumb float-sm-right">
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-home"></i><?= $data['page_title'] ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <main class="content">
                <div class="container-fluid">

                    <button class="btn bg-black" id="prueba"> Enviar correo </button>

                    <!-- RESUMEN DE DOCUMENTOS GENERAL -->
                    <?php if ($_SESSION['userData']['idusuarios'] == 1) { ?>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-xl-3">
                                <a href="<?= base_url(); ?>/tramites" title="Administrar">
                                    <div class="info-box bg-gradient-info box-link">
                                        <span class="info-box-icon bg-gradient-info"><img src="<?= media() ?>/images/pendiente.png"></span>
                                        <div class="info-box-content content-lh">
                                            <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                            <span class="info-box-text1 info-box-count" id="span_cant_pendientes"></span>
                                            <span class="progress-description info-box-desc">Documentos</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <a href="<?= base_url(); ?>/tramites" title="Administrar">
                                    <div class="info-box bg-gradient-green box-link">
                                        <span class="info-box-icon bg-gradient-green"><img src="<?= media() ?>/images/aceptar.png"></span>
                                        <div class="info-box-content content-lh">
                                            <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                            <span class="info-box-text1 info-box-count" id="span_cant_aceptados"></span>
                                            <span class="progress-description info-box-desc">Documentos</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <a href="<?= base_url(); ?>/tramites" title="Administrar">
                                    <div class="info-box bg-gradient-purple box-link">
                                        <span class="info-box-icon bg-gradient-purple"><img src="<?= media() ?>/images/documentos.png"></span>
                                        <div class="info-box-content content-lh">
                                            <span class="info-box-text info-box-text1 info-box-title">ARCHIVADOS</span>
                                            <span class="info-box-text1 info-box-count" id="span_cant_archivados"></span>
                                            <span class="progress-description info-box-desc">Documentos</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-12 col-sm-6 col-xl-3">
                                <a href="<?= base_url(); ?>/tramites" title="Administrar">
                                    <div class="info-box bg-gradient-danger box-link">
                                        <span class="info-box-icon bg-gradient-danger icon"><img src="<?= media() ?>/images/rechazado.png"></span>
                                        <div class="info-box-content content-lh">
                                            <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                            <span class="info-box-text1 info-box-count" id="span_cant_rechazados"></span>
                                            <span class="progress-description info-box-desc">Documentos</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="row">
                        <section class="col-xl-6">
                            <!-- RESUMEN DE DOCUMENTOS EN EL AREA -->
                            <div class="card card-outline card-fuchsia">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-minus mr-1"></i>DOCUMENTOS EN: <strong id="area"><?= $_SESSION['userData']['area'] ?></strong></h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="<?= base_url(); ?>/tramites-recibidos" title="Administrar">
                                                <div class="info-box bg-gradient-info box-link">
                                                    <span class="info-box-icon bg-gradient-info"><img src="<?= media() ?>/images/pendiente.png"></span>
                                                    <div class="info-box-content content-lh">
                                                        <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                                        <span class="info-box-text1 info-box-count" id="span_cant_pendientes_area"></span>
                                                        <span class="progress-description info-box-desc">Documentos</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= base_url(); ?>/tramites-recibidos" title="Administrar">
                                                <div class="info-box bg-gradient-green box-link">
                                                    <span class="info-box-icon bg-gradient-green"><img src="<?= media() ?>/images/aceptar.png"></span>
                                                    <div class="info-box-content content-lh">
                                                        <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                                        <span class="info-box-text1 info-box-count" id="span_cant_aceptados_area"></span>
                                                        <span class="progress-description info-box-desc">Documentos</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= base_url(); ?>/tramites-recibidos" title="Administrar">
                                                <div class="info-box bg-gradient-purple box-link">
                                                    <span class="info-box-icon bg-gradient-purple"><img src="<?= media() ?>/images/documentos.png"></span>
                                                    <div class="info-box-content content-lh">
                                                        <span class="info-box-text info-box-text1 info-box-title">ARCHIVADOS</span>
                                                        <span class="info-box-text1 info-box-count" id="span_cant_archivados_area"></span>
                                                        <span class="progress-description info-box-desc">Documentos</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="<?= base_url(); ?>/tramites-recibidos" title="Administrar">
                                                <div class="info-box bg-gradient-danger box-link">
                                                    <span class="info-box-icon bg-gradient-danger icon "><img src="<?= media() ?>/images/rechazado.png"></span>
                                                    <div class="info-box-content content-lh">
                                                        <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                                        <span class="info-box-text1 info-box-count" id="span_cant_rechazados_area"></span>
                                                        <span class="progress-description info-box-desc">Documentos</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- GRÁFICO DE TRAMITES POR ESTADO -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Cantidad de Trámites por Estado</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="chart-responsive">
                                                <canvas class="grafico" id="grafico1"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="overlay dark" id="overlayGrafEstado"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

                            </div>
                        </section>
                        <section class="col-xl-6">
                            <!-- TABLA RANKING DE TRAMITES X AREA -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Ranking Trámites x Área </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaRanking" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Área</th>
                                                <th style="width: 40px">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overlay dark" id="overlayRanking"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                            </div>
                            <!-- TABLA TRAMITES REGISTRADOS POR PERIODO -->
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Trámites Registrados x Periodo</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaDocsxTiempo" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Periodo</th>
                                                <th style="width: 40px">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overlay dark" id="overlayPeriodo"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                            </div>
                        </section>
                    </div>

                    <div class="row">
                        <section class="col-12">
                            <!-- GRÁFICO DE TRAMITES REGISTRADOS X FECHA -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Trámites Ingresados x Fecha</h3>
                                    <div class="card-tools">
                                        <strong class="mr-2 mb-0">Filtrar: </strong>
                                        <select class="custom-select select-tramite" id="selectFiltro1">
                                            <option value="dia">Por día</option>
                                            <option value="semana">Por semana</option>
                                            <option value="mes">Por mes</option>
                                            <option value="anio">Por año</option>
                                        </select>
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div>
                                                <canvas class="grafico" id="grafico2"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="overlay dark" id="overlayLineRegistrados"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                            </div>
                        </section>
                        <section class="col-12">
                            <!-- GRÁFICO DE TRAMITES PROCESADOS X FECHA -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Trámites Procesados x Fecha</h3>
                                    <div class="card-tools">
                                        <strong class="mr-2 mb-0">Filtrar: </strong>
                                        <select class="custom-select select-tramite" id="selectFiltro2">
                                            <option value="dia">Por día</option>
                                            <option value="semana">Por semana</option>
                                            <option value="mes">Por mes</option>
                                            <option value="anio">Por año</option>
                                        </select>
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="chart-responsive">
                                                <canvas class="grafico" id="grafico3"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="overlay dark" id="overlayLineProcesados"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                            </div>
                        </section>
                    </div>

                </div>
            </main>
            <!-- /.content -->
        </div>
        <!-- /CONTENIDO PRINCIPAL -->
        <?php

        require_once "views/inc/Modals/Modals.php";

        require_once "views/inc/MainFooter/MainFooter.php";

        ?>

    </div>

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>



</body>

</html>