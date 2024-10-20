<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Menu de Navegacion  -->
        <?php require_once "views/inc/MainSidebar/MainSidebar.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col d-flex justify-content-between">
                            <h4 class="m-0">Gestión de Usuarios</h3>
                                <ol class="breadcrumb float-sm-right">
                                    <li class="li-nav-info"><i class="nav-icon fas fa-list"></i><?= $data['page_title'] ?></li>
                                </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content">
                <div class="container-fluid">
                    <div class="row">
                        <section class="col-12">
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-5 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                                            <h3 class="card-title text-bold card-header-title">Lista de Usuarios</h3>
                                            <button type="button" class="btn btn-tool bg-color-gray p-1 px-2 m-0 ml-2"
                                                data-card-widget="maximize" title="Maximizar">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-7 d-flex justify-content-center justify-content-md-end">
                                            <?php if ($_SESSION['permisosMod']['cre']) { ?>
                                                <button type="button" class="btn bg-gradient-success ml-2" data-toggle="modal" id="btn_new_user" title="Agregar nuevo registro">
                                                    <i class="nav-icon fas fa-plus mr-1"></i>Nuevo Registro
                                                </button>
                                                <button type="button" class="btn bg-gradient-dark ml-2" onclick="window.open('views/views/app/models/reports/report-users.php', '_blank')" title="Generar Reporte">
                                                    <i class="nav-iconfas fas fa-file-pdf mr-1"></i>Generar Reporte
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="tablaUsuarios" class="table table-hover table-data">
                                        <thead>
                                            <tr>
                                                <!-- Rellenamos etiquetas de las columnas desde cons.php -->
                                                <?php foreach (usuarioColumns as $value) : ?>
                                                    <th><?php echo $value; ?></th>
                                                <?php endforeach; ?>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- ESPACIO DE LLENADO AUTOMATICO DE LOS DATOS CORRESPONDIENTES -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>

        <?php
        require_once "Modals-usuario.php";

        require_once "views/inc/Modals/Modals.php";

        require_once "views/inc/MainFooter/MainFooter.php";


        ?>

    </div>
    <!-- ./wrapper -->

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>

</body>

</html>