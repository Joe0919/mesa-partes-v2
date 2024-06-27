<?php require_once "../inc/Validacion/Validacion.php" ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "../inc/MainHead/MainHead.php" ?>

    <title>Informes | Mesa de Partes Virtual</title>
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
                            <a href="../tramites/" class="nav-link">
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
                            <a href="../tramites-enviados/" class="nav-link">
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
                            <a href="#" class="nav-link active">
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
                            <h4 class="m-0 font-weight-bold">MESA DE PARTES VIRTUAL</h3>
                        </div><!-- /.col -->
                        <div class="col-sm-2">
                            <ol class="breadcrumb float-sm-right">
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file"></i>Informes</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <main class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title font-weight-bold card-header-title">Generador de Informes</h3>
                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <form id="form_new_user" method="post">
                                            <div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="irol">Estado del Documento</label><span class="span-red"> (*)</span>
                                                            <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                                            <select class="form-control select-rol" name="irol" id="irol" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="irol">Rango de Fechas</label><span class="span-red"> (*)</span>
                                                            <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                                            <select class="form-control select-rol" name="irol" id="irol" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="irol">Año</label><span class="span-red"> (*)</span>
                                                            <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                                            <select class="form-control select-rol" name="irol" id="irol" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="irol">Mes</label><span class="span-red"> (*)</span>
                                                            <!-- <a class="btn btn-flat bg-success btn-a1">...</a> -->
                                                            <select class="form-control select-rol" name="irol" id="irol" required></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary" id="Actualizar">Actualizar Datos</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php

        require_once "../inc/Modals/Modals.php";

        require_once "../inc/MainFooter/MainFooter.php";


        ?>

    </div>
    <!-- ./wrapper -->

    <?php require_once "../inc/MainJS/MainJS.php" ?>

    <script src="busqueda.js"></script>

</body>

</html>