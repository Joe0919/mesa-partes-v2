<?php

class DashboardController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Dashboard"); 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(1);//Pasamos el id modulo 1 que es dashboard
    }

    public function index()
    {
        // $data['page_id'] = 1;
        $data['page_tag'] = "Dashboard";
        $data['page_title'] = "Dashboard";
        $data['page_name'] = "dashboard";
        // $data['page_content'] = "Contenido de la pagina";
        // $data['function_js'] = "dashboard.js";

        $this->views->getView("Dashboard", "index", $data);
    }
}
