<?php

class BusquedaController extends Controllers
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
        getPermisos(10);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 11;
        $data['page_tag'] = "Busqueda";
        $data['page_title'] = "Busqueda";
        $data['file_js'] = "busqueda.js";
        $this->views->getView("busqueda", "index", $data);
    }

    public function getTramite()
    {
        if ($_POST) {
            if (
                empty($_POST['expediente']) ||
                empty($_POST['dni']) ||
                empty($_POST['anio'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
            } else {
                $expediente = limpiarCadena($_POST['expediente']);
                $dni = limpiarCadena($_POST['dni']);
                $anio = limpiarCadena($_POST['anio']);
                if ($expediente != '' &&  $dni != '' & $anio != '') {
                    $arrData = $this->model->selectTramitexAnio($expediente, $dni, $anio);
                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                    } else {
                        $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
                    }
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        die();
    }
    public function getHistorialTramite()
    {
        if ($_POST) {
            if (
                empty($_POST['expediente']) ||
                empty($_POST['dni']) ||
                empty($_POST['anio'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
            } else {
                $expediente = limpiarCadena($_POST['expediente']);
                $dni = limpiarCadena($_POST['dni']);
                $anio = limpiarCadena($_POST['anio']);
                if ($expediente != '' &&  $dni != '' & $anio != '') {
                    $arrData = $this->model->selectHistorial($expediente, $dni, $anio);
                    if (empty($arrData)) {
                        $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                    } else {
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
                            $icono = '';
                            $preposicion = '';
                    
                            switch ($data['accion']) {
                                case 'DERIVADO':
                                    $icono = '<i class="fas fa-arrow-circle-right bg-yellow"></i>';
                                    $preposicion = "a";
                                    break;
                                case 'ACEPTADO':
                                    $icono = '<i class="fas fa-check bg-green"></i>';
                                    $preposicion = "en";
                                    break;
                                case 'RECHAZADO':
                                    $icono = '<i class="fas fa-remove-format bg-red"></i>';
                                    $preposicion = "en";
                                    break;
                                case 'ARCHIVADO':
                                    $icono = '<i class="fas fa-save bg-blue"></i>';
                                    $preposicion = "en";
                                    break;
                            }
                    
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
                    
                        $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $timelineHtml);
                    }
                    
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        die();
    }
}
