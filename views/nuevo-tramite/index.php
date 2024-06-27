<?php require_once "../inc/Validacion/Validacion.php" ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "../inc/MainHead/MainHead.php" ?>

    <title>Nuevo Trámite | Mesa de Partes Virtual</title>
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
                            <a href="#" class="nav-link active">
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
                            <a href="../informes/" class="nav-link">
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
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file-pdf"></i>Nuevo Trámite</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <main class="content">

                <div class="container-fluid">
                    <div class="d-flex mb-3">
                        <!-- <button type="button" id="btnNuevoT" class="btn btn2 bg-gradient-success mr-2" title="Registrar nuevo Trámite"><i class="fa fa-plus"></i>Nuevo Trámite</button>
                        <button type="button" id="btnLimpiar" class="btn btn-block btn2 bg-gradient-danger mr-2" title="Borrar datos ingresados"><i class="fa fa-eraser"></i>Limpiar Campos</button>
                        <button type="button" id="btnSeguir" class="btn btn2 bg-gradient-purple mr-2" title="Hacer seguimiento de su tramite"><i class="fa fa-search"></i>Seguimiento</button> -->
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-plus-circle mr-1"></i><b>NUEVO TRÁMITE</b></h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" id="btnLimpiar" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <form id="form_tramite" enctype="multipart/form-data" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL REMITENTE</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <label>Tipo de Persona: </label><span class="span-red"> (*)</span>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="radio_natural" name="customRadio" checked value="natural">
                                                                    <label for="radio_natural" class="custom-control-label">Natural</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="radio_juridica" name="customRadio" value="juridica">
                                                                    <label for="radio_juridica" class="custom-control-label">Jurídica</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="div_juridica">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" id="idpersona" name="idpersona" readonly value="0">
                                                                <label>RUC </label><span class="span-red"> (*)</span>
                                                                <input type="text" class="form-control" id="iruc" name="iruc" onkeypress="return validaNumericos(event)" maxlength="11" minlength="11">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Entidad </label><span class="span-red"> (*)</span>
                                                                <input type="text" class="form-control" id="identidad" name="ientidad">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>DNI</label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" name="idni" id="idni" required title="Valide su DNI">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label>dfhsdh</label>
                                                                <input id="btn_validar" type="button" class="btn btn-success" value="Validar">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nombres </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" id="idnombre" name="inombre" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Apellido Paterno </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" id="idap" name="iappat" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Apellido Materno </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" id="idam" name="iapmat" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>N° Celular </label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control" id="idcel" onkeypress='return validaNumericos(event)' minlength="9" maxlength="9" required name="icel">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dirección </label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control" id="iddirec" required name="idir">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Correo</label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control" id="idemail" required name="iemail">
                                                            <i><b id="Vcorreo"></b></i>
                                                        </div>
                                                        <span class="span-red">(*) Campos Obligatorios </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL DOCUMENTO</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Tipo</label><span class="span-red"> (*)</span>
                                                            <select class="form-control select-tipo" name="itipo" id="select-tipo" required></select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>N° Documento </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" id="idnrodoc" onkeypress='return validaNumericos(event)' required name="n_doc">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>N° Folios </label><span class="span-red"> (*)</span>
                                                                    <input type="number" class="form-control" id="idfolios" required name="ifolios">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <label>Asunto </label><span class="span-red"> (*)</span>
                                                            <textarea class="form-control" rows="3" id="idasunto" placeholder="Ingrese el asunto del documento" required name="iasunto"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Adjuntar archivo (pdf.)</label><span class="span-red"> (*)</span>
                                                            <div class="file">
                                                                <p id="nom_pdf">
                                                                    <img src="../../public/images/pdf.png" width="25px">
                                                                    <span id="alias"></span>
                                                                </p>
                                                                <label for="idfile" id="archivo"><i class="nav-icon fas fa-upload mr-1"></i>Elige el Archivo...</label>
                                                                <input type="file" id="idfile" name="idfile" accept="application/pdf">
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-checkbox div-check">
                                                            <input class="form-check-input input-check" type="checkbox" id="check" name="check" value="option1" required>

                                                            <label for="check" class="form-check-label ml-1">Declaro que la
                                                                información proporcionada es válida y verídica.
                                                                Y Acepto que las comunicaciones sean enviadas a la dirección de correo y
                                                                celular que proporcione.<span class="span-red"> (*)</span></label>

                                                        </div>
                                                        <br>
                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn-block bg-success">
                                                                <i class="nav-icon fas fa-paper-plane mr-1"></i><b>Enviar Trámite</b></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
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

    <script src="nuevoTramite.js"></script>

</body>

</html>