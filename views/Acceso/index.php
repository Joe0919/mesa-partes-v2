<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?= media() ?>/files/images/inst/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap 4 -->
    <link rel="stylesheet" href="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?php echo media() ?>/images/logo.wepb">
    <title><?= ($data["page_title"]) ?></title>
</head>

<body class="body">
    <section class="fondo">
        <div class="container bg-light form-login rounded-3 overflow-hidden">
            <div class="row">
                <div class="col-sm-6 text-black">

                    <div class="px-5 py-3 ms-xl-4 mt-3">
                        <img src="<?= media() ?>/images/logo.png " class="logo" />
                    </div>

                    <div class="py-3 px-5 alerta">
                        <form class="form-signin d-flex" method="post" id="form_acceso">
                            <h3 class="title">Acceso a Mesa de Partes Virtual</h3>
                            <input type="text" name="usuario" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus minlength="8" maxlength="8">
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
                            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Ingresar</button>
                        </form>

                        <p class="small mb-5 pb-lg-2  pt-2 "><a class="forgot-password" href="<?= base_url(); ?>/recuperar-contrasena">¿Olvido su contraseña?</a></p>

                    </div>

                </div>
                <div class="col-sm-6" id="fondo">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>