<?php
require_once "../../app/config/conexion.php";

if (isset($_SESSION["idusuarios"])) {
    header("Location:" . URL . "views/inicio/");
}


if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    require_once("../../app/models/Usuario.php");
    (new Usuario())->login();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Inicio</title>
</head>

<body>
    <section class="fondo">
        <div class="container bg-light form-login rounded-3 overflow-hidden">
            <div class="row">
                <div class="col-sm-6 text-black">

                    <div class="px-5 py-3 ms-xl-4 mt-3">
                        <img src="../../public/images/logo.png " class="logo" />
                    </div>

                    <div class="py-3 px-5">
                        <?php
                        if (isset($_GET["m"])) {
                            switch ($_GET["m"]) {
                                case "1";
                        ?>
                                    <div class="alert alert-danger" role="alert">
                                        Datos Incorrectos. Intente de nuevo!
                                    </div>
                        <?php
                                    break;
                            }
                        }
                        ?>
                        <form class="form-signin d-flex" method="post">
                            <h3>INICIO DE SESIÓN</h3>
                            <input type="text" name="usuario" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus>
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required >
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>