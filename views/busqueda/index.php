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
                                <li class="modal-title-weight li-nav-info"><i class="nav-icon fas fa-file-export"></i><?= $data['page_title'] ?></li>
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
                            <div class="card card-olive" id="div_form">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-9 d-flex align-items-center">
                                            <h3 class="title-content-h3 m-0"><i class="fas fa-search mr-1"></i><b>SEGUIMIENTO DE TRÁMITES</b></h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" id="btnLimpiar" class="btn btn-block bg-gradient-white">
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
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-bold">DATOS DEL TRÁMITE</h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>N° Expediente </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" name="expediente" id="expediente_b" onkeypress='return validaNumericos(event)' required maxlength="6" minlength="6" title="Ingrese el N° de Expediente">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>DNI </label><span class="span-red"> (*)</span>
                                                                    <input type="text" class="form-control" name="dni" id="dni_b" onkeypress='return validaNumericos(event)' maxlength="8" minlength="8" required title="Ingrese su DNI">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Año</label><span class="span-red"> (*)</span>
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
                                                            <span class="span-red">(*) Campos Obligatorios </span>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center">
                                                            <div class="col-sm-4">
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

                            <div id="div_no_encontrado">
                                <div class="callout callout-warning">
                                    <div class="row">
                                        <div class="col-sm-3" align="right">
                                            <img class="img-no-search" src="<?= media() ?>/public/images/error-404.png">
                                        </div>
                                        <div class="col-sm-7">
                                            <br>
                                            <h2><i class="fas fa-exclamation-triangle text-warning"></i> TRÁMITE NO ENCONTRADO.</h2>

                                            <p>
                                                No se encontró el trámite con el expediente <b id="expediente-info"></b>
                                                y el DNI <b id="dni-info"></b> presentado el <b id="anio-info"></b>,
                                                tal vez colocó datos que no son los correctos.<br>
                                                <b>Por favor, intente realizar nuevamente la búsqueda ingresando los datos correctos.<b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-olive" id="datos_buscados">
                                <div class="card-header">
                                    <h3 class="card-title font-w-600 d-flex-gap"><i class="fas fa-file-pdf "></i> DATOS DEL TRÁMITE ENCONTRADO
                                    </h3>
                                </div>
                                <div class="row">
                                    <div class="col-sm-7">

                                    </div>
                                    <div class="col-sm-5">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn3 btn-primary" id="btnNuevaBusqueda"><i class="fa fa-search"></i>Nueva Búsqueda</button>
                                            </div>
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn3 btn-danger" id="btnHistorial"><i class="fa fa-plus"></i>Mostrar Historial</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- TABLA CON INFORMACION -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="callout callout-success">

                                                <table border="2" class="table-doc table-data" cellspacing="0" cellpadding="5" id="tableDoc">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">
                                                                <h5 class="font-w-600">DATOS DEL DOCUMENTO</h5>
                                                                </font>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Expediente</th>
                                                            <td>
                                                                <p id="celdaexpe"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>N° Documento</th>
                                                            <td>
                                                                <p id="celdanro"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tipo</th>
                                                            <td>
                                                                <p id="celdatipo"></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Asunto</th>
                                                            <td>
                                                                <p id="celdasunto"></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="callout callout-info">
                                                <table border="2" class="table-remi table-data" cellspacing="0" cellpadding="5" id="tableRemitente">
                                                    <tr>
                                                        <th colspan="2">
                                                            <h5 class="font-w-600">DATOS DEL REMITENTE</h5>

                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>DNI</th>
                                                        <td>
                                                            <p id="celdadni"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Datos</th>
                                                        <td>
                                                            <p id="celdadatos"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>RUC</th>
                                                        <td>
                                                            <p id="celdaruc"></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Entidad</th>
                                                        <td>
                                                            <p id="celdaenti"></p>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- LINEA DE TIEMPO DEL DOCUMENTO -->
                            <div id="linea_tiempo">

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