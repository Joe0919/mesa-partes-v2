<?php
// Obtener la URL actual
$current_url = $_SERVER['REQUEST_URI'];

// Obtener la base URL y extraer la parte de la ruta
$base_url = base_url();
$base_url_path = parse_url($base_url, PHP_URL_PATH);

// Comparar las rutas
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a class="brand-link navbar-lightblue">
        <img src="<?php echo media() . "/" . $_SESSION['userData']['logo']; ?>" id="inst_logo" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text span-logo" id="inst_desc">HACDP</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (!empty($_SESSION['permisos'][1]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/dashboard" class="nav-link <?= ($current_url == $base_url_path . '/dashboard' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][2]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/usuarios" class="nav-link <?= ($current_url == $base_url_path . '/usuarios' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][3]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/roles" class="nav-link <?= ($current_url == $base_url_path . '/roles' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][4]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/areas" class="nav-link <?= ($current_url == $base_url_path . '/areas' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-door-closed"></i>
                            <p>Áreas</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][5]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/empleados" class="nav-link <?= ($current_url == $base_url_path . '/empleados' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Empleados</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][6]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/tramites" class="nav-link <?= ($current_url == $base_url_path . '/tramites' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Trámites</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][7]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/nuevo-tramite" class="nav-link <?= ($current_url == $base_url_path . '/nuevo-tramite' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-file-upload"></i>
                            <p>Nuevo Trámite</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][8]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/tramites-recibidos" class="nav-link <?= ($current_url == $base_url_path . '/tramites-recibidos' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-file-archive"></i>
                            <p>Trámites Recibidos</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][9]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/tramites-enviados" class="nav-link <?= ($current_url == $base_url_path . '/tramites-enviados' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-file-export"></i>
                            <p>Trámites Enviados</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][10]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/busqueda" class="nav-link <?= ($current_url == $base_url_path . '/busqueda' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-search-minus"></i>
                            <p>Búsqueda de Trámites</p>
                        </a>
                    </li>
                <?php }
                if (!empty($_SESSION['permisos'][11]['rea'])) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>/informes" class="nav-link <?= ($current_url == $base_url_path . '/informes' ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-file-contract"></i>
                            <p>Informes</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>