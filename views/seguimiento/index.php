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

<body class="bg-principal h-auto">

    <?php require_once "views/inc/Loader/Loader.php" ?>

    <div class="wrapper contenedor d-block">

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-xl bg-color-gray px-0">
            <!-- Contenido del Encabezado del Cuerpo -->
            <div class="content-header bg-color-header">
                <div class="container-fluid">
                    <div class="row ">
                        <a class="col d-flex justify-content-space-start align-items-center cursor-pointer text-light" href="<?= base_url(); ?>" title="Ir a Inicio">
                            <img src="<?= media() ?>/images/logo.png" id="inst_logo" alt="Logo" class="logo mt-0">
                            <h3 class="m-0 font-weight-bold text-center ml-2">MESA DE PARTES VIRTUAL</h3>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <main class="content px-2">
                <div class="container-fluid">
                    <div class="d-flex my-3 justify-content-end">
                        <a href="<?= base_url(); ?>/registro-tramite" id="btnNuevoTramite" class="btn btn2 bg-gradient-success ml-2" title="Registrar nuevo Trámite">
                            <i class="fa fa-plus"></i>
                            <b>Nuevo Trámite</b>
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-12" id="div_busqueda">
                            <div class="card card-info my-1" id="div_form">
                                <div class="card-header py-2">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-8 col-lg-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-search mr-2"></i><b>SEGUIMIENTO DE TRÁMITES</b></h3>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mt-2 mt-sm-0">
                                            <button type="button" id="btnLimpiarB" class="btn btn-block bg-gradient-white">
                                                <i class="nav-icon fas fa-eraser mr-1"></i><b>Limpiar Campos</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <form id="form_busqueda" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header bg-color-header2">
                                                        <h3 class="card-title text-bold">DATOS DEL TRÁMITE</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>N° Expediente </label><span class="span-required"></span>
                                                                    <input type="text" class="form-control" name="expediente" id="expediente_b" onkeypress='return validaNumericos(event)' required maxlength="6" minlength="6" title="Ingrese el N° de Expediente">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>DNI </label><span class="span-required"></span>
                                                                    <input type="text" class="form-control" name="dni" id="dni_b" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required title="Ingrese su DNI">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Año</label><span class="span-required"></span>
                                                                    <select class="form-control select-tipo text-center text-bold" name="anio" id="select-año" required>
                                                                        <?php
                                                                        $currentYear = date('Y');
                                                                        for ($i = $currentYear; $i >= 2020; $i--) {
                                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <span class="span-red span-required-description"> Obligatorio </span>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="col-sm-5 col-md-4">
                                                                <button type="submit" class="btn btn-block bg-gradient-blue">
                                                                    <i class="nav-icon fas fa-search mr-1"></i><b>Buscar Trámite</b></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="card card-info" id="datos_buscados">
                                <div class="card-header">
                                    <h3 class="card-title font-w-600 d-flex-gap"><i class="fas fa-file-pdf "></i> DATOS DEL TRÁMITE ENCONTRADO
                                    </h3>
                                </div>
                                <!-- TABLA CON INFORMACION -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex justify-content-end flex-column flex-sm-row">
                                            <button type="button" class="btn bg-gradient-danger" id="btnNuevaBusqueda">
                                                <i class="fa fa-search mr-2"></i>Nueva Búsqueda</button>
                                            <button type="button" class="btn bg-gradient-purple ml-0 ml-sm-2 mt-2 mt-sm-0" id="btnHistorial">
                                                <i class="fa fa-plus mr-2"></i>Mostrar Historial</button>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="callout callout-success ">
                                                <table class="table tabla">
                                                    <tr>
                                                        <th>
                                                            Nro. Expediente :
                                                        </th>
                                                        <td id="tdExpediente"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Fecha Registro :
                                                        </th>
                                                        <td id="tdFecha"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Nro Documento :
                                                        </th>
                                                        <td id="tdNroDoc"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Tipo Documento :
                                                        </th>
                                                        <td id="tdTipoDoc"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Asunto :
                                                        </th>
                                                        <td id="tdAsunto"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Área Actual :
                                                        </th>
                                                        <td id="tdArea"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Estado Actual :
                                                        </th>
                                                        <td id="tdEstado"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="callout callout-warning ">
                                                <table class="table tabla">
                                                    <tr>
                                                        <th>
                                                            Remitente :
                                                        </th>
                                                        <td id="tdRemitente"> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Nro. DNI :
                                                        </th>
                                                        <td id="tdDNI"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Nro. Teléfono :
                                                        </th>
                                                        <td id="tdTel"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            RUC :
                                                        </th>
                                                        <td id="tdRUC"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Entidad :
                                                        </th>
                                                        <td id="tdEntidad"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Dirección :
                                                        </th>
                                                        <td id="tdDireccion"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            Correo :
                                                        </th>
                                                        <td id="tdCorreo"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- LINEA DE TIEMPO DEL DOCUMENTO -->
                            <div id="linea_tiempo"></div>
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