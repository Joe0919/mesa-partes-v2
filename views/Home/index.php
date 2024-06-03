<?php
require_once "../../app/config/config.php";
require_once "../../app/config/conexion.php";

if (!isset($_SESSION["idusuarios"])) {
    header("Location:" . URL . "views/Acceso/");
}

$iduser = $_SESSION["idusuarios"];
$foto = $_SESSION["foto"];
$dni = $_SESSION["dni"];

date_default_timezone_set('America/Lima');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mesa de Partes Virtual</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../app/templates/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../../public/icons/ionicons.css">
    <!-- Feather Icons -->
    <link rel="stylesheet" href="../../public/icons/feather.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../app/templates/AdminLTE/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="../../public/css/style.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="loader">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <div class="loader-text">Cargando...</div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan d-flex justify-content-between w-auto">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <h3 class="font-weight-bold h6 m-0">
                        USUARIO: <span id="info-datos" class="font-weight-normal"></span>
                    </h3>
                    <input id="idareaid" type="hidden">
                    <input id="info-area" type="hidden">
                    <input id="idinstitu" name="idinstitu" type="hidden">
                    <input id="iduser" name="iduser" type="hidden" value="<?php echo $iduser; ?>">
                    <input id="dniuser" name="dniuser" type="hidden" value="<?php echo $dni; ?>">
                    <input id="foto_user" name="foto_user" type="hidden" value="<?php echo $foto; ?>">
                </li>
                <li class="nav-item d-flex align-items-center ml-5">
                    <h3 class="font-weight-bold h6 m-0">ÁREA: <span id="info-area1" class="font-weight-normal"></span></h3>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav d-flex align-items-center">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge h5">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="demo-navbar-user nav-item dropdown">
                        <a class="nav-link dropdown-toggle m-0 py-0 d-flex align-items-center" href="#" data-toggle="dropdown">
                            <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                <img src="../../public/<?php echo $foto ?>" alt class="d-block rounded-circle" style="max-width: 35px;">
                                <span class="px-1 mr-lg-2 ml-2 ml-lg-0 font-name">
                                    <?php
                                    $utf8_string = $_SESSION['nombre'];
                                    $iso8859_1_string = mb_convert_encoding($utf8_string, 'ISO-8859-1', 'UTF-8');
                                    echo $iso8859_1_string
                                    ?>
                                </span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item btn-general" id="conf-inst" data-toggle="modal">
                                <i class="feather icon-info text-muted"></i><span class="ml-1">Institución</span></a>
                            <a class="dropdown-item btn-general" id="conf-perfil" data-toggle="modal">
                                <i class="feather icon-settings text-muted"></i><span class="ml-1">Datos del Perfil</span></a>
                            <a class="dropdown-item btn-general" id="conf-foto" data-toggle="modal">
                                <i class="feather icon-user text-muted"></i><span class="ml-1">Cambiar Foto</span></a>
                            <a class="dropdown-item btn-general" id="conf-psw" data-toggle="modal">
                                <i class="feather icon-settings text-muted"></i><span class="ml-1">Cambiar Contraseña</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-general" data-toggle="modal" href="#mimodal">
                                <i class="feather icon-power text-danger"></i><span class="ml-1">Salir</span></a>
                        </div>

                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a class="brand-link navbar-lightblue">
                <img src="../../app/templates/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text span-logo">HACDP</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../Usuarios/" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/Areas/" class="nav-link">
                                <i class="nav-icon fas fa-door-closed"></i>
                                <p>
                                    Áreas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/Empleados/" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Empleados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/Tramites/" class="nav-link">
                                <i class="nav-icon fas fa-file-pdf"></i>
                                <p>
                                    Trámites
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/NuevoTramite/" class="nav-link">
                                <i class="nav-icon fas fa-file-upload"></i>
                                <p>
                                    Nuevo Trámite
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/TramitesRecibidos/" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>
                                    Trámites Recibidos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/TramitesEnviados/" class="nav-link">
                                <i class="nav-icon fas fa-file-export"></i>
                                <p>
                                    Trámites Enviados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../../view/Busqueda/" class="nav-link">
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-10 d-flex justify-content-center">
                            <h4 class="m-0 font-weight-bold">SISTEMA DE MESA DE PARTES VIRTUAL</h3>
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
                                                <span class="info-box-icon bg-danger"><img src="../../public/images/rechazado.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                                    <span class="info-box-text1 info-box-count">20</span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <span class="info-box-icon bg-primary"><img src="../../public/images/pendiente.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                                    <span class="info-box-text1 info-box-count">20</span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-green">
                                                <span class="info-box-icon bg-green"><img src="../../public/images/documentos.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                                    <span class="info-box-text1 info-box-count">20</span>
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
                                        <i class="ion ion-md-folder-open mr-1"></i><b>RESUMEN DE TRÁMITES DEL ÁREA:<b>
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-danger">
                                                <span class="info-box-icon bg-danger"><img src="../../public/images/rechazado.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">RECHAZADOS</span>
                                                    <span class="info-box-text1 info-box-count"><b id="cantR">10</b></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-primary">
                                                <span class="info-box-icon bg-primary"><img src="../../public/images/pendiente.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">PENDIENTES</span>
                                                    <span class="info-box-text1 info-box-count"><b id="cantP">10</b></span>
                                                    <span class="progress-description info-box-desc">Total de Documentos</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box bg-green">
                                                <span class="info-box-icon bg-green"><img src="../../public/images/documentos.png"></span>
                                                <div class="info-box-content content-lh">
                                                    <span class="info-box-text info-box-text1 info-box-title">ACEPTADOS</span>
                                                    <span class="info-box-text1 info-box-count"><b id="cantA">10</b></span>
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
        <!-- /.content-wrapper -->

        <!-- MODAL DATOS INSTITUCIÓN-->
        <div class="modal fade" id="modalinstitu">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="form-institucion" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title modal-title-weight">DATOS DE LA INSTITUCIÓN:</h4>
                            <b id="idc" class="b-modal-info"></b>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="idinst" id="idinst">
                                <label>RUC <span class="span-red"> (*)</span></label>
                                <input type="text" class="form-control" name="iruci" id="iruci" onkeypress='return validaNumericos(event)' maxlength="11" minlength="11" required>
                            </div>
                            <div class="form-group">
                                <label>Razón <span class="span-red"> (*)</span></label>
                                <input type="text" class="form-control" name="irazoni" id="irazoni" required>
                            </div>
                            <div class="form-group">
                                <label>Dirección <span class="span-red"> (*)</span></label>
                                <input type="text" class="form-control" name="idirei" id="idirei" required>
                                <b id="error3"></b>
                            </div>
                            <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn1 btn-danger" data-dismiss="modal" id="SalirI">Cancelar </button>
                            <button type="submit" class="btn btn1 btn-primary" id="BtnEditInsti">Editar datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL EDICIÓN DE USUARIO-->
        <div class="modal fade" id="modalUsu">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formperfil" method="post">
                        <div class="modal-header" id="modal-header">
                            <h4 class="modal-title modal-title-weight" id="modal-title">DATOS DEL PERFIL DEL USUARIO</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="idusu" id="idusup">
                            <input type="hidden" class="form-control" name="idper" id="idperp">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>DNI</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="idni" id="idnip" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nombres</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="inombre" id="inombrep" require onkeyup="this.value = this.value.toUpperCase();" d>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="iappat" id="iappatp" required onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apellido Materno</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="iapmat" id="iapmatp" required onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Celular</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="icel" id="icelp" required onkeypress='return validaNumericos(event)' maxlength="9" minlength="9">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Dirección</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="idir" id="idirp" required onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputMessage">Email</label><span class="span-red"> (*)</span>
                                        <input type="email" class="form-control" name="iemail" id="iemailp" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nombre Usuario</label><span class="span-red"> (*)</span>
                                        <input type="text" class="form-control" name="inomusu" id="inomusup" required>
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
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- MODAL FOTO-->
        <div class="modal fade" id="modalfotop">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title modal-title-weight">ACTUALIZAR FOTO DE PERFIL:</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="FormFotop" method="post">
                        <div class="modal-body modal-body-center">
                            <h1 class="modal-body-title mb-2">Foto de perfil Actual</h1>
                            <figure class="modal-photo" id="foto_perfil">
                            </figure>
                            <div class="form-group">
                                <label>Elegir Foto (jpg)</label><span class="span-red"> (*)</span>
                                <div class="file-photo">
                                    <input type="hidden" id="opcion" name="opcion" value='5'>
                                    <input type="hidden" id="iddni2" name="idni" value="<?php echo $dni; ?>">
                                    <input type="hidden" id="idusua2" name="idusu" value="<?php echo $iduser; ?>">
                                    <input type="file" id="idfilep" name="idfile" required accept="images/*"">
                                </div>
                            </div>
                            <span class=" span-red font-weight-normal">(*) Campos Obligatorios </span>
                                </div>
                                <div class=" modal-footer justify-content-between">
                                    <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">Cancelar </button>
                                    <button type="submit" class="btn btn1 btn-primary" id="CambiarP">Cambiar</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL CAMBIO DE CONTRASEÑA-->
        <div class="modal fade" id="modaleditpswG">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-psw" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title modal-title-weight">CAMBIO DE CONTRASEÑA:</h4>
                            <b id="idc" class="b-modal-info"></b>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <p class="font-weight-normal span-gray">La nueva contraseña debe tener mas de 8 caracteres. Debe contener mayúsculas, minusculas, números y caracteres especiales (=?/&%$_)</p>
                            </div>
                            <div class="form-group">
                                <label>Contraseña Actual<span class="span-red"> (*)</span></label>
                                <input type="password" class="form-control" name="icontra" id="icontra" required minlength="8"/>
                            </div>
                            <div class="form-group">
                                <label>Contraseña Nueva<span class="span-red"> (*)</span></label>
                                <input type="password" class="form-control" name="inewcontra" id="inewcontra" required minlength="8"/>
                            </div>
                            <div class="form-group">
                                <label>Confirmar nueva contraseña<span class="span-red"> (*)</span></label>
                                <input type="password" class="form-control" name="iconfirmpsw" id="iconfirmpsw" required minlength="8"/>
                                <b id="error3"></b>
                            </div>
                            <span class="span-red font-weight-normal">(*) Campos Obligatorios </span>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="SalirC">Cancelar </button>
                            <button type="submit" class="btn btn-primary" id="BtnContraG">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- MODAL CONFIRMACION CERRAR SESION -->
        <div class="modal fade" id="mimodal" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmación:</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-normal">¿Seguro que quiere cerrar la Sesión Actual?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn1 btn-danger" data-dismiss="modal">No. Continuar </button>
                        <button type="button" class="btn btn1 btn-primary" onclick="salir()">Sí. Salir</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; <?php echo date("Y") ?> <a href="http://localhost/MesaPartesVirtual/"> Hospital Antonio Caldas Domínguez</a>.</strong>
            Todos los derechos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../app/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../app/templates/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="../../public/js/main.js"></script>

    <!-- Bootstrap 4 -->
    <script src="../../app/templates/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE App -->
    <script src="../../app/templates/AdminLTE/dist/js/adminlte.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>