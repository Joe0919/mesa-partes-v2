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
            exit();
        }
        getPermisos(7);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }

        $data = [
            'page_id' => 12,
            'page_tag' => "Nuevo Tramite",
            'page_title' => "Nuevo Tramite",
            'file_js' => "nuevoTramite.js"
        ];
        $this->views->getView("nuevo-tramite", "index", $data);
    }
}
