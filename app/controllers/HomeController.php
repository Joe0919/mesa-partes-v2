<?php

class HomeController extends Controllers
{
    private $personaModel;
    public function __construct()
    {
        parent::__construct("Tramite"); //Importante tener Modelo
    }

    // Método para cargar la vista de acceso
    public function index()
    {
        $data = [
            'page_id' => 13,
            'page_tag' => "Inicio",
            'page_title' => "Inicio",
            'file_js' => "nuevoTramite.js",
            'file1_js' => "busqueda.js"
        ];
        $this->views->getView("Home", "home", $data);
    }
    public function setTramite()
    {
        if ($_POST) {
            if (
                empty($_POST['idni']) ||
                empty($_POST['inombre']) ||
                empty($_POST['iappat']) ||
                empty($_POST['iapmat']) ||
                empty($_POST['iemail']) ||
                empty($_POST['idir']) ||
                empty($_POST['icel']) ||
                empty($_POST['itipo']) ||
                empty($_POST['n_doc']) ||
                empty($_POST['ifolios']) ||
                empty($_FILES['ifile'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
            } else {
                $idpersona = limpiarCadena($_POST['idpersona']);
                $idusuario = intval(limpiarCadena($_POST['idusuario']));
                $dni = limpiarCadena($_POST['idni']);
                $ruc = limpiarCadena($_POST['iruc']);
                $entidad = strtoupper(limpiarCadena($_POST['ientidad']));
                $dni = limpiarCadena($_POST['idni']);
                $nombres = strtoupper(limpiarCadena($_POST['inombre']));
                $appat = strtoupper(limpiarCadena($_POST['iappat']));
                $apmat = strtoupper(limpiarCadena($_POST['iapmat']));
                $email = limpiarCadena($_POST['iemail']);
                $direccion = strtoupper(limpiarCadena($_POST['idir']));
                $cel = limpiarCadena($_POST['icel']);
                $idtipo = intval(limpiarCadena($_POST['itipo']));
                $ndoc = limpiarCadena($_POST['n_doc']);
                $folios = intval(limpiarCadena($_POST['ifolios']));
                $asunto = limpiarCadena($_POST['iasunto']);
                $documento = $_FILES['ifile'];

                $request_persona = '';
                $ruta_pdf = "";

                if ($idpersona != "") {

                    $ruta_aux = UPLOADS_PATH . 'docs/'; // RAIZ/public/files/docs/
                    $rutaFecha = date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 1/
                    $file_tmp_name = $documento['tmp_name'];

                    // Obtener el expediente
                    $expedienteData = $this->model->genExpediente();

                    // Acceder al número de expediente
                    $expediente = $expedienteData['Expediente'];

                    $nuevo_nombre = $ruta_aux . $rutaFecha . 'doc_' . $expediente . '_' . date('dmY') . '_' . $dni . '.pdf';

                    if (!file_exists($ruta_aux)) {
                        mkdir($ruta_aux, 0777, true);
                    }
                    if (!file_exists($ruta_aux . $rutaFecha)) {
                        mkdir($ruta_aux . $rutaFecha, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
                        $ruta_pdf = 'files/docs/' . $rutaFecha . 'doc_' . $expediente . '_' . date('dmY') . '_' . $dni . '.pdf';

                        $this->personaModel = $this->loadAdditionalModel("Persona");

                        if ($idpersona == '0') {
                            $request_persona = $this->personaModel->insertPersona($dni, $appat, $apmat, $nombres, $email, $cel, $direccion, $ruc, $entidad);
                        } else {
                            $this->personaModel->editarPersona($email, $cel, $dni);
                            $request_persona = $idpersona;
                        }

                        if ($request_persona == 'exist') {
                            $arrResponse = array("status" => false, "title" => "Error", "msg" => 'Datos duplicados.');
                        } else {
                            $iddocumento = $this->model->registrarDocumento($expediente, $ndoc, $folios, $asunto, $ruta_pdf, $request_persona, $idtipo);
                            $this->model->registrarHistorial($expediente, $dni, 'INGRESO DE NUEVO TRÁMITE', $idusuario);

                            $this->model->registrarDerivacion($iddocumento, '', 'EXTERIOR', '8', 'DERIVANDO A SECRETARIA');

                            $arrData = $this->model->selectTramite($expediente, "");

                            $html = "<p class='p_name'>Estimado(a): <b>" . $arrData['Datos'] . "</b></p>
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
                                        <th style='width: 40%;'>N° Expediente</th>
                                        <td>" . $arrData['nro_expediente'] . "</td>
                                    </tr>
                                    <tr>
                                        <th>N°. Documento</th>
                                        <td>" . $arrData['nro_doc'] . "</td>
                                    </tr>
                                    <tr>
                                        <th>Tipo Documento</th>
                                        <td>" . $arrData['tipodoc'] . "</td>
                                    </tr>
                                    <tr>
                                        <th>Remitente</th>
                                        <td>" . $arrData['Datos'] . "</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha</th>
                                        <td>" . $arrData['Fecha'] . "</td>
                                    </tr>
                                </table>
                            </div>                   
                            <p>Puede realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes
                                    Virtual</b> en
                                la pestaña <b><i>Seguimiento</i></b>
                            </p>";

                            $response = $this->enviarCorreo("MESA DE PARTES VIRTUAL", $arrData['Datos'], $email, "TRÁMITE REGISTRADO CON ÉXITO", $html);

                            $arrResponse = array('status' => true, 'title' => 'Trámite Registrado', "msg" => 'Su trámite se guardo con éxito.', 'data' => $arrData, 'response' => $response);
                        }
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar el pdf.');
                    }
                } else {
                    $arrResponse = array("status" => false, "title" => "Error", "msg" => 'Falta el ID de la persona.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getSelectTipo()
    {
        $arrData = $this->model->selectTipo();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
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
            die();
        }

        echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
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
                            <span style="font-size:18px" class="time"><i class="fas fa-clock"></i> {$data['hora']}</span>
                            <h3 style="font-size:18px" class="timeline-header">El trámite fue <b class="text-primary">{$data['accion']}</b> {$preposicion}
                                <b class="text-primary">{$data['area']}</b> el <b class="text-muted">{$data['fecha1']}</b></h3>
                            <div style="font-size:15px" class="timeline-body">
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
                return '';
        }
    }

    // Método para obtener la preposición basada en la acción
    private function getPreposicion($accion)
    {
        return in_array($accion, ['ACEPTADO', 'RECHAZADO', 'ARCHIVADO']) ? "en" : "a";
    }
}
