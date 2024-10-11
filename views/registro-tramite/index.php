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

<body class="hold-transition sidebar-mini layout-fixed body">


    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper" id="wrapper_content">

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-xl bg-color-gray px-0">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header bg-color-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col d-flex justify-content-center">
                            <h3 class="m-0 font-weight-bold text-center">MESA DE PARTES VIRTUAL</h3>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content px-2">
                <div class="container-fluid">
                    <div class="d-flex my-3 justify-content-end">
                        <a href="<?= base_url(); ?>/seguimiento" id="btnSeguimiento" class="btn btn2 bg-gradient-info ml-2" title="Hacer seguimiento de su trámite">
                            <i class="fa fa-search"></i>
                            <b>Seguimiento</b>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-12" id="div_nuevo_tramite">
                            <div class="card ">
                                <div class="card-header bg-color-header2 py-2">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8 col-lg-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-plus-circle mr-1"></i><b>NUEVO TRÁMITE</b></h3>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mt-1">
                                            <button type="button" id="btnLimpiar" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <form id="form_tramite" enctype="multipart/form-data" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL REMITENTE</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <label>Tipo de Persona: </label><span class="span-red"> (*)</span>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="radio_natural" name="customRadio" checked value="natural">
                                                                    <label for="radio_natural" class="custom-control-label">Natural</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="radio_juridica" name="customRadio" value="juridica">
                                                                    <label for="radio_juridica" class="custom-control-label">Jurídica</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="div_juridica">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" id="idpersona" name="idpersona" value="0">
                                                                <label>RUC </label><span class="span-red"> (*)</span>
                                                                <input type="text" class="form-control" id="idruc" name="iruc" onkeypress="return validaNumericos(event)" maxlength="11" minlength="11">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Entidad </label><span class="span-red"> (*)</span>
                                                                <input type="text" class="form-control text-uppercase" id="identidad" name="ientidad">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>DNI</label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" name="idni" id="idni" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required title="Valide su DNI">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 form-group d-flex align-items-end mb-3">
                                                                <input id="btn_validar" type="button" class="btn btn-success" value="Validar">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nombres </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control text-uppercase" id="idnombre" name="inombre" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Apellido Paterno </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control text-uppercase" id="idap" name="iappat" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Apellido Materno </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control text-uppercase" id="idam" name="iapmat" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>N° Celular </label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control" id="idcel" name="icel" onkeypress='return validaNumericos(event)' minlength="9" maxlength="9" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Dirección </label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control text-uppercase" id="iddirec" required name="idir">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Correo</label><span class="span-red"> (*)</span>
                                                            <input type="text" class="form-control" id="idemail" required name="iemail">
                                                            <i><b id="Vcorreo"></b></i>
                                                        </div>
                                                        <span class="span-red">(*) Campos Obligatorios </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL DOCUMENTO</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Tipo</label><span class="span-red"> (*)</span>
                                                            <select class="form-control select-tipo" name="itipo" id="select_tipo" required></select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>N° Documento </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" id="idnrodoc" name="n_doc" onkeypress='return validaNumericos(event)' required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>N° Folios </label><span class="span-red"> (*)</span>
                                                                    <input type="number" class="form-control" id="idfolios" name="ifolios" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <label>Asunto </label><span class="span-red"> (*)</span>
                                                            <textarea class="form-control text-uppercase" rows="3" id="idasunto" name="iasunto" placeholder="Ingrese el asunto del documento" required></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Adjuntar archivo (pdf.)</label><span class="span-red"> (*)</span>
                                                            <div class="file">
                                                                <p id="nom_pdf">
                                                                    <img src="<?= media() ?>/images/pdf.png" width="25px">
                                                                    <span id="alias"></span>
                                                                </p>
                                                                <label for="idfile" id="archivo"><i class="nav-icon fas fa-upload mr-1"></i>Elige el Archivo...</label>
                                                                <input type="file" id="idfile" name="ifile" accept="application/pdf" required>
                                                            </div>
                                                        </div>
                                                        <div class="custom-control custom-checkbox div-check">
                                                            <input class="form-check-input input-check" type="checkbox" id="check" name="check" value="option1" required>

                                                            <label for="check" class="form-check-label ml-1">Declaro que la
                                                                información proporcionada es válida y verídica.
                                                                Y Acepto que las comunicaciones sean enviadas a la dirección de correo y
                                                                celular que proporcione.<span class="span-red"> (*)</span></label>

                                                        </div>
                                                        <br>
                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn-block bg-success">
                                                                <i class="nav-icon fas fa-paper-plane mr-1"></i><b>Enviar Trámite</b></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- /CONTENIDO PRINCIPAL -->

        <?php

        require_once "views/inc/Modals/Modals.php";

        ?>

    </div>

    <!-- jQuery -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script>
        const base_url = "<?= base_url(); ?>";
        const page_id = "<?= $data['page_id'] ?>";
    </script>
    <script src="<?= media() ?>/js/funciones.js"></script>
    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>
    <!-- Sweet Alert -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>


</body>

</html>