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
    <title><?= ($data["page_title"]) ?></title>
</head>

<body class="sidebar-mini layout-fixed bg-principal">
    <section class="fondo contenedor bg-principal">
        <div class="container bg-light form-login rounded-3 overflow-hidden">
            <div class="row">
                <div class="col-sm-6 fondo-img" id="fondo1">
                </div>

                <div class="col-sm-6 text-black">
                    <div class="px-5 py-3 ms-xl-4 mt-3">
                        <a href="<?= base_url(); ?>" class="link-logo">
                            <img src="<?= media() ?>/images/logo.png " class="logo" />
                        </a>
                    </div>
                    <div class="py-3 px-5 alerta">
                        <form class="form-signin d-flex" id="form_recuperar">
                            <h3 class="title">Recuperar Contraseña</h3>
                            <input type="dni" name="dni" id="dni" class="form-control" placeholder="DNI" required minlength="8" maxlength="8" autofocus>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo de recuperación" required autofocus>
                            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Verificar</button>
                        </form>

                        <p class="mb-5 pb-lg-2  pt-2 "><a class="forgot-password" href="<?= base_url(); ?>/acceso">Iniciar Sesión</a></p>

                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <script src="<?= media() ?>/js/funciones.js"></script>
    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>
    <!-- Sweet Alert -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
</body>

</html>