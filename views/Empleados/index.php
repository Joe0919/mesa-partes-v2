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
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-user-friends"></i><?= $data['page_title'] ?></li>
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
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title font-weight-bold card-header-title">Tabla General de Empleados</h3>
                                        <div>
                                            <?php if ($_SESSION['permisosMod']['cre']) { ?>
                                                <button type="button" class="btn btn-success" data-toggle="modal" id="nuevo_empleado" title="Agregar nuevo registro">
                                                    <i class="nav-icon fas fa-plus mr-1"></i>Nuevo Registro
                                                </button>
                                                <button type="button" class="btn btn-dark" onclick="window.open('views/views/app/models/reports/report-users.php', '_blank')" title="Generar Reporte">
                                                    <i class="nav-iconfas fas fa-file-pdf mr-1"></i>Generar Reporte
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaEmpleados" class="table table-hover table-data">
                                        <thead>
                                            <tr>
                                                <!-- Rellenamos etiquetas de las columnas desde cons.php -->
                                                <?php foreach (empleadosColumns as $value) : ?>
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

        getModal('empleados', 'empleados', $data);

        require_once "views/inc/Modals/Modals.php";

        require_once "views/inc/MainFooter/MainFooter.php";

        ?>

    </div>

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>

</body>

</html>