        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan d-flex justify-content-between w-auto">
            <!-- Left navbar links -->
            <ul class="navbar-nav flex-grow-1 d-flex justify-content-start">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-flex flex-grow-1 align-items-center justify-content-between justify-content-lg-start">
                    <h3 class="h6 m-0 d-none d-md-flex flex-column flex-xl-row">
                        <strong class="mr-0 mr-md-1">USUARIO: </strong>
                        <p class="d-flex m-0">
                            <span class="span_header_name"><?= $_SESSION['userData']['nombres'] ?></span>
                            <span class="span_header_lastname ml-1"><?= $_SESSION['userData']['apellidos'] ?> </span>
                        </p>
                    </h3>
                    <input id="id_areaid" type="hidden" value="<?= $_SESSION['userData']['idareainstitu'] ?>">
                    <input id="info-area" type="hidden" value="<?= $_SESSION['userData']['area'] ?>">
                    <input id="idinstitu" name="idinstitu" type="hidden">
                    <input id="iduser" name="iduser" type="hidden" value="<?= $_SESSION['userData']['idusuarios'] ?>">
                    <input id="dniuser" name="dniuser" type="hidden" value="<?= $_SESSION['userData']['dni'] ?>">
                    <input id="foto_user" name="foto_user" type="hidden" value="<?= $_SESSION['userData']['foto'] ?>">
                    <h3 class="h6 m-0 d-none d-md-flex flex-column flex-xl-row ml-lg-4">
                        <strong class="mr-0 mr-md-1">AREA: </strong>
                        <span id="info-area1"><?= $_SESSION['userData']['area'] ?></span>
                    </h3>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav d-flex align-items-center">
                <!-- Notifications Dropdown Menu -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge h5">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> -->
                <li class="nav-item">
                    <div class="demo-navbar-user nav-item dropdown">
                        <a class="nav-link dropdown-toggle m-0 py-0 d-flex align-items-center" href="#" data-toggle="dropdown">
                            <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                <?php
                                $foto = $_SESSION['userData']['foto'];
                                $timestamp = time();
                                ?>
                                <img id="img_perfil" src="<?php echo media() . "/" . $foto . "?t=" . $timestamp; ?>" alt="Foto perfil" class="d-block rounded-circle" style="max-width: 35px;">
                                <span class="px-1 mr-lg-2 ml-2 ml-lg-0 font-name">
                                    <?php
                                    $utf8_string = $_SESSION['userData']['nomusu'];
                                    $iso8859_1_string = mb_convert_encoding($utf8_string, 'ISO-8859-1', 'UTF-8');
                                    echo $iso8859_1_string
                                    ?>
                                </span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                            <div class="dropdown-header text-center">
                                <img src="<?php echo media() . "/" . $foto . "?t=" . $timestamp; ?>"
                                    alt="Foto perfil" class="img-thumbnail rounded-circle" style="width: 100px;">
                                <h5 class="mt-2 mb-0 d-flex flex-column">
                                    <span class="   "><?= $_SESSION['userData']['nombres'] ?></span>
                                    <span class="span_header_lastname ml-1"><?= $_SESSION['userData']['apellidos'] ?> </span>
                                </h5>
                                <h6 class="text-muted text-bold mt-1"><?= $_SESSION['userData']['rol'] ?></h6>
                                <h7 class="text-muted"><?= $_SESSION['userData']['area'] ?></h7>
                            </div>
                            <div class="dropdown-divider"></div>
                            <?php if ($_SESSION['userData']['idroles'] == 1) { ?>
                                <a class="dropdown-item cursor-pointer" id="conf-inst" data-toggle="modal">
                                    <i class="feather icon-info text-muted"></i><span class="ml-1">Institución</span>
                                </a>
                            <?php } ?>
                            <a class="dropdown-item cursor-pointer" id="conf-perfil" data-toggle="modal">
                                <i class="feather icon-user text-muted"></i><span class="ml-1">Datos del Perfil</span>
                            </a>
                            <a class="dropdown-item cursor-pointer" id="conf-psw" data-toggle="modal">
                                <i class="feather icon-lock text-muted"></i><span class="ml-1">Cambiar Contraseña</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item cursor-pointer text-danger" data-toggle="modal" href="#modal_salir">
                                <i class="feather icon-log-out text-danger"></i><span class="ml-1">Salir</span>
                            </a>
                        </div>

                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->