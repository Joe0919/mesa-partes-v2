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
        $data['page_tag'] = "Dashboard";
        $data['page_title'] = "Dashboard";
        $data['file_js'] = "dashboard.js";

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

    public function pruebaEmail()
    {
        $html = "<p class='p_name'>Estimado(a): <b>JOEL BLADIMIR</b></p>
        <hr>
        <p class='p_name'>Se le envía este mensaje desde la <b>Mesa de Partes Virtual</b> del <b>Hospital Antonio
            Caldas Domínguez - Pomabamba.</b>
            <br>Para informarle que su trámite a sido enviado por lo que se le da a conocer información del trámite
            recepcionado:
        </p>

        <div class='container'>
            <table width='100%' border='1' cellspacing='0' cellpadding='5' id='tableDoc'>
                <tr>
                    <th colspan='2' class='title_table'>
                        DATOS DEL DOCUMENTO</th>
                </tr>
                <tr>
                    <th style='width: 40%;'>EXPEDIENTE</th>
                    <td>000052</td>
                </tr>
                <tr>
                    <th>N°. DOCUMENTO</th>
                    <td>012</td>
                </tr>
                <tr>
                    <th>TIPO</th>
                    <td>MEMORANDUM</td>
                </tr>
                <tr>
                    <th>REMITENTE</th>
                    <td>JOEL BLADIMIR LLALLIHUAMAN GIRALDO</td>
                </tr>
                <tr>
                    <th>FECHA</th>
                    <td>28/09/10 10:30PM</td>
                </tr>
            </table>
        </div>


        <p>Puede realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes
                Virtual</b> en
            la pestaña <b><i>Seguimiento</i></b>
        </p>";
        echo $this->enviarCorreo("MESA DE PARTES VIRTUAL - HACDP", "Usuario", "joel09llalli@gmail.com", "CAMBIO DE CONTRASEÑA", $html);
    }
}
