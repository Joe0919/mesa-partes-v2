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

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper contenedor">

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
                    <div class="row">
                        <div class="col-12" id="div_nuevo_tramite">
                            <div class="card my-4">
                                <div class="card-header bg-success py-2">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8 col-lg-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-edit mr-1"></i><b>SUBSANAR OBSERVACIONES</b></h3>
                                        </div>
                                    </div>
                                </div>
                                <form id="form_tramite_obs" enctype="multipart/form-data" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <p>Bienvenido a la vista <b>Datos del Trámite</b>,
                                                    puede editar los datos del documento registrado para elevar cualquier observación.
                                                    Puede visualizar el PDF que subió dando click en el nombre del archivo o descargarlo
                                                    <strong>Recuerde</strong> que debe subir un nuevo archivo PDF y editar los datos si fuera necesario.
                                                </p>
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DETALLES DEL TRÁMITE</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <table class="table tabla-tramite">
                                                                    <tr>
                                                                        <td>
                                                                            Nro. Expediente :
                                                                        </td>
                                                                        <td id="tdExpediente"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Fecha Registro :
                                                                        </td>
                                                                        <td id="tdFecha"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Remitente :
                                                                        </td>
                                                                        <td id="tdRemitente"> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Nro. DNI :
                                                                        </td>
                                                                        <td id="tdDNI"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Nro. Teléfono :
                                                                        </td>
                                                                        <td id="tdTel"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            RUC :
                                                                        </td>
                                                                        <td id="tdRUC"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Entidad :
                                                                        </td>
                                                                        <td id="tdEntidad"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Dirección :
                                                                        </td>
                                                                        <td id="tdDireccion"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Correo :
                                                                        </td>
                                                                        <td id="tdCorreo"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Observaciones :
                                                                        </td>
                                                                        <td id="tdObservaciones" class="font-w-600"></td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Tipo</label><span class="span-red"> (*)</span>
                                                                    <select class="form-control select-tipo" name="itipo" id="select_tipo" required></select>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>N° Documento </label><span class="span-red"> (*)</span>
                                                                            <input type="text" class="form-control" id="inrodoc" name="n_doc" onkeypress='return validaNumericos(event)' required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>N° Folios </label><span class="span-red"> (*)</span>
                                                                            <input type="number" class="form-control" id="ifolios" name="ifolios" required>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Asunto </label><span class="span-red"> (*)</span>
                                                                    <textarea class="form-control text-uppercase" rows="3" id="iasunto" name="iasunto" placeholder="Ingrese el asunto del documento" required></textarea>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Adjuntar archivo (Solamente PDFs).</label><span class="span-red"> (*)</span>
                                                                    <div class="file">
                                                                        <label for="idfile" id="archivo">
                                                                            <i class="nav-icon fas fa-upload mr-1"></i>Elige el Archivo...
                                                                        </label>
                                                                        <input type="file" class="d-none" id="idfile" name="ifile" accept="application/pdf">
                                                                    </div>

                                                                    <div id="fileInfo" class="d-none p-2 bg-color-gray">
                                                                        <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row my-2">
                                                                            <div class="d-flex align-items-center">
                                                                                <p id="nom_pdf" class="m-0 text-truncate" style="max-width: 330px;">
                                                                                    <img src="<?= media() ?>/images/pdf.png" width="25px">
                                                                                    <a id="link_doc" class="ml-1">
                                                                                        <span id="fileSize">(<strong>0.0</strong> MB)</span>
                                                                                        <span id="alias"></span>
                                                                                    </a>
                                                                                </p>
                                                                            </div>
                                                                            <div class="mt-2 mt-sm-0">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="btn-group">
                                                                                        <button id="btnDescargar" type="button" class="btn btn-primary start" title="Descargar PDF">
                                                                                            <i class="fas fa-download"></i>
                                                                                        </button>
                                                                                        <button id="btnEliminar" type="button" class="btn btn-danger delete" title="Eliminar">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn2 btn-block bg-gradient-blue">
                                                                <i class="nav-icon fas fa-save mr-1"></i><b>Guardar Cambios</b></button>
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
        const nro_expediente = "<?= $data['param'] ?>";
    </script>
    <script src="<?= media() ?>/js/funciones.js"></script>
    <script src="<?= media() ?>/js/backend/<?= $data['file_js'] ?>"></script>
    <!-- Sweet Alert -->
    <script src="<?= media() ?>/templates/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>


</body>

</html>