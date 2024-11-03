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
                            <h4 class="m-0">Informe de Trámites</h4>
                            <ol class="breadcrumb float-sm-right">
                                <li class="li-nav-info"><i class="nav-icon fas fa-file-contract"></i><?= $data['page_title'] ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header py-2">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8 col-lg-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-search mr-2"></i><b>Generar Informe</b></h3>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mt-2 mt-sm-0">
                                            <button type="button" id="btnLimpiarI" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body pb-0">
                                        <form id="form_informes" action="<?= base_url() ?>/Informes/getReportTramites" method="post" target="_blank">
                                            <div class="div_informes">
                                                <div class="row div_principal">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Estado del Documento</label><span class="span-required"></span>
                                                            <select class="form-control text-center font-w-600" name="estado" id="slct_estado" required>
                                                                <option value="0">TODOS</option>
                                                                <option value="PENDIENTE">PENDIENTES</option>
                                                                <option value="ACEPTADO">ACEPTADOS</option>
                                                                <option value="RECHAZADO">RECHAZADOS</option>
                                                                <option value="ARCHIVADO">ARCHIVADOS</option>
                                                                <option value="OBSERVADO">OBSERVADO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Fechas</label><span class="span-required"></span>
                                                            <select class="form-control text-center font-w-600" name="fecha" id="select_fechas" required>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <span class="span-red span-required-description"> Obligatorio </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-sm-4">
                                            <button type="submit" form="form_informes" class="btn btn-block bg-gradient-danger">
                                                <i class="nav-icon fas fa-file-pdf mr-1"></i><b>Generar Informe PDF</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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