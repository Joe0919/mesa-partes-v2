<?php

class NuevoTramiteController extends Controllers
{

    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(7);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 8;
        $data['page_tag'] = "Nuevo Tramite";
        $data['page_name'] = "nuevo Tramite";
        $data['page_title'] = "Nuevo Tramite";
        $data['file_js'] = "nuevoTramite.js";
        $this->views->getView("nuevo-tramite", "index", $data);
    }

}
