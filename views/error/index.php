<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= media() ?>/templates/AdminLTE/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Estilos principales -->
    <link rel="stylesheet" href="<?= media() ?>/css/style.css">

    <link rel="icon" type="image/png" href="<?= media() ?>/images/logo.png">
    <title>Pagina No Encontrada</title>

</head>

<body class="sidebar-mini layout-fixed bg-principal">

    <div class="error-container contenedor">
        <div class="container-xl bg-color-gray h-100 d-flex align-items-center justify-content-center">
            <div class="text-center ">
                <!-- Puedes reemplazar este link con tu propia imagen de señal de tráfico -->
                <img src="<?= media() ?>/images/404.webp" alt="404">
                <h2 class="mt-2 text-bold">Página No Encontrada</h2>
                <p>Lo sentimos, la página que estás buscando no existe. Si cree que algo no funciona, informe el problema.</p>
                <p>Puede intentar visitar otros enlaces:</p>
                <div>
                    <a href="<?= base_url() ?>/" class="btn bg-gradient-primary mt-1">Ir a Inicio</a>
                    <a href="<?= base_url() ?>/registro-tramite" class="btn bg-gradient-success mt-1">Registrar Trámite</a>
                    <a href="<?= base_url() ?>/seguimiento" class="btn bg-gradient-warning mt-1">Seguimiento</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>

</html>