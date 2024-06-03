<?php
require_once "../../app/config/config.php";
require_once "../../app/config/conexion.php";
require_once "../../app/config/cons.php";

if (!isset($_SESSION["idusuarios"])) {
    header("Location:" . URL . "views/Acceso/");
}

$iduser = $_SESSION["idusuarios"];
$foto = $_SESSION["foto"];
$dni = $_SESSION["dni"];
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
    <link rel="stylesheet" href="../../app/templates/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../app/templates/AdminLTE/dist/css/adminlte.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos principales -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
                        USUARIO: <span class="font-weight-normal">ROGER MARTIN MARTINEZ JAMANCA</span>
                    </h3>
                    <input id="idareaid" name="idarealogin" type="hidden" value="">
                    <input id="idarealogin" name="idarealogin" type="hidden" value="">
                    <input id="idinstitu" name="idinstitu" type="hidden" value="">
                    <input id="iduser" name="iduser" type="hidden" value="<?php echo $iduser; ?>">
                    <input id="dniuser" name="dniuser" type="hidden" value="<?php echo $dni; ?>">
                </li>
                <li class="nav-item d-flex align-items-center ml-5">
                    <h3 class="font-weight-bold h6 m-0">ÁREA: <span class="font-weight-normal">SECRETARIA</span></h3>
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

                            <a class="dropdown-item btn-general" id="institut" data-toggle="modal">
                                <i class="feather icon-info text-muted"></i><span class="ml-1">Institución</span></a>
                            <a class="dropdown-item btn-general" id="Fot" data-toggle="modal">
                                <i class="feather icon-user text-muted"></i><span class="ml-1">Cambiar Foto</span></a>
                            <a class="dropdown-item btn-general" id="Conf" data-toggle="modal">
                                <i class="feather icon-settings text-muted"></i><span class="ml-1">Datos del Perfil</span></a>
                            <a class="dropdown-item btn-general" id="contra" data-toggle="modal">
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
                            <a href="../Home/" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active ">
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
                            <div class="card card-danger card-outline">
                                <div class="card-header">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title font-weight-bold card-header-title">Listado de Usuarios Registrados</h3>
                                        <div>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                                                <i class="nav-icon fas fa-plus mr-1"></i>Nuevo Registro
                                            </button>
                                            <button type="button" class="btn btn-dark">
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
                                        <tfoot>
                                            <tr>
                                                <?php foreach (usuarioColumns as $value) : ?>
                                                    <th><?php echo $value; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </tfoot>
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
        <footer class="main-footer">
            <strong>Copyright &copy; <?php echo date("Y") ?> <a href="http://localhost/MesaPartesVirtual/"> Hospital Antonio Caldas Domínguez</a>.</strong>
            Todos los derechos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../app/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../app/templates/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="usuario.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../app/templates/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../app/templates/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../app/templates/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../app/templates/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../app/templates/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../app/templates/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../app/templates/AdminLTE/dist/js/adminlte.js"></script>




</body>

</html>