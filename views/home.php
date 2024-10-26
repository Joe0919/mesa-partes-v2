<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= media() ?>/templates/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= media() ?>/icons/ionicons.css">
    <!-- Feather Icons -->
    <link rel="stylesheet" href="<?= media() ?>/icons/feather.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= media() ?>/templates/AdminLTE/dist/css/adminlte.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Estilos principales -->
    <link rel="stylesheet" href="<?= media() ?>/css/style.css">

    <link rel="icon" type="image/png" href="<?= media() ?>/images/logo.png">
    <title>Mesa de Partes Virtual</title>
</head>

<body class="bg-color-gray">
    <div class="contenedor bg-principal text-light">
        <!-- Navbar -->
        <nav class="navbar bg-oscuro p-3">
            <div class="container-fluid row d-flex justify-content-between">
                <div class="col-12 text-center col-sm-auto">
                    <h3 class="text-bold">Mesa de Partes Virtual</h3>
                </div>
                <div class="col-12 text-center col-sm-auto">
                    <a href="<?= base_url(); ?>/acceso" class="btn btn-light text-bold ">Iniciar Sesión</a>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="main px-4">
            <div class="mt-3">
                <!-- Description -->
                <div class="row text-center mb-3">
                    <div class="col">
                        <h1 class="text bold">Bienvenido a la Mesa de Partes Virtual</h1>
                        <p class="lead">Aquí puedes registrar tus trámites, hacer seguimiento y más.</p>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="row text-center d-flex justify-content-center text-dark">
                    <!-- Registrar Trámite -->
                    <div class="col-lg-5 col-xl-4 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-bold text-center w-100 mb-2 text-primary">REGISTRE SU TRÁMITE</h5>
                                <p class="card-text">Registra tus trámites de manera virtual en cualquier momento a traves de la red.</p>
                                <a href="<?= base_url(); ?>/registro-tramite" class="btn btn-primary">Registrar</a>
                            </div>
                        </div>
                    </div>

                    <!-- Hacer Seguimiento -->
                    <div class="col-lg-5 col-xl-4 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title text-bold text-center w-100 mb-2 text-success">HAGA SEGUIMIENTO</h2>
                                <p class="card-text">Consulta el estado de tu trámite en tiempo real y mantente informado.</p>
                                <a href="<?= base_url(); ?>/seguimiento" class="btn btn-success">Seguimiento</a>
                            </div>
                        </div>
                    </div>
                </div>

                <article class="col-lg-10 col-xl-8 col-12 mx-auto mt-2">
                    <div class="card">
                        <div class="card-body p-2">
                            <ul class="topic__rows row">
                                <ul class="topic__rows row">
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <span>Eficiencia</span>
                                    </li>
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-eye font-weight-normal"></i>
                                        <span>Transparencia</span>
                                    </li>
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-clock font-weight-normal"></i>
                                        <span>Disponibilidad</span>
                                    </li>
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-universal-access"></i>
                                        <span>Accesibilidad</span>
                                    </li>
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-shield-alt"></i>
                                        <span>Seguridad</span>
                                    </li>
                                    <li class="col topic__rows__item">
                                        <i class="nav-icon fas fa-sliders-h"></i>
                                        <span>Control</span>
                                    </li>
                                </ul>

                            </ul>
                        </div>
                    </div>
                    <div>

                    </div>
                </article>

            </div>
        </main>
        <footer class="bg-body-tertiary text-center text-lg-start">
            <div class="text-center p-3 bg-oscuro">
                © <?= date('Y'); ?> | Joel Llallihuaman:
            </div>
        </footer>
    </div>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>

</html>