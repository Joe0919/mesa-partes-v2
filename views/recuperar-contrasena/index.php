<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?= media() ?>/files/images/inst/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap 5 -->
    <link rel="stylesheet" href="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?php echo media() ?>/images/logo.wepb">
    <title><?= ($data["page_title"]) ?></title>
</head>

<body>
    <section class="fondo">
        <div class="container bg-light form-login rounded-3 overflow-hidden">
            <div class="row">
                <div class="col-sm-6" id="fondo1">
                </div>

                <div class="col-sm-6 text-black">
                    <div class="px-5 py-3 ms-xl-4 mt-3">
                        <a href="<?= base_url(); ?>/acceso" class="link-logo">
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

                        <p class="small mb-5 pb-lg-2  pt-2 "><a class="forgot-password" href="<?= base_url(); ?>/acceso">Iniciar Sesión</a></p>

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
    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>