<?php require_once "../inc/Validacion/Validacion.php" ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "../inc/MainHead/MainHead.php" ?>

    <title>Trámites | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php require_once "../inc/Loader/Loader.php" ?>

    <div class="wrapper">

        <?php require_once "../inc/MainHeader/MainHeader.php" ?>

        <!-- Main Sidebar Container | Seccion de Links  -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a class="brand-link navbar-lightblue">
                <img id="inst_logo" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text span-logo" id="inst_desc">HACDP</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="../inicio/" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../usuarios/" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../areas/" class="nav-link">
                                <i class="nav-icon fas fa-door-closed"></i>
                                <p>
                                    Áreas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../empleados/" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Empleados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-file-pdf"></i>
                                <p>
                                    Trámites
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../nuevo-tramite/" class="nav-link">
                                <i class="nav-icon fas fa-file-upload"></i>
                                <p>
                                    Nuevo Trámite
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../tramites-recibidos/" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>
                                    Trámites Recibidos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../tramites-recibidos/" class="nav-link">
                                <i class="nav-icon fas fa-file-export"></i>
                                <p>
                                    Trámites Enviados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../busqueda/" class="nav-link">
                                <i class="nav-icon fas fa-search-minus"></i>
                                <p>
                                    Búsqueda de Trámites
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#ModalInformes" class="nav-link" data-toggle="modal">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>
                                    Informes
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-10 d-flex justify-content-center">
                            <h4 class="m-0 font-weight-bold">SISTEMA DE MESA DE PARTES VIRTUAL</h3>
                        </div><!-- /.col -->
                        <div class="col-sm-2">
                            <ol class="breadcrumb float-sm-right">
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file-pdf"></i>Trámites</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <main class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <section class="col-lg-12 ">
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title font-weight-bold card-header-title">Listado de Todos los Trámites Registrados</h3>
                                        <div>
                                            <!-- <button type="button" class="btn btn-success" data-toggle="modal" id="btn_new_file" title="Agregar nuevo registro">
                                                <i class="nav-icon fas fa-plus mr-1"></i>Nuevo Registro
                                            </button> -->
                                            <button type="button" class="btn btn-dark" title="Generar Reporte">
                                                <i class="nav-iconfas fas fa-file-pdf mr-1"></i>Generar Reporte
                                            </button>
                                        </div>
                                    </div>
                                    <!-- <a class="btn btn-flat btn-a bg-success" data-toggle="modal" id="Nuevo">
                                        <i class="nav-icon fas fa-plus"></i>Nuevo Registro </a> -->
                                </div><!-- /.card-header -->
                                <!-- /.card-header -->
                                <div class="card-body">

                                    <!-- <a Target="_blank" class="btn btn-flat btn-a bg-gray-dark" href="../../reporte/reporte-areas.php" id="ReportUsu">
                                        <i class="nav-iconfas fas fa-file-pdf"></i>Generar Reporte </a> -->
                                    <table id="tablaTramites" class="table table-hover table-data">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Expediente</th>
                                                <th rowspan="2">Fecha</th>
                                                <th rowspan="2">Tipo Doc</th>
                                                <th colspan="2">Remitente</th>
                                                <th colspan="2">Localización</th>
                                                <th rowspan="2">Estado</th>
                                                <th style="width:2px;" rowspan="2">Más...</th>

                                            </tr>
                                            <tr>
                                                <th>DNI</th>
                                                <th>Datos</th>
                                                <th>Origen</th>
                                                <th>Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- ESPACIO DE LLENADO AUTOMATICO DE LOS DATOS CORRESPONDIENTES -->

                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </section>
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </main>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
        require_once "Modals-tramite.php";

        require_once "../inc/Modals/Modals.php";

        require_once "../inc/MainFooter/MainFooter.php";


        ?>

    </div>
    <!-- ./wrapper -->

    <?php require_once "../inc/MainJS/MainJS.php" ?>

    <script src="tramite.js"></script>

</body>

</html>