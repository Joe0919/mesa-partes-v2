<?php // require_once "views/inc/Validacion/Validacion.php" 
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHead/MainHead.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Seccion de Links  -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a class="brand-link navbar-lightblue">
                <img src="<?php echo media() . "/" . $_SESSION['userData']['logo']; ?>" id="inst_logo" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text span-logo" id="inst_desc">HACDP</span>
            </a>

            <!-- Menu de Navegacion -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a class="nav-link active">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/usuarios" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/roles" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/areas" class="nav-link">
                                <i class="nav-icon fas fa-door-closed"></i>
                                <p>
                                    Áreas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/empleados" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Empleados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/tramites" class="nav-link">
                                <i class="nav-icon fas fa-file-pdf"></i>
                                <p>
                                    Trámites
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/nuevo-tramite" class="nav-link">
                                <i class="nav-icon fas fa-file-upload"></i>
                                <p>
                                    Nuevo Trámite
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/tramites-recibidos" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>
                                    Trámites Recibidos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/tramites-enviados" class="nav-link">
                                <i class="nav-icon fas fa-file-export"></i>
                                <p>
                                    Trámites Enviados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/busqueda" class="nav-link">
                                <i class="nav-icon fas fa-search-minus"></i>
                                <p>
                                    Búsqueda de Trámites
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url(); ?>/informes" class="nav-link">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>
                                    Informes
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                
            </div>
            <!-- /.Menu de Navegacion -->
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
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
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-home"></i>Inicio</li>
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
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="title-content-h3">
                                        <i class="ion ion-md-folder-open mr-1"></i><b>INFORMACIÓN DOCUMENTARIA GENERAL:<b>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-danger">
                                                <span class="info-box-icon bg-danger"><img src="<?= media() ?>/images/rechazado.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_rechazados"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <span class="info-box-icon bg-primary"><img src="<?= media() ?>/images/pendiente.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_pendientes"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-green">
                                                <span class="info-box-icon bg-green"><img src="<?= media() ?>/images/documentos.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_aceptados"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-header -->
                            </div>


                            <div class="card card-outline card-fuchsia">
                                <div class="card-header">
                                    <h3 class="title-content-h3">
                                        <i class="ion ion-md-folder-open mr-1"></i><b>RESUMEN DE TRÁMITES DEL ÁREA:
                                            <span id="info-area-desc" class="p-info"></span>
                                            <b>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-danger">
                                                <span class="info-box-icon bg-danger"><img src="<?= media() ?>/images/rechazado.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_rechazados_area"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <span class="info-box-icon bg-primary"><img src="<?= media() ?>/images/pendiente.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_pendientes_area"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-green">
                                                <span class="info-box-icon bg-green"><img src="<?= media() ?>/images/documentos.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                                    <span class="info-box-text1 info-box-count" id="span_cant_aceptados_area"></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-header -->
                            </div>
                        </section>
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
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

</body>

</html>