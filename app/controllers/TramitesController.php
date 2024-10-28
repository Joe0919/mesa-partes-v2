<?php

class TramitesController extends Controllers
{
    private $personaModel;

    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(6);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data = [
            'page_id' => 11,
            'page_tag' => "Trámites",
            'page_title' => "Trámites",
            'file_js' => "tramites.js",
        ];
        $this->views->getView("Tramites", "index", $data);
    }

    public function getTramites(string $idarea, string $area, string $estado)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramites($idarea, $area, $estado);

            $estadoColors = $this->getEstadoColors();

            foreach ($arrData as &$item) {
                $item['expediente'] = '<b>' . $item['expediente'] . '</b>';
                $colorClass = $estadoColors[$item['estado']] ?? $estadoColors['DEFAULT'];
                $item['Fecha'] = $this->getFechaBadge($item['Fecha']);

                $botones = '';

                if ($_SESSION['permisosMod']['upd']) {
                    switch ($item['estado']) {
                        case "PENDIENTE":
                            $botones .= '<button class="btn bg-gradient-success btn-sm btn-table btnAceptar" title="Aceptar/Rechazar"><i class="nav-icon fas fa-check"></i></button>';
                            break;
                        case "ACEPTADO":
                            $botones .= '<button class="btn bg-gradient-danger btn-sm btn-table btnDerivar" title="Derivar/Archivar"><i class="nav-icon fas fa-arrow-right"></i></button>';
                            break;
                    }
                }

                $btnView = '<button class="btn bg-gradient-info btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>';
                $btnHistory = '<button class="btn bg-gradient-secondary btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';

                $botones .= $btnView;
                $botones .= $btnHistory;

                $item['opciones'] = '<div class="text-center"><div class="btn-group">' . $botones . '</div></div>';

                $item['estado'] = '<span class="badge ' . $colorClass . '">' . $item['estado'] . '</span>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
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
    public function getSelectTipo()
    {
        $arrData = $this->model->selectTipo();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
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
    public function getFechas()
    {
        if ($_POST) {

            $opcion = limpiarCadena($_POST['opcion']);

            $anio =  isset($_POST['anio']) ? limpiarCadena($_POST['anio']) : '';

            switch ($opcion) {

                case 1:
                    $arrData = $this->model->selectAnios("date_format(fechad,'%Y')");
                    break;
                case 2:
                    if ($anio === '') {
                        $arrData = $this->model->selectAnios("date_format(fechad,'%m')");
                    } else {
                        $arrData = $this->model->selectAnios(
                            "date_format(fechad,'%m')",
                            "date_format(fechad,'%Y') = ?",
                            [$anio]
                        );
                    }
                    break;
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
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

                    $ruta_raiz = UPLOADS_PATH . 'docs/'; // RAIZ/public/files/docs/
                    $rutaFecha = date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 1/
                    $file_tmp_name = $documento['tmp_name'];

                    // Obtener el expediente
                    $expedienteData = $this->model->genExpediente();

                    // Acceder al número de expediente
                    $expediente = $expedienteData['Expediente'];

                    $nuevo_nombre = $ruta_raiz . $rutaFecha . 'doc_' . $expediente . '_' . date('dmY') . '_' . $dni . '.pdf';

                    if (!file_exists($ruta_raiz)) {
                        mkdir($ruta_raiz, 0777, true);
                    }
                    if (!file_exists($ruta_raiz . $rutaFecha)) {
                        mkdir($ruta_raiz . $rutaFecha, 0777, true);
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
                            <p class='p_name'>Se le envía este mensaje desde la plataforma para informarle que su trámite ha sido
                                 registrado con éxito por lo que se le da a conocer la información del trámite recepcionado:
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
                            <p>Para realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes
                                    Virtual</b> en
                                la pestaña <b><a href='" . base_url() . "/seguimiento'>Seguimiento</a></b>
                            </p>";

                            $arrInst = $this->model->selectInstitucion();
                            $response = $this->enviarCorreo("MESA DE PARTES VIRTUAL", $arrData['Datos'], $email, "TRÁMITE REGISTRADO CON ÉXITO", $html, $arrInst);

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
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        }
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
            $idusuario = intval(limpiarCadena($_POST['idusuario']));

            $request = '';

            // Controlar si se Acepta o Rechaza un Tramite
            if ($accion === 'ACEPTAR') {
                // Cambiamos el estado del documento a aceptado
                $request = $this->model->editarDocumento($expediente, 'ACEPTADO');
                // Guardamos la Aceptacion en el historial del doc
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'ACEPTADO', $origen);
                $arrResponse = array('status' => true, 'title' => 'Trámite Aceptado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            } else if ($accion === 'RECHAZAR') {
                // Validamos si en SECRETARIA se rechaza el tramite 
                if ($origen === 'SECRETARIA') {
                    // No es necesario Derivar a Secretaria, solo se rechaza
                    // Colocamos la descripcion por la que se esta Rechazando
                    $this->model->editarDerivacion($idderivacion, $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'RECHAZADO', $origen);
                } else {
                    // Se cumple que es otra area
                    // Derivamos el Tramite a Secretaria y este validara su ID
                    $this->model->registrarDerivacion($iddocumento, '', $origen, 'SECRETARIA', $descripcion);
                    // Guardamos el Rechazo en el historial del doc
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'RECHAZADO', $origen);
                    // Guardamos la Derivacion a SECRETARIA en el historial 
                    $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario);
                }
                // Cambiamos el estado del documento a RECHAZADO
                $request = $this->model->editarDocumento($expediente, 'RECHAZADO');
                $arrResponse = array('status' => true, 'title' => 'Trámite Rechazado', "msg" => 'La acción se realizó con exito.');
            } else {
                $request = $this->model->editarDocumento($expediente, 'OBSERVADO');
                // Guardamos la Aceptacion en el historial del doc
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'OBSERVADO', $origen);
                $arrData = $this->model->selectTramite($expediente, "");

                $html = "<p class='p_name'>Estimado(a): <b>" . $arrData['Datos'] . "</b></p>
                        <hr>
                        <p class='p_name'>Se le envía este mensaje desde la <b>Mesa de Partes Virtual.</b>
                            Para informarle que su trámite con Nro. Expediente <b>" . $arrData['nro_expediente'] . "</b>, 
                            con fecha de Registro: <b>" . $arrData['Fecha'] . "</b>
                            ha sido <b>OBSERVADO</b> por las siguiente observaciones:
                        </p>

                        <div class='div-msg'>
                            <ul>
                                <li class='li-msg'><b>Observaciones:</b> <span> " . $descripcion . "</span></li>
                            </ul>
                        </div>

                        <p>Puede levantar las observaciones ingresando <a href='" . base_url() . "/tramite/consultar/" . $expediente . "'>aqui</a> o puede volver a presentar nuevamente su
                            trámite una vez subsanado el motivo de la observación.
                        </p>";

                $arrInst = $this->model->selectInstitucion();
                $response = $this->enviarCorreo("MESA DE PARTES VIRTUAL", $arrData['Datos'], $arrData['email'], "TRÁMITE OBSERVADO", $html, $arrInst);
                // Cambiamos el estado del documento a observado
                $arrResponse = array('status' => true, 'title' => 'Trámite Observado', "msg" => 'La acción se realizó con exito.', 'data' => $response);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function putTramiteDerivacion()
    {
        if ($_POST) {
            $accion = limpiarCadena($_POST['accion']);
            $expediente = limpiarCadena($_POST['expediente']);
            $dni = limpiarCadena($_POST['dni']);
            $origen = strtoupper(limpiarCadena($_POST['origen']));
            $iddestino = isset($_POST['iddestino']) ? intval(limpiarCadena($_POST['iddestino'])) : '';
            $destino = limpiarCadena($_POST['destino']);
            $descripcion = strtoupper(limpiarCadena($_POST['descripcion']));
            $idusuario = intval(limpiarCadena($_POST['idusuario']));

            $request = '';

            if ($accion === '1') {
                // Derivamos el Tramite al Area Destino
                $this->model->registrarDerivacion(0, $expediente, $origen, $iddestino, $descripcion);
                // Cambiamos el estado  a PENDIENTE ya actualizamos la ubicacion del doc
                $this->model->editarDocumento($expediente, 'PENDIENTE', $iddestino);
                // Guardamos la Derivacion en el historial 
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'DERIVADO', $destino);
                $request = $accion . ' ' . $expediente . ' ' . $dni . ' ' . $origen . ' ' . $destino . ' ' . $descripcion;
                $arrResponse = array('status' => true, 'title' => 'Trámite Derivado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            } else if ($accion === '2') {
                // Cambiamos el estado  a ARCHIVADO ya actualizamos la ubicacion del doc
                $this->model->editarDocumento($expediente, 'ARCHIVADO');
                // Guardamos la Archivacion en el historial 
                $this->model->registrarHistorial($expediente, $dni, $descripcion, $idusuario, 'ARCHIVADO', $origen);
                $arrResponse = array('status' => true, 'title' => 'Trámite Archivado', "msg" => 'La acción se realizó con exito.', 'data' => $request);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}
