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
                    <div class="row mb-2">
                        <div class="col-sm-10 d-flex justify-content-center">
                            <h4 class="m-0 font-weight-bold">MESA DE PARTES VIRTUAL</h3>
                        </div>
                        <div class="col-sm-2">
                            <ol class="breadcrumb float-sm-right">
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file-export"></i><?= $data['page_title'] ?></li>
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
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title font-weight-bold card-header-title">Generador de Informes de Trámites</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body pb-0">
                                        <form id="form_informes" action="../../app/models/reports/report-documents.php" method="post" target="_blank">
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