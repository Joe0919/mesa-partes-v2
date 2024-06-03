<?php require_once '../app/views/inc/header.php';

if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    $control->load_model("Usuario")->login();
}

?>


<section class="fondo">
    <div class="container bg-light form-login rounded-3">
        <div class="row">
            <div class="col-sm-6 text-black">

                <div class="px-5 py-3 ms-xl-4 mt-3">
                    <img src="<?= URL ?>/public/images/logo.png " class="logo" />
                </div>

                <div class="py-3 px-5">
                    <?php
                    if (isset($_GET["m"])) {
                        switch ($_GET["m"]) {
                            case "1";
                    ?>
                                <div class="alert alert-danger" role="alert">
                                    This is a danger alert—check it out!
                                </div>
                    <?php
                                break;
                        }
                    }
                    ?>
                    <form class="form-signin d-flex" method="post">
                        <h3>INICIO DE SESIÓN</h3>
                        <input type="text" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus>
                        <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
                        <input type="hidden" name="enviar" class="form-control" value="si">
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Ingresar</button>
                    </form>

                    <p class="small mb-5 pb-lg-2  pt-2 "><a class="forgot-password" href="#!">¿Olvido su contraseña?</a></p>

                </div>

            </div>
            <div class="col-sm-6 px-0d-none d-sm-block bg-success">

            </div>
        </div>
    </div>
</section>

<?php require_once '../app/views/inc/footer.php'?>