<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="sidebar-mini layout-fixed bg-principal">

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper contenedor">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Menu de Navegacion  -->
        <?php require_once "views/inc/MainSidebar/MainSidebar.php" ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col d-flex justify-content-between">
                            <h4 class="m-0">Vista de Trámites Enviados</h4>
                            <ol class="breadcrumb float-sm-right">
                                <li class="li-nav-info"><i class="nav-icon fas fa-file-export"></i><?= $data['page_title'] ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content">
                <div class="container-fluid">
                    <div class="row">
                        <section class="col-lg-12 ">
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="row row-cols-2">
                                        <div class="col-12 col-lg-7">
                                            <h3 class="card-title font-weight-bold card-header-title">Lista de Trámites Enviados desde <?= $_SESSION['userData']['area'] ?></span></h3>
                                            <button type="button" id="btn_reload" class="btn btn-tool bg-color-gray p-1 px-2 m-0 ml-2 text-dark"
                                                data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool bg-color-gray p-1 px-2 m-0 ml-2 text-dark"
                                                data-card-widget="maximize" title="Maximizar">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                        <div class="col-12 d-none d-md-block mt-1">
                                            <span>Fecha Registro:</span>
                                            <small class="badge badge-danger"><i class="far fa-clock"></i> 0-1 días</small>
                                            <small class="badge badge-warning"><i class="far fa-clock"></i> 2-4 días</small>
                                            <small class="badge badge-info"><i class="far fa-clock"></i> 5-7 días</small>
                                            <small class="badge badge-success"><i class="far fa-clock"></i> + 1 sem.</small>
                                            <small class="badge badge-secondary"><i class="far fa-clock"></i> + 1 mes</small>
                                            <small class="badge bg-purple"><i class="far fa-clock"></i> + 6 meses</small>
                                            <small class="badge bg-dark"><i class="far fa-clock"></i> + 1 año</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaTramitesEnviados" class="table table-hover table-data">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Expediente</th>
                                                <th rowspan="2">Fecha</th>

                                                <th colspan="2">Remitente</th>
                                                <th colspan="2">Localización</th>
                                                <th rowspan="2">Estado</th>
                                                <th rowspan="2">Acción</th>
                                            </tr>
                                            <tr>
                                                <th>DNI</th>
                                                <th>Datos</th>
                                                <th>Desde</th>
                                                <th>Hasta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
        <!-- /CONTENIDO PRINCIPAL -->

        <?php

        require_once "views/inc/Modals/Modals-tramites.php";

        require_once "views/inc/Modals/Modals.php";

        require_once "views/inc/MainFooter/MainFooter.php";

        ?>

    </div>

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>

</body>

</html>