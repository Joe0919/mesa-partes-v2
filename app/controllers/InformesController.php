<?php 

class InformesController extends Controllers{

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
        getPermisos(11);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 12;
        $data['page_tag'] = "Informes";
        $data['page_title'] = "Informes";
        $data['file_js'] = "informes.js";
        $this->views->getView("informes", "index", $data);
    }
}