<?php

class InformesController extends Controllers
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
            exit();
        }
        getPermisos(11);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }

        $data = [
            'page_id' => 12,
            'page_tag' => "Informes",
            'page_title' => "Informes",
            'file_js' => "informes.js"
        ];
        $this->views->getView("informes", "index", $data);
    }

    public function getReportTramites()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['rea']) {

                $estado = (isset($_POST['estado'])) ? limpiarCadena($_POST['estado']) : '0';
                $fecha = (isset($_POST['fecha'])) ? limpiarCadena($_POST['fecha']) : '0';
                $anio = (isset($_POST['anio'])) ? limpiarCadena($_POST['anio']) : '';
                $mes = (isset($_POST['mes'])) ? limpiarCadena($_POST['mes']) : '';
                $desde = (isset($_POST['desde'])) ? convertirfecha(limpiarCadena($_POST['desde'])) : '';
                $hasta = (isset($_POST['hasta'])) ? convertirfecha(limpiarCadena($_POST['hasta']))  : '';

                $strWhere = "";
                $arrValues = [];
                $descripcion = "";

                // Si el estado es diferente a TODOS
                if ($desde == '') {
                    // Si no hay FECHA entre rangos
                    if ($mes == '') {
                        // SI no existe MES
                        $strWhere = "and date_format(fecha_registro, '%Y')= ? "; //Para agregar a la consulta
                        $arrValues = [$anio]; //arrValues para agregar a la consulta
                        $descripcion = "Mostrando por Año: <b>" . $anio . "</b>"; //Detalle del reporte
                    } else {
                        // Existe MES
                        $strWhere = "and date_format(fecha_registro, '%Y')=? and date_format(fecha_registro, '%m')=? ";
                        $arrValues = [$anio, $mes];
                        $meses = [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre",
                        ];
                        $descripcion = "Mostrando por Año: <b>" . $anio . "</b> y Mes de: <b>" . $meses[$mes - 1] . "</b>";
                    }
                } else {
                    // Existe RANGO DE FECHAS
                    $strWhere = "and fecha_registro between ? and DATE_ADD(?, INTERVAL 1 DAY) ";
                    $arrValues = [$desde, $hasta];
                    $descripcion = "Mostrando por Fechas desde el: <b>" . $_POST['desde'] . "</b> hasta el: <b>" . $_POST['hasta'] . "</b>";
                }

                if ($fecha == '0') {
                    // SI QUIERE MOSTRAR TODOS 
                    $strWhere = "";
                    $arrValues = [];
                    $descripcion = "Mostrando <b>TODOS</b> los Trámites";
                }

                if ($estado != '0') {
                    // Existe ESTADO DE TRAMITE
                    $strWhere = $strWhere . " and estado= ?";
                    array_push($arrValues, $estado);
                    $descripcion = $descripcion . " con el Estado: <b>" . $estado . "</b>";
                }

                $arrData = $this->model->selectReportTramites($strWhere, $arrValues);
                $reportGenerator = new ReportGenerator();
                $reportGenerator->createReport($arrData, "Trámites", "landscape", -1, $descripcion, '75px');
            } else {
                echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        }
    }
}
