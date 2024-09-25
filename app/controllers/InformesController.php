<?php

class InformesController extends Controllers
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
        getPermisos(11);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }

        $data = [
            'page_id' => 12,
            'page_tag' => "Informes",
            'page_title' => "Informes",
            'file_js' => "informes.js"
        ];
        $this->views->getView("informes", "index", $data);
    }
}