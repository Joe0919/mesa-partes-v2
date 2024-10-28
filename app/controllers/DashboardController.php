<?php

class DashboardController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(1); //Pasamos el id modulo 1 que es dashboard
    }

    public function index()
    {
        $data = [
            'page_id' => 6,
            'page_tag' => "Dashboard",
            'page_title' => "Dashboard",
            'file_js' => "dashboard.js"
        ];

        $this->views->getView("Dashboard", "index", $data);
    }

    public function getDocsGeneral()
    {
        $arrData = $this->model->selectCantDocs();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getDocsArea($idarea)
    {
        $arrData = $this->model->selectCantDocs($idarea);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getRanking()
    {
        $arrData = $this->model->selectRanking();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    public function getDocsxTiempo()
    {
        $arrData = $this->model->selectDocsxTiempo();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    public function getIngresoDocs($filtro)
    {
        $arrData = $this->model->selectIngresoDocs($filtro);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    public function getProcesDocs($filtro)
    {
        $arrData = $this->model->selectProcesDocs($filtro);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

}
