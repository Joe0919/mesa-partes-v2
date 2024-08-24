<!DOCTYPE html>
<html lang="es">

<head>

    <?php require_once "views/inc/MainHeadLink/MainHeadLink.php" ?>

    <title><?= $data['page_title'] ?> | Mesa de Partes Virtual</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper" id="wrapper_content">

        <?php require_once "views/inc/MainHeader/MainHeader.php" ?>

        <!-- Menu de Navegacion  -->
        <?php require_once "views/inc/MainSidebar/MainSidebar.php" ?>   

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content-wrapper">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-10 d-flex justify-content-center">
                            <h4 class="m-0 font-weight-bold">MESA DE PARTES VIRTUAL</h3>
                        </div>
                        <div class="col-sm-2">
                            <ol class="breadcrumb float-sm-right">
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file-upload"></i><?= $data['page_title'] ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content">

                <div class="container-fluid">
                    <div class="d-flex mb-3">
                        <!-- <button type="button" id="btnNuevoT" class="btn btn2 bg-gradient-success mr-2" title="Registrar nuevo Trámite"><i class="fa fa-plus"></i>Nuevo Trámite</button>
                        <button type="button" id="btnLimpiar" class="btn btn-block btn2 bg-gradient-danger mr-2" title="Borrar datos ingresados"><i class="fa fa-eraser"></i>Limpiar Campos</button>
                        <button type="button" id="btnSeguir" class="btn btn2 bg-gradient-purple mr-2" title="Hacer seguimiento de su tramite"><i class="fa fa-search"></i>Seguimiento</button> -->
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-plus-circle mr-1"></i><b>NUEVO TRÁMITE</b></h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" id="btnLimpiar" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <form id="form_tramite" enctype="multipart/form-data" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL REMITENTE</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <label>Tipo de Persona: </label><span class="span-red"> (*)</span>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input class="custom-control-input" type="radio" id="radio_natural" name="customRadio" checked value="natural">
                                                                    <label for="radio_natural" class="custom-control-label">Natural</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
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
                                            <div class="col-sm-6">
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
                                                                <input type="file" id="idfile" name="ifile" accept="application/pdf">
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

        require_once "views/inc/MainFooter/MainFooter.php";

        ?>

    </div>

    <?php require_once "views/inc/MainJS/MainJS.php" ?>

    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>

</body>

</html>