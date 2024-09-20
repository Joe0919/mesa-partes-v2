<?php

class TramitesRecibidosController extends Controllers
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
        getPermisos(8);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 9;
        $data['page_tag'] = "Trámites Recibidos";
        $data['page_title'] = "Trámites Recibidos";
        $data['file_js'] = "tramitesRecibidos.js";
        $this->views->getView("tramites-recibidos", "index", $data);
    }

    public function getTramites($idarea, $area, $estado)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesRecibidos($area, $estado, $idarea);
            $estadoColors = [
                'PENDIENTE' => 'bg-black font-p',
                'ACEPTADO'  => 'bg-success font-p',
                'DERIVADO'  => 'bg-primary font-p',
                'RECHAZADO' => 'bg-danger font-p',
                'DEFAULT'   => 'bg-info font-p'
            ];

            $fechaColors = [
                0 => ['class' => 'badge-danger font-p'],
                1 => ['class' => 'badge-warning font-p'],
                7 => ['class' => 'badge-info font-p'],
                30 => ['class' => 'badge-success font-p'],
                180 => ['class' => 'badge-secondary font-p'],
                365 => ['class' => 'bg-purple font-p'],
                'default' => ['class' => 'badge-light font-p']
            ];
            foreach ($arrData as &$item) {

                $botones = '';

                $item['expediente'] = '<b>' . $item['expediente'] . '</b>';

                if ($_SESSION['permisosMod']['upd']) {
                    switch ($item['estado']) {
                        case "PENDIENTE":
                            $botones = '<button class="btn btn-success btn-sm btn-table btnAceptar" title="Aceptar/Rechazar"><i class="nav-icon fas fa-check"></i></button>';
                            break;
                        case "ACEPTADO":
                            $botones = '<button class="btn btn-danger btn-sm btn-table btnDerivar" title="Derivar/Archivar"><i class="nav-icon fas fa-arrow-right"></i></button>';
                            break;
                    }
                }

                $botones .= '<button class="btn btn-info btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';

                $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];
                $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';

                $item['Fecha'] = $this->getFechaBadge($item['Fecha']);

                $item['opciones'] = '<div class="text-center"><div class="btn-group">' . $botones .  '</div></div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }

        die();
    }

}
