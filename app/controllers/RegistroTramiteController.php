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
                    $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar el formulario.');
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
                    $asunto = strtoupper(limpiarCadena($_POST['iasunto']));
                    $documento = $_FILES['ifile'];

                    $request_persona = '';
                    $ruta_pdf = "";

                    if ($idpersona != "") {

                        $ruta_raiz = UPLOADS_PATH . 'docs/'; // RAIZ/public/files/docs/
                        $rutaFecha = date('Y') . '/' . date('m') . '/' . date('d') . '/'; // 1/
                        $file_tmp_name = $documento['tmp_name'];

                        $expedienteData = $this->model->genExpediente();

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
                                // El Cuarto parametro 'SECRETARIA' ya que buscamos esa area sino cualquier otro ID de area
                                $this->model->registrarDerivacion($iddocumento, '', 'EXTERIOR', 'SECRETARIA', 'DERIVANDO A SECRETARIA');

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
