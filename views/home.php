<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed bg-color-gray">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mesa de Partes Virtual</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/acceso">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container my-5">
        <!-- Description -->
        <div class="row text-center mb-5">
            <div class="col">
                <h1>Bienvenido a la Mesa de Partes Virtual</h1>
                <p class="lead">Aquí puedes registrar tus trámites, hacer seguimiento y más.</p>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="row text-center">
            <!-- Registrar Trámite -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Registrar Trámite</h2>
                        <p class="card-text">Envía tus trámites de manera virtual.</p>
                        <a href="<?= base_url(); ?>/registro-tramite" class="btn btn-primary">Registrar</a>
                    </div>
                </div>
            </div>

            <!-- Hacer Seguimiento -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Hacer Seguimiento</h2>
                        <p class="card-text">Consulta el estado de tu trámite en tiempo real.</p>
                        <a href="<?= base_url(); ?>/seguimiento" class="btn btn-success">Ver Seguimiento</a>
                    </div>
                </div>
            </div>

            <!-- Iniciar Sesión -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Iniciar Sesión</h2>
                        <p class="card-text">Accede a tu cuenta para más funcionalidades.</p>
                        <a href="<?= base_url(); ?>/acceso" class="btn btn-warning">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>

</body>

</html>