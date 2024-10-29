<?php

class TramiteController extends Controllers
{
    private $tramiteModel;
    public function __construct()
    {
        //Importante tener Modelo o solo colocar ''
        parent::__construct("Tramite");
    }

    // Método para cargar la vista de acceso
    public function consultar($expediente = null)
    {

        if (!is_null($expediente)) {

            $Expediente = limpiarCadena($expediente);
            $arrData = $this->model->selectTramite($Expediente);

            // Verificamos si $arrData es un arreglo antes de intentar acceder a sus índices
            if (is_array($arrData) && isset($arrData['estado'])) {
                if ($arrData['estado'] === 'OBSERVADO') {
                    $data = [
                        'page_id' => 17,
                        'page_tag' => "Datos de Trámite",
                        'page_title' => "Datos de Trámite",
                        'file_js' => "tramite.js",
                        'param' => $expediente
                    ];
                    $this->views->getView("tramite", "index", $data);
                } else {
                    require_once "app/controllers/ErrorController.php";
                    exit();
                }
            } else {
                require_once "app/controllers/ErrorController.php";
                exit();
            }
        } else {
            require_once "app/controllers/ErrorController.php";
            exit();
        }
    }

    public function getTramite(string $expediente)
    {
        $Expediente = limpiarCadena($expediente);
        if ($Expediente != '') {
            $arrData = $this->model->selectTramiteObs($Expediente);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['status' => false, 'title' => 'Error', 'msg' => 'Nro. Expediente Invalido.'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function putTramite()
    {
        try {
            if ($_POST) {
                if (
                    empty($_POST['expediente']) ||
                    empty($_POST['itipo']) ||
                    empty($_POST['n_doc']) ||
                    empty($_POST['ifolios']) ||
                    empty($_POST['iasunto']) ||
                    empty($_POST['ruta']) ||
                    empty($_POST['dni']) ||
                    empty($_POST['email']) ||
                    empty($_FILES['ifile'])
                ) {
                    $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
                } else {
                    $expediente = limpiarCadena($_POST['expediente']);
                    $idtipo = intval(limpiarCadena($_POST['itipo']));
                    $ndoc = limpiarCadena($_POST['n_doc']);
                    $folios = intval(limpiarCadena($_POST['ifolios']));
                    $asunto = limpiarCadena($_POST['iasunto']);
                    $documento = $_FILES['ifile'];
                    $ruta = limpiarCadena($_POST['ruta']);

                    $dni = limpiarCadena($_POST['dni']);
                    $email = limpiarCadena($_POST['email']);

                    $ruta_raiz = BASE_PATH . 'public/'; // RAIZ/public

                    $ruta_aux = substr($ruta, 0, strrpos($ruta, '/'));

                    $file_tmp_name = $documento['tmp_name'];

                    if (!file_exists($ruta_raiz)) {
                        mkdir($ruta_raiz, 0777, true);
                    }
                    if (!file_exists($ruta_raiz . $ruta_aux . '/')) {
                        mkdir($ruta_raiz . $ruta_aux, 0777, true);
                    }

                    //Reemplzamos el archivo existente
                    if (move_uploaded_file($file_tmp_name, $ruta_raiz . $ruta)) {

                        // editar documento
                        $this->model->editarTramiteObs($expediente, $ndoc, $folios, $asunto, $idtipo);

                        $this->model->editarDocumento($expediente, 'PENDIENTE');

                        $this->model->registrarHistorial($expediente, $dni, 'LEVANTAMIENTO DE OBSERVACIONES', '0');

                        $arrData = $this->model->selectTramite($expediente, "");

                        $html = "<p class='p_name'>Estimado(a): <b>" . $arrData['Datos'] . "</b></p>
                            <hr>
                            <p class='p_name'>Se le envía este mensaje desde la <b>Mesa de Partes Virtual.</b>
                                Para informarle que su trámite con Nro. Expediente <b>" . $arrData['nro_expediente'] . "</b>, 
                                ha sido registrado con fecha y hora: <b>" . date('d/m/Y h:ia') . "</b>
                                con la subsanación de las observaciones correspondientes que realizó
                            </p>
                 
                            <p>Para realizar el seguimiento de su trámite puede ingresar a la plataforma de la <b>Mesa de Partes
                                    Virtual</b> en
                                la pestaña <b><a href='" . base_url() . "/seguimiento'>Seguimiento</a></b>
                            </p>";

                        $this->tramiteModel = $this->loadAdditionalModel("Tramite");
                        $arrInst = $this->tramiteModel->selectInstitucion();
                        $response = $this->enviarCorreo("MESA DE PARTES VIRTUAL", $arrData['Datos'], $email, "TRÁMITE REGISTRADO CON ÉXITO", $html, $arrInst);

                        $arrResponse = array('status' => true, 'title' => 'Trámite Registrado', "msg" => 'Será redirigido a Inicio automaticamente', 'data' => $arrData, 'response' => $response);
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar el pdf.');
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
}
