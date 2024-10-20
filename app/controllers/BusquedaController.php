<?php
class BusquedaController extends Controllers
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
        getPermisos(10);
    }

    // Método para cargar la vista de búsqueda
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        $data = [
            'page_id' => 11,
            'page_tag' => "Busqueda",
            'page_title' => "Busqueda",
            'file_js' => "busqueda.js"
        ];
        $this->views->getView("busqueda", "index", $data);
    }

    // Método para obtener el trámite por expediente, DNI y año
    public function getTramite()
    {
        if ($_POST) {
            $arrResponse = $this->validateInput($_POST); //Valida los datos del POST sean existentes
            if ($arrResponse['status'] === true) {
                $expediente = limpiarCadena($_POST['expediente']);
                $dni = limpiarCadena($_POST['dni']);
                $anio = limpiarCadena($_POST['anio']);
                $arrData = $this->model->selectTramitexAnio($expediente, $dni, $anio);
                $arrResponse = empty($arrData)
                    ? ['status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.']
                    : ['status' => true, 'title' => 'ok', 'data' => $arrData];
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Método para obtener el historial del trámite
    public function getHistorialTramite()
    {
        if ($_POST) {
            $arrResponse = $this->validateInput($_POST);
            if ($arrResponse['status'] === true) {
                $expediente = limpiarCadena($_POST['expediente']);
                $dni = limpiarCadena($_POST['dni']);
                $anio = limpiarCadena($_POST['anio']);
                $arrData = $this->model->selectHistorial($expediente, $dni, $anio);

                $arrResponse = empty($arrData)
                    ? ['status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.']
                    : ['status' => true, 'title' => 'ok', 'data' => $this->generateTimelineHtml($arrData, $expediente)];
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para validar la entrada
    private function validateInput($input)
    {
        if (empty($input['expediente']) || empty($input['dni']) || empty($input['anio'])) {
            return ["status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.'];
        }
        return ["status" => true];
    }

    // Método para generar el HTML del historial
    private function generateTimelineHtml($arrData, $expediente)
    {
        $timelineHtml = <<<HTML
            <div class="timeline" id="div_historial">
                <div class="time-label">
                    <span class="bg-red">HISTORIAL DEL TRÁMITE: </span>
                </div>
                <div class="time-label">
                    <span class="bg-purple">EXPEDIENTE <b>{$expediente}</b></span>
                </div>
        HTML;

        foreach ($arrData as $data) {
            $icono = $this->getIcono($data['accion']);
            $preposicion = $this->getPreposicion($data['accion']);
            $timelineHtml .= <<<HTML
                <div>
                    {$icono}
                    
                    <div class="timeline-item">
                        <div class="timeline-header d-flex justify-content-start justify-content-sm-between align-items-center flex-column flex-sm-row">
                            <h3 style="font-size:17px" class="m-0">El trámite fue <b class="text-primary">{$data['accion']}</b> {$preposicion}
                                <b class="text-primary">{$data['area']}</b> el <b class="text-muted">{$data['fecha1']}</b></h3>
                            <span style="font-size:17px" class="time text-muted text-bold"><i class="fas fa-clock"></i> {$data['hora']}</span>
                        </div>
                        
                        <div style="font-size:15px" class="timeline-body text-bold">
                            {$data['descrip']}
                        </div>
                    </div>
                </div>
            HTML;
        }
        $timelineHtml .= <<<HTML
                <div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>
        HTML;

        return $timelineHtml;
    }

    // Método para obtener el ícono basado en la acción
    private function getIcono($accion)
    {
        switch ($accion) {
            case 'DERIVADO':
                return '<i class="fas fa-arrow-circle-right bg-yellow"></i>';
            case 'ACEPTADO':
                return '<i class="fas fa-check bg-green"></i>';
            case 'RECHAZADO':
                return '<i class="fas fa-remove-format bg-red"></i>';
            case 'ARCHIVADO':
                return '<i class="fas fa-save bg-blue"></i>';
            default:
                return '<i class="fas fa-search-minus bg-info"></i>';
        }
    }

    // Método para obtener la preposición basada en la acción
    private function getPreposicion($accion)
    {
        return in_array($accion, ['ACEPTADO', 'RECHAZADO', 'ARCHIVADO','OBSERVADO']) ? "en" : "a";
    }
}
