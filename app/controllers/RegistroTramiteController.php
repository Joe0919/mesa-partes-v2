<?php

class RegistroTramiteController extends Controllers
{
    private $personaModel;
    private $tramiteModel;
    public function __construct()
    {
        parent::__construct("Tramite"); //Importante tener Modelo
    }

    // Método para cargar la vista de acceso
    public function index()
    {
        $data = [
            'page_id' => 2,
            'page_tag' => "Registro Trámite",
            'page_title' => "Registro Trámite",
            'file_js' => "nuevoTramite.js",
        ];
        $this->views->getView("registro-tramite", "index", $data);
    }
    public function setTramite()
    {
        try {
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
                                $this->tramiteModel = $this->loadAdditionalModel("Tramite");
                                $arrInst = $this->tramiteModel->selectInstitucion();
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
            }
        } catch (ArgumentCountError $e) {
            echo json_encode([
                "status" => false,
                "title" => "Error en el servidor",
                "msg" => "Ocurrió un error. Revisa la consola para más detalles.",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function getSelectTipo()
    {
        $arrData = $this->model->selectTipo();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
}
