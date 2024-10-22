<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper" id="wrapper_content">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Menu de Navegacion  -->
        <?php require_once "views/inc/MainSidebar/MainSidebar.php" ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="col d-flex justify-content-between">
                        <h4 class="m-0">Gestión de Áreas</h3>
                            <ol class="breadcrumb float-sm-right">
                                <li class="li-nav-info"><i class="nav-icon fas fa-door-closed"></i><?= $data['page_title'] ?></li>
                            </ol>
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
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-5 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                                            <h3 class="card-title text-bold card-header-title">Lista de Áreas</h3>
                                            <button type="button" id="btn_reload" class="btn btn-tool bg-color-gray p-1 px-2 m-0 ml-2 text-dark"
                                                data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool bg-color-gray p-1 px-2 m-0 ml-2 text-dark"
                                                data-card-widget="maximize" title="Maximizar">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-7 d-flex justify-content-center justify-content-md-end">
                                            <?php if ($_SESSION['permisosMod']['cre']) { ?>
                                                <button type="button" class="btn bg-gradient-success ml-2" data-toggle="modal" id="nueva_area" title="Agregar nuevo registro">
                                                    <i class="nav-icon fas fa-plus mr-1"></i>Nuevo Registro
                                                </button>
                                            <?php } ?>
                                            <?php if ($_SESSION['permisosMod']['rea']) { ?>
                                                <button type="button" class="btn bg-gradient-dark ml-2" onclick="window.open('<?= base_url()?>/Areas/getReportAreas', '_blank')" title="Generar Reporte">
                                                    <i class="nav-iconfas fas fa-file-pdf mr-1"></i>Generar Reporte
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaAreas" class="table table-hover table-data">
                                        <thead>
                                            <tr>
                                                <!-- Rellenamos etiquetas de las columnas desde cons.php -->
                                                <?php foreach (areasColumns as $value) : ?>
                                                    <th><?php echo $value; ?></th>
                                                <?php endforeach; ?>
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

        <div id="contentAjax"></div>
        <?php

        getModal('areas', 'area', $data);

        require_once "views/inc/Modals/Modals.php";

        require_once "views/inc/MainFooter/MainFooter.php";

        ?>

    </div>

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>

</body>

</html>