<?php

class TramitesEnviadosController extends Controllers
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
        getPermisos(9);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 10;
        $data['page_tag'] = "Trámites Enviados";
        $data['page_title'] = "Trámites Enviados";
        $data['file_js'] = "tramitesEnviados.js";
        $this->views->getView("tramites-enviados", "index", $data);
    }

    public function getTramites($area)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesEnviados($area);
            $estadoColors = [
                'PENDIENTE' => 'bg-black font-p',
                'ACEPTADO'  => 'bg-success font-p',
                'DERIVADO'  => 'bg-primary font-p',
                'RECHAZADO' => 'bg-danger font-p',
                'DEFAULT'   => 'bg-info font-p'
            ];

            foreach ($arrData as &$item) {

                $item['expediente'] = '<b>' . $item['expediente'] . '</b>';

                $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];
                $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';


                $item['Fecha'] = $this->getFechaBadge($item['Fecha']);

                if ($_SESSION['permisosMod']['rea']) {
                    $btnView = '<button class="btn btn-warning btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>';
                    $btnHistory = '<button class="btn btn-success btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';
                }
                $item['opciones'] = '<div class="text-center"><div class="btn-group">' . $btnView . ' ' . $btnHistory . '</div></div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }

        die();
    }

}
