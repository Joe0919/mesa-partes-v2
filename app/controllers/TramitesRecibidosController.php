<?php
// El idioma predeterminado para la conversación es español, a menos que se mencione un idioma específico.
class TramitesRecibidosController extends Controllers
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
        getPermisos(8);
    }

    // Método para cargar la vista de trámites recibidos
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        $data = [
            'page_id' => 9,
            'page_tag' => "Trámites Recibidos",
            'page_title' => "Trámites Recibidos",
            'file_js' => "tramitesRecibidos.js"
        ];
        $this->views->getView("tramites-recibidos", "index", $data);
    }

    // Método para obtener trámites recibidos
    public function getTramites($idarea, $area, $estado)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesRecibidos($area, $estado, $idarea);
            $estadoColors = $this->getEstadoColors();
            foreach ($arrData as &$item) {
                $item = $this->formatTramiteItem($item, $estadoColors);
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
        die();
    }

    // Método para formatear un ítem de trámite
    private function formatTramiteItem($item, $estadoColors)
    {
        $item['expediente'] = '<b>' . $item['expediente'] . '</b>';
        $botones = $this->generateTramiteButtons($item['estado']);
        $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];
        $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';
        $item['Fecha'] = $this->getFechaBadge($item['Fecha']);
        $item['opciones'] = '<div class="text-center"><div class="btn-group">' . $botones . '</div></div>';
        return $item;
    }

    // Método para obtener colores de estado
    private function getEstadoColors()
    {
        return [
            'PENDIENTE' => 'bg-black font-p',
            'ACEPTADO'  => 'bg-success font-p',
            'DERIVADO'  => 'bg-primary font-p',
            'RECHAZADO' => 'bg-danger font-p',
            'DEFAULT'   => 'bg-info font-p'
        ];
    }

    // Método para generar botones de trámite
    private function generateTramiteButtons($estado)
    {
        $botones = '';
        if ($_SESSION['permisosMod']['upd']) {
            switch ($estado) {
                case "PENDIENTE":
                    $botones .= '<button class="btn btn-success btn-sm btn-table btnAceptar" title="Aceptar/Rechazar"><i class="nav-icon fas fa-check"></i></button>';
                    break;
                case "ACEPTADO":
                    $botones .= '<button class="btn btn-danger btn-sm btn-table btnDerivar" title="Derivar/Archivar"><i class="nav-icon fas fa-arrow-right"></i></button>';
                    break;
            }
        }
        $botones .= '<button class="btn btn-info btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>
                     <button class="btn btn-warning btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';
        return $botones;
    }
    //Metodo para obtener datos de un tramite
    public function getTramite(string $expediente)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $Expediente = limpiarCadena($expediente);
            if ($Expediente != '') {
                $arrData = $this->model->selectTramite($Expediente, "");
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function putTramiteAceptacion()
    {
        if ($_POST) {
            $accion = limpiarCadena($_POST['accion']);
            $iddocumento = intval(limpiarCadena($_POST['iddocumento']));
            $idderivacion = intval(limpiarCadena($_POST['idderivacion']));
            $dni = limpiarCadena($_POST['dni']);
            $expediente = limpiarCadena($_POST['expediente']);
            $origen = strtoupper(limpiarCadena($_POST['origen']));
            $descripcion = strtoupper(limpiarCadena($_POST['descripcion']));

            $request = '';

            // Controlar si se Acepta o Rechaza un Tramite
            if ($accion === 'ACEPTAR') {
                // Cambiamos el estado del documento a aceptado
                $request = $this->model->editarDocumento($expediente, 'ACEPTADO');
                // Guardamos la Aceptacion en el historial del doc
                $this->model->registrarHistorial($expediente, $dni, $descripcion, 'ACEPTADO', $origen);
                $arrResponse = array('status' => true, 'title' => 'Trámite Aceptado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            } else if ($accion === 'RECHAZAR') {
                // Validamos si en SECRETARIA se rechaza el tramite 
                if ($origen === 'SECRETARIA') {
                    // No es necesario Derivar a Secretaria, solo se rechaza
                    // Colocamos la descripcion por la que se esta Rechazando
                    $this->model->editarDerivacion($idderivacion, $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, 'RECHAZADO', $origen);
                } else {
                    // Se cumple que es otra area
                    // Derivamos el Tramite a Secretaria sabiendo su ID
                    $this->model->registrarDerivacion($iddocumento, '', $origen, '8', $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, 'RECHAZADO', $origen);
                    // Guardamos la Derivacion a SECRETARIA en el historial 
                    $this->model->registrarHistorial($expediente, $dni, $descripcion);
                }
                // Cambiamos el estado del documento a RECHAZADO
                $request = $this->model->editarDocumento($expediente, 'RECHAZADO');
                $arrResponse = array('status' => true, 'title' => 'Trámite Rechazado', "msg" => 'La acción se realizó con exito.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function getSelectDestino()
    {
        if ($_POST) {

            $area = limpiarCadena($_POST['area']);

            $arrData = $this->model->selectAreaDestino($area);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
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
