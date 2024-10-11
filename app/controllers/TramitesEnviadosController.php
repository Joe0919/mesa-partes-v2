<?php
// El idioma predeterminado para la conversación es español, a menos que se mencione un idioma específico.
class TramitesEnviadosController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
            exit();
        }
        getPermisos(9);
    }

    // Método para cargar la vista de trámites enviados
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        $data = [
            'page_id' => 10,
            'page_tag' => "Trámites Enviados",
            'page_title' => "Trámites Enviados",
            'file_js' => "tramitesEnviados.js"
        ];
        $this->views->getView("tramites-enviados", "index", $data);
    }

    // Método para obtener trámites enviados
    public function getTramites($area)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesEnviados($area);
            foreach ($arrData as &$item) {
                $item = $this->formatTramiteItem($item);
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
        die();
    }

    // Método para formatear un ítem de trámite
    private function formatTramiteItem($item)
    {
        $estadoColors = $this->getEstadoColors();
        $item['expediente'] = '<b>' . $item['expediente'] . '</b>';
        $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];
        $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';
        $item['Fecha'] = $this->getFechaBadge($item['Fecha']);
        $item['opciones'] = $this->generateTramiteButtons();
        return $item;
    }

    // Método para generar botones de trámite
    private function generateTramiteButtons()
    {
        $btnView = '<button class="btn btn-warning btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>';
        $btnHistory = '<button class="btn btn-success btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';
        return '<div class="text-center"><div class="btn-group">' . $btnView . ' ' . $btnHistory . '</div></div>';
    }

    public function getHistorial(string $expediente)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $Expediente = limpiarCadena($expediente);

            $arrData = $this->model->selectHistorial($Expediente);
            for ($i = 0; $i < count($arrData); $i++) {

                $arrData[$i]['fecha'] = '<b>' . $arrData[$i]['fecha'] . '</b>';

                if ($arrData[$i]['accion'] == "PENDIENTE") {
                    $arrData[$i]['accion'] = '<span class="badge bg-black">' . $arrData[$i]['accion'] . '</span>';
                } else if ($arrData[$i]['accion'] == "ACEPTADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-success">' . $arrData[$i]['accion'] . '</span>';
                } elseif ($arrData[$i]['accion'] == "DERIVADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-primary">' . $arrData[$i]['accion'] . '</span>';
                } elseif ($arrData[$i]['accion'] == "RECHAZADO") {
                    $arrData[$i]['accion'] = '<span class="badge bg-danger">' . $arrData[$i]['accion'] . '</span>';
                } else {
                    $arrData[$i]['accion'] = '<span class="badge bg-warning">' . $arrData[$i]['accion'] . '</span>';
                }
            }

            $arrResponse = $arrData;

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
